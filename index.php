<?php 
  $mapLink = "http://upload.wikimedia.org/wikipedia/en/1/18/Baynes-Map_of_Middle-earth.jpg";
  $swBounds = "(-33.28461996888768, -25.3125)";
  $neBounds = "(18.35452552912664, 13.271484375)";
  $mapCenter = "(-8.754794702435605, -6.767578125)";
  $imageWidth = "880";
  $imageHeight = "1224";
  $sLat = 0;
  $sLng = 0;
  $zoom = 1;
?>

          <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script>
          var marker;
            var typeOptions = {
              getTileUrl: function(coord, zoom) {
                return '<?=$mapLink?>';
              },
              tileSize: new google.maps.Size(<?= $imageWidth;?>, <?= $imageHeight;?>),
              maxZoom: 5,
              minZoom: 5,
          };
          var mapType = new google.maps.ImageMapType(typeOptions);
          var allowedBounds = new google.maps.LatLngBounds(
               new google.maps.LatLng<?= $swBounds;?>,
               new google.maps.LatLng<?= $neBounds;?> 
          );

          function initialize() {
            var myLatlng = new google.maps.LatLng<?= $mapCenter;?>;
              var mapOptions = {
                center: myLatlng,
                zoom: 5,
                streetViewControl: false,
                disableDefaultUI: true,
                mapTypeControlOptions: {
                  mapTypeIds: ['stores']
                }
              };
              var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
            map.mapTypes.set('stores', mapType);
            map.setMapTypeId('stores');
            lastValidCenter = new google.maps.LatLng<?= $mapCenter;?>;
            google.maps.event.addListener(map, 'center_changed', function(event) {
              document.getElementById('mapCenter').value = map.getCenter();
                  if (allowedBounds.contains(map.getBounds().getSouthWest()) && 
                         allowedBounds.contains(map.getBounds().getNorthEast())) {
                      lastValidCenter = map.getCenter();
                      return;
                  }
              // not valid anymore => return to last valid position
              map.panTo(lastValidCenter);

            });
            google.maps.event.addListener(map,'click',function(event) {
              if (allowedBounds.contains(event.latLng)) {
                  // still within valid bounds, set center
                  map.setCenter(event.latLng);
              }
              placeMarker(map,event.latLng);
            
            });
              placeMarker(map, new google.maps.LatLng(<?= $sLat;?>, <?= $sLng;?>));
          }
          google.maps.event.addDomListener(window, 'load', initialize);
          function placeMarker(map,location){
            console.log(location);
              if(marker){
                marker.setPosition(location);
              }
              else{
                 var pinIcon = new google.maps.MarkerImage(
                    "#iconLink#",
                    null,
                    null,
                    null,
                    new google.maps.Size(50, 50));
                marker = new google.maps.Marker({
                  position:location,
                  map: map,
                  title:"Calvin Klein"
                });
                marker.setIcon(pinIcon);
              }
            document.getElementById('bGeo').value = 1;
            document.getElementById('geoLat').value = location.lat();
            document.getElementById('geoLong').value = location.lng();
            document.getElementById('mapCenter').value = map.getCenter();
          }

        </script>
        <style type="text/css">
        #map-canvas, #map_canvas {
          width: 800px;
          height: 450px;
        }
        </style>
        <div id="map-canvas"></div>
        <input  name="geoLat" id="geoLat" value="#arguments.latitude#"  size=100/><br/>
        <input  name="geoLong" id="geoLong" value="#arguments.longitude#"  size=100/><br/>
        <input  name="mapCenter" id="mapCenter" value="#arguments.center#" size=100 /><br/>
        <input  name="bGeo" id="bGeo" value="#arguments.bGeo#" /><br/>

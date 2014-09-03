<?php
	$mapLink = "http://upload.wikimedia.org/wikipedia/en/1/18/Baynes-Map_of_Middle-earth.jpg";
		$html = "" ;
		  $imgWidth = "880";
  $imgHeight = "1224";
		$sLat = 0 ;
		$sLng = 110;
		$zoom = 13 ;
		$placeMarker = false;
		  $swBounds = "(-40.94671366508001, -91.40625)";
  $neBounds = "(27.293689224852404, -3.6474609375)";
    $mapCenter = "(9.535748998133627, -33.1787109375)";
?>
				<style type="text/css">
					#map-canvas, #map_canvas {
				  width: 800px;
				  height: 450px;
				}
				</style>
			   	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
				<script>
				function setBound(bound){
					document.getElementById("stored_"+bound).value = document.getElementById(bound).value;
				}
				var marker;
				  var typeOptions = {
				  getTileUrl: function(coord, zoom) {
				      return '<?=$mapLink;?>';
				  },
				  tileSize: new google.maps.Size(<?= $imgWidth;?>, <?=$imgHeight;?>),
				  maxZoom: 5,
				  minZoom: 5,
				};
 					var mapType = new google.maps.ImageMapType(typeOptions);

					function initialize() {
						var myLatlng = new google.maps.LatLng(0,0);
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
						var lastValidCenter = map.getCenter();
						google.maps.event.addListener(map, 'center_changed', function(event) {
   						  document.getElementById('swBounds').value = map.getBounds().getSouthWest();
   						  document.getElementById('neBounds').value = map.getBounds().getNorthEast();
   						  document.getElementById('center').value = map.getCenter();
						});
					}
					google.maps.event.addDomListener(window, 'load', initialize);


 				</script>
 				<div id="map-canvas"></div>
				<a href="#" onclick="setBound('swBounds');">Set Bottom Left</a>
				<input type="text" name="swBounds" id="swBounds" value="<?=$swBounds;?>" /><br/>
				<a href="#" onclick="setBound('neBounds');">Set Top Right</a>
				<input type="text" name="neBounds" id="neBounds" value="<?=$neBounds;?>" /><br/>
				<a href="#" onclick="setBound('center');">Set center</a>
				<input type="text" name="center" id="center" value="<?=$mapCenter;?>" /><br/>
				<input  name="stored_swBounds" id="stored_swBounds" value="" size="100"/><br/>
				<input  name="stored_neBounds" id="stored_neBounds" value="" size="100"/><br/>
				<input  name="stored_center" id="stored_center" value="" size="100"/><br/>


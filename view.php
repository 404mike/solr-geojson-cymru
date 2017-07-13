<!DOCTYPE html>
<html>
  <head>
    <style>
      #map {height: 100%;}
      html, body {height: 100%;margin: 0;padding: 0;}
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: new google.maps.LatLng( 52.410777,-3.564453),
          mapTypeId: 'terrain'
        });

        // get places from solr search
        map.data.loadGeoJson('get.php?place=<?php echo $_GET['place']; ?>');

        // get geoJson of place
        map.data.loadGeoJson('places/<?php echo $_GET['place']; ?>');
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=initMap">
    </script>
  </body>
</html>
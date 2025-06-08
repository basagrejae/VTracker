<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <title>VTracker</title>
    <style>
    #map {
      height: 90vh;
      width: 100%;
    }
    </style>
</head>
<body>
  <h2>Live Location Tracker</h2>
  <div id="map"></div>

  <script>
    let map, marker;

    function initMap() {
      const initialPosition = { lat: 0, lng: 0 };
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: initialPosition
      });

      marker = new google.maps.Marker({
        position: initialPosition,
        map: map,
        title: "Current Location"
      });

      updateLocation();
      setInterval(updateLocation, 5000); // Refresh every 5 seconds
    }

    function updateLocation() {
      fetch("get_latest_location.php")
        .then(response => response.json())
        .then(data => {
          if (!data.latitude || !data.longitude) return;

          const position = {
            lat: parseFloat(data.latitude),
            lng: parseFloat(data.longitude)
          };

          marker.setPosition(position);
          map.setCenter(position);
        });
    }
  </script>

  <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvucFemn8NRHaDqJvYRsK2sbkZBeIj4gw&callback=initMap">
  </script>
</body>
</html>
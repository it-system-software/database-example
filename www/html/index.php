<!DOCTYPE html>
<html lang="en">
<head>
	<base target="_top">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Simple Map with Leaflet</title>
  <!-- based on example at https://leafletjs.com/examples/quick-start/ -->

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		.leaflet-container {
			height: 100vh;
			width: 100vw;
			max-width: 100%;
			max-height: 100%;
		}
    #map {
      height: 100vh;
      width: 100vw;
    }
	</style>
</head>
<body>

<div id="map"></div>
<script>

  const map = L.map('map').setView([52.515139, 13.468023], 2);
  
  const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);
  
  L.marker([52.515139, 13.468023]).addTo(map).bindPopup('<b>Hello from IU Berlin</b>').openPopup();
  
<?php 
  # get markers from MariaDB
  $conn = new mysqli("mariadb", "root", "IU2026", "itsyssoftware");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  # create markers table if not exists
  $sql = "CREATE TABLE IF NOT EXISTS markers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lat DECIMAL(10,8) NOT NULL,
    lng DECIMAL(11,8) NOT NULL,
    popup TEXT(4096) NOT NULL
  )";
  if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
  }

  $sql = "SELECT lat, lng, popup FROM markers";
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc()) {
    echo "L.marker([" . $row["lat"] . ", " . $row["lng"] . "]).addTo(map).bindPopup('" . $row["popup"] . "');\n";
  }

  $conn->close();
?>

	function onMapClick(e) {
    L.popup().setLatLng(e.latlng)
			.setContent("Add marker here?<form method='post' action='add-marker.php'><input type='hidden' name='lat' value='" + e.latlng.lat + "'><input type='hidden' name='lng' value='" + e.latlng.lng + "'>Popup text: <input type='text' name='popup'><br><input type='submit' value='Add Marker'></form>")
			.openOn(map);
	}

	map.on('click', onMapClick);
</script>

</body>
</html>




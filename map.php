<?php session_start();
if (isset($_SESSION["login"]) != "pass") {
     //header("Location: https://getxy2020.herokuapp.com/");
     header("Location: http://localhost/coordinatexy/");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CoordinateXY</title>
    <link rel="shortcut icon" href="assets/images/saladin.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/custom_ui.css">
    <link rel="stylesheet" href="assets/css/custom_avatar.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/fonts/kanit.css">
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/vue2.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body onload="initialize_map(); add_map_point_2();">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="assets/images/route.svg" width="50" alt="">CoordinateXY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="house.php">Register <span class="sr-only">(current)</span></a>
                </li>
                <?php if ($_SESSION["group"] == "99"): ?>
                <li class="nav-item">
                    <a class="nav-link" href="user.php">User <span class="sr-only">(current)</span></a>
                </li>
                <?php endif;?>
                <li class="nav-item">
                    <a class="nav-link" href="map.php">Map</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="loader.php?page=logout">logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <div class="container-fluid">
        <div class="text-left">
            <h6><span class="badge badge-dark"><?php echo $_SESSION["full_name"] . ' | ' . $_SESSION["department"]; ?>
                </span></h6>
        </div>
        <div class="row">
            <div id="app_map">
                <div id="map" style="width: 100vw; height: 100vh;"></div>
            </div>
        </div>
    </div>
</body>

<script src="front/constant.js"></script>
<script src="front/Map/map.js"></script>
<script>
/* OSM & OL example code provided by https://mediarealm.com.au/ */
var map;
var mapLat = v_map.position.length > 0 ? v_map.position[0].x : 0;
var mapLng = v_map.position.length > 0 ? v_map.position[0].y : 0;
var mapDefaultZoom = 10;

function initialize_map() {
    map = new ol.Map({
        target: "map",
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM({
                    url: "https://a.tile.openstreetmap.org/{z}/{x}/{y}.png"
                })
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([mapLng, mapLat]),
            zoom: mapDefaultZoom
        })
    });
}

function add_map_point_2() {
    console.log(v_map.position.length)
    for (let i = 0; i < v_map.position.length; i++) {
        var vectorLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.transform([parseFloat(v_map
                            .position[i].x),
                        parseFloat(
                            v_map.position[i].y)
                    ], 'EPSG:4326', 'EPSG:3857')),
                })]
            }),
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 0.5],
                    anchorXUnits: "fraction",
                    anchorYUnits: "fraction",
                    src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
                })
            })
        });
        map.addLayer(vectorLayer);
    }

}

function add_map_point(lat, lng) {

    var vectorLayer = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lng), parseFloat(
                    lat)], 'EPSG:4326', 'EPSG:3857')),
            })]
        }),
        style: new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 0.5],
                anchorXUnits: "fraction",
                anchorYUnits: "fraction",
                src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
            })
        })
    });
    map.addLayer(vectorLayer);
}
</script>

</html>
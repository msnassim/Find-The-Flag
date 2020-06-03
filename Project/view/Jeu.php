<?php require("header.php"); ?>
    <title> Jeu des drapeaux</title>
<?php require("navbar.php"); ?>
<html lang="fr">
	<head>
		<title>Leaflet.js avec couche Stamen Watercolor</title>
		<meta charset="utf-8" />
        <link rel="stylesheet" href="../model/style/accueil.css">
		<link rel="stylesheet" href="../model/style/style.css"/>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
	<body id="body1">
	<div class="d-flex flex-row">
		<div id="div1" class="p-2">
			<h2 class="text-center">Veuillez indiquer le pays correspondant au drapeau !<h2>
			<h4 class="text-center" id="question"></h4>
				<img id ="flag" src =" " width="200px" height="150px"/>
				<br>
				<br>
				<div class="text-center">
					<h3 id="bravo"></h3>
						<h1 id="score">0</h1>
				</div>
				<div>
					<img id="img" src=" " />
					<p id="description"></p>
				</div>
		</div>
		<div id="div2" class="p-2 qst2">
			<div id="map_div"></div>
			<div class="d-flex justify-content-between mb-3" style="padding-top:10px;">
                <div class="p-2 "><span id="compteur" class="rounded-circle btn-primary btn-lg">0/7</span></div>
                <div class="p-2"><a style="broder-raduis: 20px;" href="jeu.php" class="btn btn-primary btn-lg" >Rejoueur</a></div>
                <div class="p-2">
                    <button type="button" class="btn btn-primary btn-lg">Question suivante</button></div>
                </div>
		    </div>
	</div>
	<script>
       
        var Game = function() {
            this.questionnaire = []; // questionnaire json
        };

        Game.prototype.initializeInterface = function() {

            this.map = new L.Map('map_div', {
                center: Game.center,
                minZoom: Game.MinZoom,
                maxZoom: Game.maxZoom,
                zoom: 5,
                maxBounds: Game.bounds,
                doubleClickZoom: false
            });
            // Initialisation de la couche StamenWatercolor
            this.coucheStamenWatercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
                attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                subdomains: 'abcd',
                ext: 'jpg'
            }).addTo(this.map);;

            this.$score = $('#score');
            this.$image = $('#image');
        }

        // bornes pour empecher la carte StamenWatercolor de "dériver" trop loin...
        Game.bounds = L.latLngBounds(L.latLng(90, -180), L.latLng(-90, 180));
        Game.MaxZoom = 5;
        Game.MinZoom = 2;
        Game.center =  L.latLng(50, 10);


        // Juste pour changer la forme du curseur par défaut de la souris
        document.getElementById('map_div').style.cursor = 'crosshair'

        Game.prototype.resetMapView = function() {
            this.map.setView(Game.mapCenter, Game.minZoom, {
                animation: true
            });
        };
        // Fonction de conversion au format GeoJSON
        function coordGeoJSON(latlng, precision) {
            return '[' +
                L.Util.formatNum(latlng.lng, precision) + ',' +
                L.Util.formatNum(latlng.lat, precision) + ']';
        }
        function mouseoverhandle(e){
				var layer = e.target;
				layer.setStyle(
					{
						weight : 4,
						color : 'blue',
						fillColor : 'cyan',
						fillOpacity : 1
					}
				);
			}
			
        function resetlay(e){
            Layer.resetStyle(e.target);
        }
        
        function mousehandle(a, layer){
            layer.on(
                {
                    mouseover : mouseoverhandle,
                    mouseout : resetlay,
                    click : onMapClick,
                }
            );
        }
        function styles(a){
            return {
                fillColor : 'white',
                weight : 1,
                color : 'black',
                fillOpacity : 1
            }
        }

        $("a").hide();
        var nbrQuestionCorrect = 0;
        var index = 0;
        var popup = L.popup();
        var circle;
        var correct;
        var tab = new Array();
        var p;
        var compteur = Boolean(1);
        $("#img").hide();
        $.ajax({
            url: "../model/questionnaire.json",
            dataType: "json",

            success: function (data) {
                traitement(data, index);
            },
            error: function (err) {
                alert("error");
            },
        });

        $("button").click(function () {
            index = index + 1;
            if (index == 7) {
                $("button").hide();
                $("a").show();
            }
            compteur = Boolean(1);
            $("#img").hide();
            $("#description").html(" ");
            $("#bravo").html(" ");
            deleteTab();
            if (p != null) {
                map.removeLayer(p);
            }
            $.ajax({
                url: "../model/questionnaire.json",
                dataType: "json",

                success: function (data) {
                    traitement(data, index);
                },
                error: function (err) {
                    alert("error");
                },
            });
        });

        function traitement(data, index) {
            polygone(data[0].features[index].properties.pays.polygone);
            flag(data[0].features[index].properties.pays.flag);
        }

        function polygone(lien) {
            $.getJSON(lien, function (data) {
                p = L.geoJSON(data, {
                    style: function (feature) {
                        return { color: 'blue',
                            fillColor : 'blue' };
                    }
                }).addTo(map);
                map.fitBounds(p.getBounds());
            });
        }

        function disp_flag(lien) {
            $("#flag").attr("src", lien);
        }

        // Fonction qui réagit au clic sur la carte (e contiendra les données liées au clic)
        function onMapClick(e) {

            $.getJSON(Game.questionnaire, function (data) {
               //
            }
        }

        map.on('click', onMapClick);

        $(document).ready(function() {
            var game = new Game();

            game.initializeInterface();

            // Load JSON data 
            $.getJSON('../model/questionnaire.json').success(function(questionnaire) {
                Game.questionnaire = countries;
                );
            });
        });

     </script>
    </body>
</html>
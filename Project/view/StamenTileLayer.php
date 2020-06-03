
<?php 
session_start();
require("header.php"); ?>
<title> Jeu des drapeaux</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="../model/style/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<script src="../model/geojson-world-master/countries.geojson"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<?php require("navbar.php"); ?>


<body class="body1">
			<div class="container">	
				<div class="row">
					<div class="col-md-6">
						<div id="ques">
							<h3 class="title2 question" >Question:<h3>
							<h4 class="question2" >Quel est le pays qui correspond a ce drapeau ?<h3>
						</div>
						<div id=end class ="question2 text-center">
							<p> La partie est finie ! <br> Merci d'avoir jouer ! <br> Pour le jeu complet vous devez vous inscrire pour pouvoir jouer ;) </p>
						</div>
						<div>
							<img id ="flag" src =" " />
							<p id="score">Score :<br> 0</p>
						</div>
						<div class="reponse text-center">
							<p class="msgrep" id="msgrep"></p>
							<p class="description" id="description"></p>
						</div>
						<div id ="carroussel">
							<div class="w3-content" style="max-width:800px">
								<img id="img1" class="mySlides" src="" style="width:100%">
								<img id="img2" class="mySlides" src="" style="width:100%">
								<img id="img3" class="mySlides" src="" style="width:100%">
							</div>
							<div class="w3-center">
								<div class="w3-section">
									<button type="button" id="b1" class="w3-button w3-light-grey" onclick="plusDivs(-1)">❮</button>
									<button type="button" id="b2" class="w3-button w3-light-grey" onclick="plusDivs(1)">❯</button>
								</div>
							</div>
						</div>
	
					</div>
					<div class="col-md-6">
						<div id="maDiv"></div>
						<a id="rejouer" href="StamenTileLayer.php" class="game-but btn btn-primary ">Rejouer</a>
						<button type="button" onclick="button_next()" class="game-but btn btn-primary ">Next</button>
					</div>
				</div>
			</div>
	</body>
		<script>
			
			var score = 0 ;
			var nbrQuestionCorrect = 0;
			var index = 0;
			var tab_reponse = [];
			var c;
			var northWest = L.latLng(90, -180);
			var southEast = L.latLng(-90, 180);
			var bornes = L.latLngBounds(northWest, southEast);

			var coucheStamenWatercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
				subdomains: 'abcd',
				ext: 'jpg'
			});
			var Layer;
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
			var map = new L.Map('maDiv', {
				center: [48.858376, 2.294442],
				minZoom: 2,
				maxZoom: 18,
				zoom: 0,
				zoomSnap: 0.25,
				maxBounds: bornes
			});

			map.addLayer(coucheStamenWatercolor);
			map.doubleClickZoom.disable(); 
			Layer=L.geoJson(countries,
			{
				style : styles,
				onEachFeature : mousehandle
			}).addTo(map);

			document.getElementById('maDiv').style.cursor = 'crosshair'


			function coordGeoJSON(latlng,precision) { 
				return '[' +
				L.Util.formatNum(latlng.lng, precision) + ',' +
				L.Util.formatNum(latlng.lat, precision) + ']';
			}


			function ajaxGet(url, callback) {
				var request = new XMLHttpRequest();
				request.open("GET", url);
				request.addEventListener("load", function () {
					if (request.status >= 200 && request.status < 400) {
						callback(request.responseText);
					} else {
						console.error(request.status + " " + request.statusText + " " + url);
					}
				});
				request.addEventListener("error", function () {
					console.error("Erreur request");
				});
				request.send(null);
			}
			
			
			(document.getElementById("end")).style.display = "none";
			(document.getElementById("rejouer")).style.display = "none";
			(document.getElementById("carroussel")).style.display = "none";
			$.ajax({
				url: "../model/questionnaire.json",
				dataType: "json",
				success: function (data) {
					$("#flag").attr("src", data[0].features[index].properties.pays.flag);
				},
				error: function (err) {
					alert("Error Json read");
				},
			});
			
			function button_next(){
				index = index + 1;
				if (index == 5) {
						map.setZoom(0);
						(document.getElementById("ques")).style.display = "none";
						$("button").hide();	
						(document.getElementById("end")).style.display = "";
						$("a").show();
					}
				(document.getElementById("carroussel")).style.display = "none";
				document.getElementById('description').innerHTML = " ";
				document.getElementById('msgrep').innerHTML = " ";	
				$.ajax({
					url: "../model/questionnaire.json",
					dataType: "json",
					success: function (data) {
						if(index<5){
							$("#flag").attr("src", data[0].features[index].properties.pays.flag);
							map.setZoom(0);
						}
							else if(index==5){
							(document.getElementById("flag")).style.display = "none";		
							(document.getElementById("description")).style.display = "none";
							(document.getElementById("msgrep")).style.display = "none";
							(document.getElementById("score")).style.display = "none";
						}
					},
					error: function (err) {
						alert("Error JSON");
					},
				});
			}

			function layercolor(link,answer) {
				$.getJSON(link, function (data) {
					p = L.geoJSON(data, {
						style: function (feature) {
							if(answer==true){
									return { 
										weight : 4,
										color : 'green',
										fillColor : 'green',
										fillOpacity : 1 };}
							else{
									return { 
										weight : 4,
										color : 'red',
										fillColor : 'red',
										fillOpacity : 1 };
						}
						}				
					}).addTo(map);
					map.fitBounds(p.getBounds());
				});
			}
			
			function onMapClick(e) {
				if((e.latlng!=null)&&(tab_reponse[index]==null)&&(index<5)){
						var link ="https://nominatim.openstreetmap.org/reverse?format=geojson&lat="+e.latlng.lat+"&lon="+ e.latlng.lng ;			
						ajaxGet(link, function (reponse) {
							var result = JSON.parse(reponse);
							c=(result.features[0].properties.address.country).toString();
							console.log(c);
							$.getJSON("../model/questionnaire.json", function (data) {
								var reponse = (data[0].features[index].properties.pays.name).toString();
								var ans=c.localeCompare(reponse);
								layercolor(data[0].features[index].properties.pays.polygone,!ans);
								document.getElementById("img1").src="../model/pictures/"+reponse+"/1.jpg";
								document.getElementById("img2").src="../model/pictures/"+reponse+"/2.jpg";
								document.getElementById("img3").src="../model/pictures/"+reponse+"/3.jpg";
								document.getElementById('description').innerHTML = data[0].features[index].properties.pays.description;

								if (ans==0){
										score=score+10;
										tab_reponse.push("correct");
										document.getElementById('score').innerHTML = "Score:<br>" + score;
										$("#carroussel").show();
										document.getElementById('msgrep').innerHTML = "Vrai :)";
										$("#msgrep").css("background-color", "rgb(0,255,0)");	
										$("#msgrep").css("color", "rgb(16, 4, 94)");

								}
								else {
										tab_reponse.push("faux");
										document.getElementById('msgrep').innerHTML = "Faux :(";
										$("#carroussel").show();
										$("#msgrep").css("background-color", "rgb(255,0,0)");
										$("#msgrep").css("color", "rgb(255,255,255)");
								}	
							});
						});
		
					}
		}
		var slideIndex = 1;
		showDivs(slideIndex);

		function plusDivs(n) {
		showDivs(slideIndex += n);
		}

		function currentDiv(n) {
		showDivs(slideIndex = n);
		}

		function showDivs(n) {
		var i;
		var x = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("demo");
		if (n > x.length) {slideIndex = 1}    
		if (n < 1) {slideIndex = x.length}
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";  
		}
		for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" w3-red", "");
		}
		x[slideIndex-1].style.display = "block";  
		}
			$(document).on("click",map, onMapClick);


		</script>
	</body>
</html>


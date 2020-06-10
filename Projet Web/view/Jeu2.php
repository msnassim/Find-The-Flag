
<?php 
session_start();
if( !isset($_SESSION['user']) )
    die( "Login required." );
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">  
	<link rel="stylesheet" href="../model/style/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/4cc72d1664.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../model/style/style.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<script src="../model/geojson-world-master/countries.geojson"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<title> Jeu des drapeaux</title>
</head>

<body class="body1">
<?php require("navbar.php"); ?>


			<div class="container">	
				<div class="row">
					<div class="col-md-6">
						<div class = "text-center" id="selectcon">
							<h3 id="select" >Veuillez selectionnez le continent:
							<select id="list" onchange="getselectedvalue()">
								<option disabled selected value>Continent</option> 
								<option value = "Afrique">Afrique</option> 
								<option value = "Europe">Europe</option> 
								<option value = "Asie">Asie</option> 
								<option value = "Amérique">Amérique</option> 
								<option value = "Océanie">Océanie</option> 
								<option value = "">Tout le monde</option>
							</select></h3>
						</div>

						<div id="ques">
							<h3 class="title2 question " >Question:</h3>
							<h4 class="question2" >Quel est le pays qui correspond a ce drapeau ?</h3>
						</div>
						<div id=end class ="question2 text-center">
							<p id="enpar"></p>
						</div>
						<div id=flagscore>
							<img id ="flag" src =" " />
							<p id="score">Score :<br> 0</p>
						</div>
						
						<div id=inddiv>
								<button id="indice_but" type="button" class="btn btn-primary " data-toggle="collapse" data-target="#indice">Indice</button>
								<div id="indice" class="question2 collapse">
									<p class="ind" id="ind"></p>
								</div>
					    </div>

						<div class="reponse text-center">
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
						<a id="rejouer" href="Jeu2.php" class="game-but btn btn-primary ">Rejouer</a>
						<button id="nextbut" type="button" onclick="button_next()" class="game-but btn btn-primary ">Next</button>
						<button id="terminer" type="button" onclick="endpartie()" class="game-but btn btn-primary ">Terminer La partie</button>
					</div>
				</div>
			</div>
	</body>
</html>
		<script>
			

						// -********************************MAP INIT *****************************************
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
						//click : onMapClick,
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




 //*********************************************************************PARITE JEU*********************************************************************************
			
			
			var score = 0 ;
			var index = 0;
			var tab_reponse = [];
			var c;
            var continent= "";
            var country;
			var selected_countries="\'\'";
            var poly;
            var drapeau;
            var desc;
            var images;
            var pts = 0;
            var indice;
			var myvar='<?php echo $_SESSION['user'];?>';
			var vrai = '../model/pictures/true.png';			
			var faux = '../model/pictures/false.png'
			var nbques = 0 ;




		function mapcenter(continent){
			switch (continent) {
				case "Afrique":
						map.setView(new L.LatLng(7.88, 18.28), 3);
						var n = L.latLng(48.57, 79.10);
						var s = L.latLng(-36.88, -42.54);
						var b = L.latLngBounds(n, s);
						map.setMaxBounds(b);
						map.setMinZoom(3);
					break;
				case "Europe":
						map.setView(new L.LatLng(57.32, 4.92), 3);
						var n = L.latLng(75.62, 66.27);
						var s = L.latLng(21.78, -55.90);
						var b = L.latLngBounds(n, s);
						map.setMaxBounds(b);
						map.setMinZoom(3);
						break;
				case "Asie":
						map.setView(new L.LatLng(40.45, 62.23), 1);
						var n = L.latLng(75.2, 160.94);
						var s = L.latLng(-38.55, -54.84);
						var b = L.latLngBounds(n, s);
						map.setMaxBounds(b);
						map.setMinZoom(2);
						break;
				case "Océanie":
						map.setView(new L.LatLng(-10.14, 170.31), 3);
						var n = L.latLng(34.74, 178.24);
						var s = L.latLng(-49.84, 57.83);
						var b = L.latLngBounds(n, s);
						map.setMaxBounds(b);
						map.setMinZoom(3);
						break;	
				case "Amérique":
						map.setView(new L.LatLng(24.2, -77), 0);
						var n = L.latLng(80, 68.55);
						var s = L.latLng(-65.65, -173.32)
						var b = L.latLngBounds(n, s);
						map.setMaxBounds(b);
						map.setMinZoom(0);
						break;		
				default:
						map.setZoom(0);
			}
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

		function mycallback(res){
						var data = JSON.parse(res);
						country=data.pays;
						poly=data.polygone;
						drapeau=data.flag;
						desc=data.description;
						images=data.images;
						pts=parseInt(data.points,10);
						indice=data.indice;  
						if(index==5)
							selected_countries = selected_countries +'\''+country+'\'';
						else if	(index==0)
								selected_countries = '\''+country+'\'';
						else 
							selected_countries = selected_countries+','+'\''+country+'\'' ;

			}


		function updatevalues(continent,sel_coun) {
				return new Promise(function foo(resolve) {
				var request = new XMLHttpRequest();
      			 request.onload = function(){
						resolve(this.responseText);
				   };
			request.open("POST", "../control/getquestion.php");
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");			
			var data = 'continent='+continent+'&selected_countries='+sel_coun;
			request.send(data);
			});
		}
		function getnbcoun(continent) {
				return new Promise(function foo(resolve) {
				var request = new XMLHttpRequest();
      			 request.onload = function(){
						resolve(this.responseText);
				   };
			request.open("POST", "../control/getnbquestions.php");
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");			
			var data = 'continent='+continent;
			request.send(data);
			});
		}



		function verify_answer(c){
								(document.getElementById("inddiv")).style.display = "none";
								var ans=(c.toLowerCase()).localeCompare(country.toLowerCase());
								layercolor(poly,!ans);
								document.getElementById("img1").src=images+"/1.jpg";
								document.getElementById("img2").src=images+"/2.jpg";
								document.getElementById("img3").src=images+"/3.jpg";
								document.getElementById('description').innerHTML = desc;

								if (ans==0){
										score=score+pts;
										tab_reponse.push("vrai");
										document.getElementById('score').innerHTML = "Score:<br>" + score;
										$("#carroussel").show();
										bootbox.alert({
														message:"Bonne réponse <br/><img width='200' height='200' src='" + vrai + "'>",
														className: 'question2 text-center',
														size: 'small'}).find(".modal-dialog").addClass("modal-dialog-centered");
										$("#carroussel").show();

								}
								else {
										tab_reponse.push("faux");
										bootbox.alert({
														message:"Mauvaise réponse <br/><img width='200' height='200' src='" + faux + "'>",
														className: 'question2 text-center',
														size: 'small'}).find(".modal-dialog").addClass("modal-dialog-centered");
										$("#carroussel").show();

								}	
																
			}


		function getselectedvalue(){
				var value=document.getElementById('list').value;
				continent = value;
				var element = (document.getElementById('selectcon'));
				element.parentNode.removeChild(element);
				getnbcoun(continent).then(function (req){
					var d = JSON.parse(req);
					nbques=d.NB;	
					updatevalues(continent,selected_countries).then(function (request){
					mycallback(request);			
					$("#ques").show();
					$("#flagscore").show();
					$("#inddiv").show();
					document.getElementById('ind').innerHTML=indice;
					$("#nextbut").show();
					$("#terminer").show();
					$("#flag").attr("src", drapeau);	
					Layer.on({click : onMapClick,});
					mapcenter(continent);
				});
			});
			
			}
		

		function add_partie(p,s){
				$.post("../control/add_partie.php",
				{
					pseudo: p,
					score: s
				});
			}

		function endpartie(){
				index=nbques;
				mapcenter(continent);
				(document.getElementById("ques")).style.display = "none";
				$("button").hide();	
				(document.getElementById("end")).style.display = "";
				desc="";
				images="";
				(document.getElementById("flag")).style.display = "none";		
				(document.getElementById("description")).style.display = "none";
				(document.getElementById("score")).style.display = "none";		
				document.getElementById('enpar').innerHTML='La partie est finie ! <br> Merci d\'avoir jouer ! &#128512 <br><br> Votre Score:  '+score;
				(document.getElementById("carroussel")).style.display = "none";
				document.getElementById('description').innerHTML = " ";	
				$("a").show();
				add_partie(myvar,score);
			}


		function button_next(){
				index = index + 1;
				(document.getElementById("carroussel")).style.display = "none";
				document.getElementById('description').innerHTML = " ";
				$('.collapse').collapse('hide');
				if (index == nbques) {
						mapcenter(continent);
						(document.getElementById("ques")).style.display = "none";
						$("button").hide();	
						(document.getElementById("end")).style.display = "";
						desc="";
						images="";
						(document.getElementById("flag")).style.display = "none";		
						(document.getElementById("description")).style.display = "none";
						(document.getElementById("score")).style.display = "none";
						document.getElementById('enpar').innerHTML='La partie est finie ! <br> Merci d\'avoir jouer ! &#128512 <br><br> Votre Score :  '+score;
						$("a").show();
						add_partie(myvar,score);
					}
				else{
					updatevalues(continent,selected_countries).then(function (request){
						mycallback(request);
						$("#flag").attr("src", drapeau);
						$("#inddiv").show();
						document.getElementById('ind').innerHTML=indice;
						mapcenter(continent);	
					});
			}
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
			if((e.latlng!=null)&&(tab_reponse[index]==null)&&(index<nbques)){
					var link ="https://nominatim.openstreetmap.org/reverse?format=geojson&lat="+e.latlng.lat+"&lon="+ e.latlng.lng+"&accept-language=fr" ;			
					ajaxGet(link, function (reponse) {
						var result = JSON.parse(reponse);
						c=(result.features[0].properties.address.country).toString();
						verify_answer(c);
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

		



		(document.getElementById("ques")).style.display = "none";	
		(document.getElementById("inddiv")).style.display = "none";			
		(document.getElementById("end")).style.display = "none";
		(document.getElementById("flagscore")).style.display = "none";
		(document.getElementById("rejouer")).style.display = "none";
		(document.getElementById("carroussel")).style.display = "none";	
		(document.getElementById("nextbut")).style.display = "none";
		(document.getElementById("terminer")).style.display = "none";	
	
		
		</script>
	</body>
</html>


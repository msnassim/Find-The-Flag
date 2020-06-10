<?php 
session_start();
require("header.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.js"></script>
<title> Jeu des drapeaux</title>
</head>
<body>
<?php require("navbar.php"); ?>

<section id="banner">
<div class="container">
<div class="row">
<div class="col-md-6">
    <p class="game-title">Find The Country</p>
    <p>Vous pensez être un CRACK en géographie, venez tester vos connaissance dans ce jeu et découvrir 
    les drapeaux et les capitales des différents pays dans le monde </p>
    <img src="../public/image/thguy.png">
</div>
<div class="col-md-6 text-center">
<img src="../public/image/worldflags.png" class="img-fluid">
</div>
</div>
</div>

<img src="../public/image/triangles.png" class="bottom-img">
</section>

<section id="lejeu">
<div class="container">
<h1 class="title text-center"> Le Jeu ! </h1>
<div class="row">
<div class="col-md-6">
<p>
                        <ul>
                        <li>
                        Un questionnaire vous sera proposé, chaque question consiste à trouver à l'aide d'un click de souris l'emplacement du pays représenté par son drapeau dans la question. <br>
                         Pour chaque question le joueur devra donc cliquer sur un endroit de la carte, et des points seront attribués en fonction de la proximité de la cible à trouver.
                         Si l'utilisateur trouve directement le bon pays une deuxieme question lui sera posé et cette question s'agit bien de la capitale de ce pays.
                        </li>
                        <li>
                        On restreint le jeu de drapeaux à un seul continent (On en tire 5 au hasard à
                        chaque fois). On considérera les continents suivants : Europe, Asie, Afrique,
                        Amérique du Nord et du Sud (un seul et même continent) et enfin l’Océanie. 
                        On clique sur un des drapeaux proposés et le joueur doit trouver le pays sur la carte du monde en cliquant sur
                        la bonne zone. Si le pays est petit (en termes de surface) on peut donner plus de
                        points gagnants que pour des pays plus grands.
                        Le barème de points est fait en fonction de la distance du clic par
                        rapport au pays.
                        </li>
                        <li>
                        On peut aussi jouer sur la totalité du monde et ce mode de jeu ne sera disponible que si vous êtes inscrit au site.
                        </li>
                    </ul>  

                    </p>

</div>
<div class="col-md-6">
<img src="../public/image/flags.png" class="img-fluid">
</div>
</div>
        <?php  if( (empty($_SESSION['user'])) || (!isset($_SESSION['user'])) ) {?>
            <a id="button" href="Jeu1.php" class="btn btn-primary ">Essayer le Jeu</a>
                <?php } else { ?>
             <a id="button" href="Jeu2.php" class="btn btn-primary ">Jouer au jeu complet</a>
        <?php } ?>       
</div>

</section>
<script src="../control/smooth-scroll.js"></script>
<script>
    var scroll= new SmoothScroll('a[href*="#"]');
</script>

<?php if(!empty($_SESSION['inscrit'])){
    echo "<script> bootbox.alert('Vous etes inscrit').find('.modal-dialog').addClass('modal-dialog-centered'); </script>";
    $_SESSION['inscrit'] = '';
}
?>
</body>
<section id="footer">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-12 footer-box">
            <p>FIND THE COUNTRY </p>
            <p> NAIT SAADA Tarek & MESSAOUDI Nassim</p>
            </div>
        </div>
    </div>
</section>
</html>
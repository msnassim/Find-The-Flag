<?php require("header.php"); ?>
<title> Connexion</title>
</head>
<?php require("navbar.php"); ?>


<div id="connect" class="container">
    <div class="login-box">
    <h1 class="title text-center"> Se Connecter </h1>
    <form action="../control/login.php" method="post">
        <div class="form-group">
            <label>Pseudo</label>
            <input type="text" name="user" class="form-control" required>
            </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="mdp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary"> Se Connecter </button>
        </form>
        <p>Pas encore inscrit ? <a href="inscription.php" target="_self">S'inscrire ici</a>

</div>
<?php 
    session_start();
     if(!empty($_SESSION['erreurs'])){ ?>
        <div class="alert alert-danger">
            <p>Vous n'avez pas rempli le formulaire correctement </p>
            <ul>  
                <?php foreach($_SESSION['erreurs'] as $error){ ?>
                    <li><?= $error; ?></li>
                <?php
                } ?>
            </ul>
        </div>
<?php } 
session_destroy();  ?>
</div>

</body>
<section id="footer2">
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
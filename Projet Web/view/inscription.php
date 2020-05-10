<?php require("header.php"); ?>
<title> Inscription</title>
</head>
<?php require("navbar.php"); ?>


<div id="connect" class="container">
    <div class="login-box">
    <h1 class="title text-center"> S'inscrire </h1>
    <form action="../control/signup.php" method="post">
        <div class="form-group">
            <label>Pseudo</label>
            <input type="text" name="user" class="form-control" required>
            </div>
		<div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
            </di
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="mdp" class="form-control" required>
            </div>
		<div class="form-group">
            <label>E-Mail</label>
            <input type="text" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary"> S'inscrire </button>
        </form>
        <p>Déja inscrit ? <a href="connexion.php" target="_blank">Se connecter ici</a>
    </div>
    <?php 
    session_start();
    ?>
    <?php if(!empty($_SESSION['erreurs'])){ ?>
        <div class="alert alert-danger">
            <p>Vous n'avez pas rempli le formulaire correctement </p>
            <ul>  
                <?php foreach($_SESSION['erreurs'] as $error){ ?>
                    <li><?= $error; ?></li>
                <?php
                } ?>
            </ul>
        </div>
    <?php } ?>
<?php session_destroy();  ?>
</div>

</body>
<?php require("footer.php"); ?>
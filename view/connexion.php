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
            <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary"> Se Connecter </button>
        </form>
        <p>Pas encore inscrit ? <a href="inscription.php" target="_blank">S'inscrire ici</a>

</div>
</div>

<?php require("footer.php"); ?>
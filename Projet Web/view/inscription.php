<?php require("header.php"); ?>
<?php 
session_start();
if(isset($_SESSION['user']) ){
    header('Location: ../view/index.php');
}
?>
<title> Inscription</title>
</head>

<body>
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
        <p>Déja inscrit ? <a href="connexion.php" target="_self">Se connecter ici</a></p>

 <?php 
     if(!empty($_SESSION['erreurs'])){
       echo" <div class='alert alert-danger'>
                <p>Vous n'avez pas rempli le formulaire correctement </p>
                <ul>";
        foreach($_SESSION['erreurs'] as $error){
                        echo "<li>".$error."</li>";
                }
       echo"</ul> </div>";
       $_SESSION['erreurs']=NULL; 
     }
?>
 </div>

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

<?php 
session_start();
if(!(isset($_SESSION['user']))||(strcmp($_SESSION['user'],"admin")!==0))
    die( "Login required: ADMIN." );
require("header.php"); ?>

<?php require("header.php"); ?>
<title> Ajout Question</title>
</head>

<body>
<?php require("navbar.php"); ?>

<div id="connect" class="container">
    <div class="login-box">
    <h1 class="title text-center"> Ajouter une question </h1>
    <form action="../control/addquestion.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Pays - Exemple : France, Attention aux majuscules</label>
            <input type="text" name="pays" class="form-control" required>
            </div>
		<div class="form-group">
            <label>Continent</label>
            <input type="text" name="continent" class="form-control" required>
            </di
        <div class="form-group">
            <label>Code ISO 3166 du pays sur 3 caractères</label>
            <input type="text" name="code" class="form-control" required>
            </div>
		<div class="form-group">
            <label>Description</label>
            <input type="text" name="description" class="form-control" required>
            </div>
        <div class="form-group">
            <label>Points</label>
            <input type="number" name="points" class="form-control" required>
            </div>
        <div class="form-group">
            <label>Indice</label>
            <input type="text" name="indice" class="form-control" required>
            </div>
        <div class="form-group">
            <label>Images - Taille max fichier : 2MB, Ext : JPG </label>
            <br>
            <input type="file" name="userfile[]" value="" multiple="" required>
        </div>
        <button type="submit" class="btn btn-primary"> Ajouter </button>
        </form>

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

</html>
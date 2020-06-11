<?php 
session_start();
if(!(isset($_SESSION['user']))||(strcmp($_SESSION['user'],"admin")!==0))
    die( "Login required: ADMIN." );
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">  
    <link rel="stylesheet" href="../model/style/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/4cc72d1664.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title> Quesionnaire</title>
</head>

<body>
<?php require("navbar.php"); ?>
    <div class="container">
        <div class="text-center">
            <h1 class="title text-center"> Utilisateurs </h1>
        </div>
    <table class="table" id="userTable" border="1" style="border:1px solid black;margin-left:auto;margin-right:auto;" >
        <thead class="thead-dark">
            <tr>
            <th class="text-center" width="300">Pseudo</th>
            <th class="text-center" width="300">Nom</th>
            <th class="text-center" width="300">E-mail</th>
            <th class="text-center" width="300">Supprimer</th>

            </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div>
</body>
</html>
<script>
            $(document).ready(function(){

                $.ajax({
                    url: '../control/getallusers.php',
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        var len = response.length;
                        for(var i=0; i<len; i++){
                            var pseudo = response[i].pseudo;
                            var nom = response[i].nom;
                            var email = response[i].email;


                            var tr_str = "<tr>" +
                                "<td id='pseudo' align='center' value='"+pseudo+"'>" + pseudo + "</td>" +
                                "<td align='center'>" + nom + "</td>" +
                                "<td align='center'>" + email + "</td>" +
                                "<td><input class='btnDelete' type='button' id='supbutton' value='X'/></td> "+       

                                "</tr>";  

                            $("#userTable tbody").append(tr_str);
                        }

                    },
                    error: function (err) {
                        bootbox.alert("Pas de joueur dans la base de données").find(".modal-dialog").addClass("modal-dialog-centered");
					},
                });
            });

            $("#userTable").on('click', '.btnDelete', function () {
                var val=$(this).closest('tr').find('td:eq(0)').text();
                var row=  $(this).parents("tr");
                bootbox.confirm("Confirmer la suppression de l'utilisateur : "+val, function(result){ 
                    if(result==true) {
                                $.ajax({
                                url: '../control/removeuser.php',
                                type: 'post',
                                data: {pseudo:val},
                                success: function(){
                                    bootbox.alert("Utilisateur supprimé").find(".modal-dialog").addClass("modal-dialog-centered");  
                                    row.remove();                        
                                 },
                                error : function(){
                                    bootbox.alert("Utilisateur non supprimé").find(".modal-dialog").addClass("modal-dialog-centered");
                                }
                        });
                    }
                    else
                        bootbox.alert("Utilisateur non supprimé").find(".modal-dialog").addClass("modal-dialog-centered");
                }).find(".modal-dialog").addClass("modal-dialog-centered");


               
            });

                   
</script>


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
            <h1 class="title text-center"> Questions </h1>
            <a id="addques" href="ajoutques.php" class="btn btn-primary ">Ajouter une question</a>
        </div>
    <table class="table" id="userTable" border="1" >
        <thead class="thead-dark">
            <tr>
            <th class="text-center" width="20%">Pays</th>
            <th class="text-center" width="20%">Code ISO</th>
            <th class="text-center" width="30%">Continent</th>
            <th class="text-center" width="10%">Points</th>
            <th class="text-center" width="30%">Indice</th>
            <th class="text-center" width="10%">Supprimer</th>
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
                    url: '../control/getallquestions.php',
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        var len = response.length;
                        for(var i=0; i<len; i++){
                            var pays = response[i].pays;
                            var code = response[i].code;
                            var continent = response[i].continent;
                            var points = response[i].points;
                            var indice = response[i].indice;

                            var tr_str = "<tr>" +
                                "<td id='pays' align='center' value='"+pays+"'>" + pays + "</td>" +
                                "<td align='center'>" + code + "</td>" +
                                "<td align='center'>" + continent + "</td>" +
                                "<td align='center'>" + points + "</td>" +
                                "<td align='center'>" + indice + "</td>" +
                                "<td><input class='btnDelete' type='button' id='supbutton' value='X'/></td> "+       

                                "</tr>";  

                            $("#userTable tbody").append(tr_str);
                        }

                    },
                    error: function (err) {
                        bootbox.alert("Pas de questions dans la base de données").find(".modal-dialog").addClass("modal-dialog-centered");
					},
                });
            });

            $("#userTable").on('click', '.btnDelete', function () {
                var val=$(this).closest('tr').find('td:eq(0)').text();
                var row=  $(this).parents("tr");
                bootbox.confirm("Confirmer la suppression du pays : "+val, function(result){ 
                    if(result==true) {
                                $.ajax({
                                url: '../control/removeques.php',
                                type: 'post',
                                data: {country:val},
                                success: function(){
                                    bootbox.alert("Pays supprimer").find(".modal-dialog").addClass("modal-dialog-centered");  
                                    row.remove();                        
                                 },
                                error : function(){
                                    bootbox.alert("Pays non supprimer").find(".modal-dialog").addClass("modal-dialog-centered");
                                }
                        });
                    }
                    else
                        bootbox.alert("Pays non supprimer").find(".modal-dialog").addClass("modal-dialog-centered");
                }).find(".modal-dialog").addClass("modal-dialog-centered");


               
            });

                   
</script>


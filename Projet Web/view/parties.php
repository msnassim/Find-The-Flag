<?php 
session_start();
if(!(isset($_SESSION['user'])))
    die( "Login required" );
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
    <div class="container ">
        <div class="text-center">
            <h1 class="title text-center"> Historique parties </h1>
        </div>
    <table class="table" id="userTable" border="1" style="border:1px solid black;margin-left:auto;margin-right:auto;" >
        <thead class="thead-dark">
            <tr>
            <th class="text-center" width="300">Pseudo</th>
            <th class="text-center" width="300">Date</th>
            <th class="text-center" width="300">Score</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div>
</body>
</html>
<script>
            var myvar='<?php echo $_SESSION['user'];?>';
            $(document).ready(function(){
                $.ajax({
                    url: '../control/getallparties.php',
                    type: 'post',
                    dataType: 'json',
                    data: {pseudo:myvar},
                    success: function(response){
                        var len = response.length;
                        for(var i=0; i<len; i++){
                            var pseudo = response[i].pseudo;
                            var date = response[i].date;
                            var score = response[i].score;
                            var tr_str = "<tr>" +
                                "<td align='center' value='"+pseudo+"'>" + pseudo + "</td>" +
                                "<td align='center'>" + date + "</td>" +
                                "<td align='center'>" + score + "</td>" +     
                                "</tr>";  

                            $("#userTable tbody").append(tr_str);
                        }
                        console.log("yes");
                    },
                    error: function (err) {
                        var para = document.createElement("P");
                        para.className = "h2 text-center";
                        para.innerText = "Pas de parties";
                        document.body.appendChild(para);
					},
                });
            });

                   
</script>


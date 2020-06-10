<?php
session_start();

$x=$_POST['pseudo'];
$s=$_POST['score'];
    
    $date=date("Y-m-d H:i:s");           
    require('connectSQL.php');
    $sql="INSERT INTO partie(pseudo,date,score) VALUES (:pseudo,:date,:score)";
    try {
       $cmd = $pdo->prepare($sql);
       $cmd->bindParam(':pseudo',$x);
       $cmd->bindParam(':score',$s);
       $cmd->bindParam(':date',$date);
       $cmd->execute();
    }
    catch (PDOException $e) {
       echo utf8_encode("Erreur d'insertion : " . $e->getMessage() . "\n");
       die();
    }

   ?>
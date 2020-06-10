<?php
   session_start();
   $pseudo=$_POST['pseudo']; 

    require('connectSQL.php');

   $sql="DELETE FROM users WHERE pseudo = :pseudo";

        try {
                $cmd = $pdo->prepare($sql);
                $cmd->bindParam(':pseudo',$pseudo);
                $query = $cmd->execute();

            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur d'insertion : " . $e->getMessage() . "\n");
                die();
            }
?>


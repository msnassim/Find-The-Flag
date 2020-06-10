<?php
   session_start();
   $country=$_POST['country']; 

    require('connectSQL.php');

   $sql="DELETE FROM countries WHERE pays = :pays";

        try {
                $cmd = $pdo->prepare($sql);
                $cmd->bindParam(':pays',$country);
                $query = $cmd->execute();

                $directoryName = '../model/pictures/'.$country.'/';
                if(is_dir($directoryName)){
                    array_map('unlink', glob("$directoryName*.*"));
                    rmdir($directoryName);
                }
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur d'insertion : " . $e->getMessage() . "\n");
                die();
            }
?>


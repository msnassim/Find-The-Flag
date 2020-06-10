<?php
   session_start();

    $reponse= array();
    
        $hostname = "localhost";	
        $database= "ftf";
        $login= "root";		
        $password="";
        try {
            $pdo = new PDO ("mysql:host=$hostname;dbname=$database",$login, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo utf8_encode("Erreur de connexion : " . $e->getMessage() . "\n");
            die();
        }

        $sql="SELECT pseudo, nom, email FROM users where pseudo !='admin' ORDER BY nom";      

        try {
            $cmd = $pdo->prepare($sql);
            $cmd->execute();
            $data=$cmd->fetchAll();
            if($data==false){
                $reponse["erreur"]="Pas de données";
            }
            else{
                 foreach($data as $row){
                   $pseudo = $row['pseudo'];
                   $nom = $row['nom'];
                   $email = $row['email'];
                   
                   $reponse[] = array("pseudo" => $pseudo,
                                   "nom" => $nom,
                                   "email" => $email);
                 } 
                     echo json_encode($reponse);
                }  
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur de connexion : " . $e->getMessage() . "\n");
                die();
            }
    

?>


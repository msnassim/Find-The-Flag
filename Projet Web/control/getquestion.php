<?php
   session_start();

    $continent = $_POST['continent'];

    if(empty($continent))
        $continent="'Afrique','Europe','Asie','Océanie','Amérique'";
    else
         $continent = "'".$continent."'";

    $selected_countries =  $_POST['selected_countries'];

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

        $sql="SELECT pays, polygone, flag, description, images, points,indice FROM countries WHERE continent IN (".$continent.") AND pays NOT IN (".$selected_countries.") ORDER BY RAND() LIMIT 1";      

        try {
            $cmd = $pdo->prepare($sql);
            $cmd->execute();
            $data=$cmd->fetch(PDO::FETCH_ASSOC); 
            if($data==false){
                $reponse["erreur"]="Country not found";
            }
            else{
                     $reponse["pays"] = $data['pays'] ;
                     $reponse["polygone"] = $data['polygone'] ;
                     $reponse["flag"] = $data['flag'] ;
                     $reponse["description"] = $data['description'] ;
                     $reponse["images"] = $data['images'] ;
                     $reponse["points"] = $data['points'] ;
                     $reponse["indice"] = $data['indice'] ;
                     echo json_encode($reponse);
                }  
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur de connexion : " . $e->getMessage() . "\n");
                die();
            }
    

//and pays not in(x,y,z,q) pour eviter la répétition 
?>


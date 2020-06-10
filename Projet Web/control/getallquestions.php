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

        $sql="SELECT pays, code, continent, points, indice FROM countries ORDER BY continent";      

        try {
            $cmd = $pdo->prepare($sql);
            $cmd->execute();
            $data=$cmd->fetchAll();
            if($data==false){
                $reponse["erreur"]="Pas de données";
            }
            else{
                 foreach($data as $row){
                   $pays = $row['pays'];
                   $code = $row['code'];
                   $continent = $row['continent'];
                   $points = $row['points'];
                   $indice = $row['indice'];
                   
                   $reponse[] = array("pays" => $pays,
                                   "code" => $code,
                                   "continent" => $continent,
                                   "points" => $points,
                                   "indice" => $indice);
                 } 
                     echo json_encode($reponse);
                }  
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur de connexion : " . $e->getMessage() . "\n");
                die();
            }
    

?>


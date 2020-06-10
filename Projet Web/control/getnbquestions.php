<?php
   session_start();
   if ((strcmp($_POST['continent'], "Europe") !== 0)&&(strcmp($_POST['continent'], "Afrique") !== 0)&&(strcmp($_POST['continent'], "Asie") !== 0)&&(strcmp($_POST['continent'], "Amérique") !== 0)&&(strcmp($_POST['continent'], "Océanie") !== 0) ) {
    die();  
    }

    $reponse= array();
    
        require('connectSQL.php');


        $sql="SELECT count(*) as NB FROM countries where continent =:continent";      

        try {
            $cmd = $pdo->prepare($sql);
            $cmd->bindParam(':continent',$_POST['continent']);
            $cmd->execute();
            $data=$cmd->fetch(PDO::FETCH_ASSOC); 
            if($data==false){
                die();
            }
            else{     
                $reponse["NB"] = $data['NB'] ;
                echo json_encode($reponse);
                }  
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur de connexion : " . $e->getMessage() . "\n");
                die();
            }
    

?>
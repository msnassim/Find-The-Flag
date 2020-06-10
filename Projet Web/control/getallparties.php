<?php
   session_start();
    $reponse= array();
    
        require('connectSQL.php');


        $sql="SELECT pseudo, date, score FROM partie where pseudo =:pseudo ORDER BY date";      

        try {
            $cmd = $pdo->prepare($sql);
            $cmd->bindParam(':pseudo',$_POST['pseudo']);
            $cmd->execute();
            $data=$cmd->fetchAll();
            if($data==false){
                $reponse["erreur"]="Pas de données";
            }
            else{
                 foreach($data as $row){
                   $pseudo = $row['pseudo'];
                   $date = $row['date'];
                   $score = $row['score'];
                   
                   $reponse[] = array("pseudo" => $pseudo,
                                   "date" => $date,
                                   "score" => $score);
                 } 
                     echo json_encode($reponse);
                }  
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur de connexion : " . $e->getMessage() . "\n");
                die();
            }
    

?>
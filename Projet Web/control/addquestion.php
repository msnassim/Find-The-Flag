<?php

   session_start();
   $errors = array();   

   if (!isset($_POST['pays'])){
        $errors['pays'] = "Pays invalide";
    }
    else{
        require('pays.php');
        if(in_array($_POST['pays'],$countries)){
            require('connectSQL.php');
            $sql="SELECT * FROM countries WHERE pays=:pays";
            try {
                $cmd = $pdo->prepare($sql);
                $cmd->bindParam(':pays',$_POST['pays']);
                $cmd->execute();
                $query = $cmd->fetch();
            }
            catch (PDOException $e) {
                echo utf8_encode("Le pays existe déja !! " . $e->getMessage() . "\n");
                die(); 
            }
            if(!empty($query)){
                $errors['pays'] = "Le pays existe déja !! ";
            }
        }
        else{
            $errors['pays'] = "Le pays est invalide, Exemple pays : Algérie, France ... ";
        }
    }

  
   if ((strcmp($_POST['continent'], "Europe") !== 0)&&(strcmp($_POST['continent'], "Afrique") !== 0)&&(strcmp($_POST['continent'], "Asie") !== 0)&&(strcmp($_POST['continent'], "Amérique") !== 0)&&(strcmp($_POST['continent'], "Océanie") !== 0) ) {
    $errors['continent'] = "Continent invalide, Valeurs acceptées : Europe, Afrique, Asie, Océanie, Amérique";  
    }


    if (!isset($_POST['code'])){
        $errors['code'] = "Code invalide, exemple code pays : Algérie = DZA , France = FRA "; 
    }
    else{
        $file = '../model/countries/data/'.$_POST['code'].'.svg';
        if (!file_exists($file)) {
            $errors['code'] = "Code invalide, exemple code pays : Algérie = DZA , France = FRA  "; 
        }
    }
    if ((!isset($_POST['description']))||(strlen($_POST['description'])<30)){
        $errors['description'] = "Description invalide, Minimum 30 caractére"; 
    }

    if ((!isset($_POST['points']))||($_POST['points']<0)||($_POST['points']>30)){
        $errors['points'] = "Points invalide, interval de points 1-30 "; 
    }
    if (!isset($_POST['indice'])){
        $errors['indice'] = "Indice invalide"; 
    }

    if(isset($_FILES['userfile'])){
        $file_array=reogranisefiles($_FILES['userfile']);
        if(count($file_array)!==3){
            $errors['files'] = ' Il faut exactement 3 images format jpg';
        }
        else{
        for($i=0;$i<count($file_array);$i++){
            if($file_array[$i]['error']){
                $errors['files'] = $file_array[$i]['name']. ' : Erreur fichier';
            }
            else{
                $ext= array('jpg');
                $file_ext= explode('.',$file_array[$i]['name']);
                $file_ext= end($file_ext);
                if(!in_array($file_ext,$ext)){
                    $errors['files'] = $file_array[$i]['name']. ' : Erreur Extension';
                }
                }
            }
        }
    }
    else {
        $errors['files'] = 'fichiers non trouvés';
    }


   if(!empty($errors)){    
        $_SESSION['erreurs'] = $errors;
        header('Location: ../view/ajoutques.php');
   }else{           
            require('connectSQL.php');
            $sql="INSERT INTO countries(pays,polygone,flag,code,description,images,points,continent,indice) VALUES (:pays,:polygone,:flag,:code,:description,:images,:points,:continent,:indice)";
            $polygone = "../model/countries/data/".$_POST['code'].".geo.json";
            $flag="../model/countries/data/".$_POST['code'].".svg";
            $images="../model/pictures/".$_POST['pays'];

            try {
                $cmd = $pdo->prepare($sql);
                $cmd->bindParam(':pays',$_POST['pays']); 
                $cmd->bindParam(':polygone',$polygone);
                $cmd->bindParam(':flag',$flag);
                $cmd->bindParam(':code',$_POST['code']);
                $cmd->bindParam(':description',$_POST['description']);
                $cmd->bindParam(':images',$images);
                $cmd->bindParam(':points',$_POST['points']);
                $cmd->bindParam(':continent',$_POST['continent']);
                $cmd->bindParam(':indice',$_POST['indice']); 
                $query = $cmd->execute();

                $directoryName = '../model/pictures/'.$_POST['pays'].'/';
                if(!is_dir($directoryName)){
                    mkdir($directoryName, 0755, true);
                }

                for($i=0;$i<count($file_array);$i++){
                     move_uploaded_file($file_array[$i]['tmp_name'],'../model/pictures/'.$_POST['pays'].'/'.($i+1).'.jpg');
                }


                $_SESSION['ajouter'] =  "success" ;
                header('Location: ../view/questions.php');
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur d'insertion : " . $e->getMessage() . "\n");
                die();
            }
    }

    function reogranisefiles($files){
        $file_array=array();
        $file_count=count($files['name']);
        $file_keys= array_keys($files);

        for($i=0; $i<$file_count;$i++){
            foreach($file_keys as $key){
                $file_array[$i][$key]=$files[$key][$i];
            }
        }
        return $file_array;
    }
?>
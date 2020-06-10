<?php
   session_start();
   $errors = array();   

   if (empty($_POST['user'])){
        $errors['user'] = "Pseudo invalide";
    }
    else{
        require('connectSQL.php');
        $sql="SELECT * FROM users WHERE pseudo=:pseudo";
        try {
            $cmd = $pdo->prepare($sql);
            $cmd->bindParam(':pseudo',$_POST['user']);
            $cmd->execute();
            $query = $cmd->fetch();
        }
        catch (PDOException $e) {
            echo utf8_encode("Le pseudo existe déja !! " . $e->getMessage() . "\n");
            die(); 
        }
        if(!empty($query)){
            $errors['user'] = "Le pseudo existe déja !! ";
        }
    }

   if (empty($_POST['nom'])){
        $errors['nom'] = "Nom invalide";
   }
    if ((empty($_POST['mdp']))||(strlen($_POST['mdp'])<8)){
        $errors['mdp'] = "Mot de passe invalide (Le MDP doit contenir 8 caractére)"; 
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email invalide";
    }
    else{
        require('connectSQL.php');
        $sql="SELECT * FROM users WHERE email=:email";
        try {
            $cmd = $pdo->prepare($sql);
            $cmd->bindParam(':email',$_POST['email']);
            $cmd->execute();
            $query = $cmd->fetch();
        }
        catch (PDOException $e) {
            echo utf8_encode("E-Mail existe déja !!! " . $e->getMessage() . "\n");
            die(); 
        }
        if(!empty($query)){
            $errors['email'] = "L'adresse e-mail introduite est déja associée un compte existant";
        }
    }
   if(!empty($errors)){    
        $_SESSION['erreurs'] = $errors;
        header('Location: ../view/inscription.php');
   }else{           
            require('connectSQL.php');
            $sql="INSERT INTO users(pseudo,nom,email,pass) VALUES (:pseudo,:nom,:email,:pass)";
            try {
                $pass=password_hash($_POST['mdp'],PASSWORD_BCRYPT,array("cost"=>12));
                $cmd = $pdo->prepare($sql);
                $cmd->bindParam(':pseudo',$_POST['user']);
                $cmd->bindParam(':nom',$_POST['nom']);
                $cmd->bindParam(':email',$_POST['email']);
                $cmd->bindParam(':pass',$pass);
                $query = $cmd->execute();
                $_SESSION['inscrit'] =  "success" ;
                header('Location: ../view/index.php');
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur d'insertion : " . $e->getMessage() . "\n");
                die();
            }
    }
?>
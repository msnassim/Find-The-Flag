<?php
   session_start();
   $errors = array();   

   if (empty($_POST['user'])){
        $errors['user'] = "Pseudo ou mot de passe invalide";
    }
    if ((empty($_POST['mdp']))||(strlen($_POST['mdp'])<8)){
        $errors['mdp'] = "Pseudo ou mot de passe invalide"; 
    }
   if(!empty($errors)){    
        $_SESSION['erreurs'] = $errors;
        header('Location: ../view/connexion.php');
   }else{     
        require 'connectSQL.php';
        $sql="SELECT pseudo, pass FROM users WHERE pseudo = :pseudo";      
        try {
            $cmd = $pdo->prepare($sql);
            $cmd->bindParam(':pseudo',$_POST['user']);
            $cmd->execute();
            $user=$cmd->fetch(PDO::FETCH_ASSOC); 
            if(($user==false)||(!password_verify($_POST['mdp'],$user['pass']))){
                $errors['user'] = "Pseudo ou mot de passe invalide";
                $_SESSION['erreurs'] = $errors;
                header('Location: ../view/connexion.php');
            }
            else{
                    $_SESSION['user'] =  $_POST['user'] ;
                    header('Location: ../view/index.php');
                }  
            }
            catch (PDOException $e) {
                echo utf8_encode("Erreur de connexion : " . $e->getMessage() . "\n");
                die();
            }
    }
?>
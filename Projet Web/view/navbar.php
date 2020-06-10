    <section id=nav-bar>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.php#top"><img src="../public/image/logo.png"> FIND THE COUNTRY </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php#top"><i class="fas fa-home"></i> Accueil </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php#lejeu"><i class="fas fa-info-circle"></i> Le Jeu</a>
                </li>   
                
                
                <?php  if( (empty($_SESSION['user'])) || (!isset($_SESSION['user'])) ) {?>
                <li class="nav-item">
                  <a class="nav-link" href="jeu1.php"><i class="fas fa-gamepad"></i> Jouer</a>
                </li>
                <?php } else { ?>
                  <li class="nav-item">
                  <a class="nav-link" href="jeu2.php"><i class="fas fa-gamepad"></i> Jouer</a>
                  </li>
                <?php } ?>    
                
                <?php  if( (!empty($_SESSION['user'])) && (isset($_SESSION['user'])) ) {?>
                <li class="nav-item">
                    <a class="nav-link" href="parties.php"><i class="fas fa-history"></i> Mes Parties</span></a>
                </li>
                <?php } ?>

                <?php  if( (!empty($_SESSION['user'])) && (strcmp($_SESSION['user'],"admin")==0) ) {?>
                <li class="nav-item">
                    <a class="nav-link" href="Joueur.php"><i class="fas fa-users"></i> Joueurs</span></a>
                </li>
                <?php } ?>

                <?php  if( (!empty($_SESSION['user'])) && (strcmp($_SESSION['user'],"admin")==0) ) {?>
                <li class="nav-item">
                    <a class="nav-link" href="questions.php"><i class="fas fa-question-circle"></i> Questionnaire</span></a>
                </li>
                <?php } ?>

                
                <?php  if( (empty($_SESSION['user'])) || (!isset($_SESSION['user'])) ) {?>
                <li class="nav-item">
                  <a class="nav-link" href="inscription.php"><i class="fas fa-log-on"></i><i class="fas fa-user-plus"></i> S'inscrire</a>
                </li>
                <?php } else { ?>
                  <li class="nav-item">
                  <a class="nav-link" href="../control/disconnect.php"><i class="fas fa-sign-out-alt"></i> Se deconnecter</a>
                  </li>
                <?php } ?>

  

                <?php  if( (empty($_SESSION['user'])) || (!isset($_SESSION['user'])) ) {?>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php"><i class="fas fa-sign-in-alt"></i> Se connecter</span></a>
                </li>
                <?php } else { ?>
                  <li class="nav-item">
                  <a class="nav-link" href="#">Bienvenue <?php echo $_SESSION['user'];?> </span></a>
                  <?php } ?>
                  </li>
              </ul>
            </div>
          </nav>
    </section>
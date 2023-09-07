<?php
session_start();
ob_start();

include './classes/dbConnect.php';

$db = new dbConnect;

$message = "";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <title>Document</title>

</head>
<!-- connexion a votre site -->

<body>

    <header class="panneauAdmin">
        <div class="H1Logo">
            <img class="logo" id="animated-gif" src="img/logojessica.gif" alt="Animation GIF">
            <h1 class="titre">Panneau Admin</h1>
        </div>
        <?php
        if (empty($_SESSION)) {
            echo '
                    <a href="https://www.google.fr/"><img class="SignOut" src="img/SignOut.png" alt=""></a>
                    ';
        } else {
            echo '
                    <div class="bouton">
                        <li class="liHref"><a class="allHref" href="index.php?page=gestionSite">Gestion du site</a></li>
                        <li class="liHref"><a class="allHref" href="index.php?page=gestionCompte">Gestion du compte</a></li>
                        <li class="liHref"><a id="modal_pos1" class="allHref" href="#" data-bs-toggle="modal" data-bs-target="#modal1">Se deconnecter</a></li>
                        <a href="https://www.google.fr/"><img class="SignOut" src="img/SignOut.png" alt=""></a>
                    </div>
                    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modalContainer modal-content text-center text-dark p-3 rounded-4">

                                <button type="button" class="btn-close btn-close-dark ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>

                                <section>
                                    <h1 class="modalDecoText">voulez vous vraiment vous deconnecter ?</h1>

                                    <div class="">
                                    <form method="POST">
                                    <input class="modalDecoSubmit" name="submit_deconnexion" type="submit" value="Se deconnecter">
                                    </form>
                                    </div>
                                </section> 

                            </div>
                        </div>
                    </div>
                    ';
        }
        ?>
    </header>



    <!-- **************************************************CONNEXION*************************************************************** -->


    <?php

    if (empty($_SESSION)) {
        echo '
                    <section class="connexionAdmin">

                        <div class="titreConnexion">Connexion à votre site</div>
                        <form method="POST">
                        <label class="connexionLabel">Adresse mail</label>
                        <input class="allInput" name="emailAdmin" type="mail" placeholder="votre adresse mail" required>
                
                        <label class="connexionLabel">Mot de passe</label>
                        <input class="allInput" name="mdp_admin" type="password" placeholder="votre mot de passe" required>
                
                        <div>
                        <input class="connexionSubmit" name="submitConnexion" type="submit" value="Se connecter" >
                        </div>
                
                        <div>
                        <input class="connexionPassoublier" type="submit" value="Mot de passe oublié ?">
                        </form>
                        </div>
                    </section>
                    ';
    }


    if (isset($_POST['submitConnexion'])) {
        $emailAdmin = $_POST['emailAdmin'];
        $mdp_admin = $_POST['mdp_admin'];
        $user = $db->Connexion($emailAdmin, $mdp_admin);

        if ($user && password_verify($mdp_admin, $user['mdp_admin'])) {
            header("location:http://localhost/jessica_back/index.php?page=gestionSite");

            $db->setAdmin($user);
        } else {
            echo 'Identifiants invalides';
        }
    } else {
        if (isset($_GET['page']) == "") {
            echo '
                    <div class="connecter">
                        <p class="connecterP"> Bienvenue sur votre panneau d\'administration.</p>   
                        <p class="connecterP">ICI VOUS POUVEZ GERER VOTRE SITE ET VOS COMPTES</p>
                    </div>
                    ';
        }
    }
    ?>


    <!-- **********************************************GESTION******************************************************************* -->


    <?php

    if (!empty($_SESSION)) {
        if (isset($_GET['page']) && $_GET['page'] == "gestionCompte") {
            echo '
                        <div class="creationCompte">
                            <a href="index.php?page=creationCompte"><img src="img/iconAjouterCompte.png" alt=""></a>        
                            <p>Création d’un nouveau compte</p>                
                        </div>

                        <form method="POST" class="sectionContainerGestionCompte">
                            <div class="containerGestionCompte">
                                
                                <div class="titreGestionCompte">Modifier mon compte</div>
                        
                                <label class="LabelGestionCompte" for="">Adresse email</label>
                                <input class="allInput" name="email_admin" type="email" required>
                                
                                <label class="LabelGestionCompte" >Mot de passe</label>
                                <input class="allInput" name="new_password" type="password" required>
                                
                                <label  class="LabelGestionCompte" >Confirmer votre mot de passe</label>
                                <input class="allInput" name="confirmationMotDePasse" type="password" required>
                                
                                <input class="connexionSubmit2" name="modifCompte" type="submit" value="ENVOYER">
                                    
                             </div>
                            
                        </form>                    
                        ';



            if (isset($_POST['modifCompte'])) {
                $idAdmin = $_SESSION['id_admin'];
                $email = $_POST['email_admin'];
                $motDePasse = $_POST['new_password'];
                $confirmationMotDePasse = $_POST['confirmationMotDePasse'];

                if ($motDePasse === $confirmationMotDePasse) {
                    $db->modifCompte($idAdmin, $email, $motDePasse);
                    $_SESSION['id_admin'] = $idAdmin;
                    $_SESSION['email_admin'] = $email;
                    header('Location: ./index.php');
                } else {
                    echo 'mot de passe et confirmation mot de passe différent ! Veuillez re-saisir les mots de passe';
                }
            }
        }
    }




    // *********************************************CREATION********************************************************************




    if (isset($_GET['page']) && $_GET['page'] == "creationCompte") {

        if (isset($_POST['submitCreation'])) {
            $emailAdmin = $_POST['mail_creation'];
            $mdp_admin = $_POST['mdp_creation'];
            $db->creationCompte($emailAdmin, $mdp_admin);
        }

        echo '
                        <form method="POST" class="sectionContainerCreationCompte">
                            
                            <div class="containerCreationCompte">
                                
                                <div class="titreGestionCompte">Création d\'un nouvel utilisateur</div>
                        
                                <label class="LabelGestionCompte" for="">Adresse email</label>
                                <input class="allInput" name="mail_creation" type="email" required>
                                
                                <label class="LabelGestionCompte" >Mot de passe</label>
                                <input class="allInput" name="mdp_creation" type="password" required>
                                
                                <input class="connexionSubmit2" name="submitCreation" type="submit" value="ENVOYER">
                                
                            </div>

                            
                            
                        </form>  
                        <p><?php echo $message; ?></p>                  
                        ';
    }


    // *************************************************DECONNEXION****************************************************************

    if (isset($_POST['submit_deconnexion'])) {
        $Deconnexion = $db->deconnexion();
    }


    ob_end_flush();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


    <script src="script/script.js"></script>

</body>

</html>
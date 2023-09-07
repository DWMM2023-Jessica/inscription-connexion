<?php

include 'Database.php';

class DbConnect extends Database{
    private $dbConnect;    


    public function __construct()
    {
        
        $this->dbConnect = Database::dbConnect();
    }



    public function insertPartenaire ($nomCollab,$logoCollab){        
        $sqlinsertPartenaire = "INSERT INTO collab(nom_collab, logo_collab, id_style)
                                VALUES (:nom_collab, :logo_collab, :id_style)";

        $stmtinsertPartenaire =$this->dbConnect->prepare($sqlinsertPartenaire);
        $stmtinsertPartenaire->bindValue(':nom_collab', $nomCollab);
        $stmtinsertPartenaire->bindValue(':logo_collab', $logoCollab);
        $stmtinsertPartenaire->bindValue(':id_style', "1");

        $stmtinsertPartenaire->execute();
        
        return 'Le partenaire a bien été ajouté';
    } 

    public function insertEntreprise ($nomCollab,$logoCollab){        
        $sqlinsertEntreprise = "INSERT INTO collab(nom_collab, logo_collab, id_style)
                                VALUES (:nom_collab, :logo_collab, :id_style)";

        $stmtinsertEntreprise =$this->dbConnect->prepare($sqlinsertEntreprise);
        $stmtinsertEntreprise->bindValue(':nom_collab', $nomCollab);
        $stmtinsertEntreprise->bindValue(':logo_collab', $logoCollab);
        $stmtinsertEntreprise->bindValue(':id_style', "2");
        $stmtinsertEntreprise->execute();
        
        return 'L\'entreprise a été bien ajoutée';
    } 

    public function creationCompte($emailAdmin, $mdp_admin) {
        $insertUserQuery = "INSERT INTO `admin` (email_admin, mdp_admin, `role`) 
                            VALUES (:email_admin, :mdp_admin, :role)";
        $insertUserStmt = $this->dbConnect->prepare($insertUserQuery);
        $insertUserStmt->bindValue(':email_admin', $emailAdmin);
        $insertUserStmt->bindValue(':mdp_admin', $mdp_admin);
        $insertUserStmt->bindValue(':role', "0");
        $insertUserStmt->bindValue('mdp_admin', password_hash($mdp_admin, PASSWORD_DEFAULT)); 
        $insertUserStmt->execute();
        echo "Le compte a été créé avec succès!";
    }

    
    public function Connexion($emailAdmin) {
        $checkUserQuery = "SELECT * FROM admin WHERE email_admin = :email_admin";
        $checkUserStmt = $this->dbConnect->prepare($checkUserQuery);
        $checkUserStmt->bindValue(':email_admin', $emailAdmin);
        $checkUserStmt->execute();
        $user = $checkUserStmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }  

    public function setAdmin($user) {
        $_SESSION['id_admin'] = $user['id_admin'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email_admin'] = $user['email_admin'];
    }
    
    public function deconnexion() {
        session_destroy();
        echo "<h1>Merci de votre visite !</h1>";
        echo "<p>Nous vous remercions d'avoir visité notre site. Nous espérons vous revoir bientôt !</p>";
        header("refresh:1;url=http://localhost/jessica_back/index.php?page=gestionCompte");
        exit();
    }

    public function modifCompte ($idAdmin, $newEmail, $newPassword) {
        $updateUserQuery = "UPDATE admin
                            SET email_admin = :new_email,  
                                mdp_admin = :new_password
                            WHERE id_admin = :admin_id";
        $updateUserStmt = $this->dbConnect->prepare($updateUserQuery);
        $updateUserStmt->bindValue(':new_email',$newEmail);
        $updateUserStmt->bindValue(':new_password',password_hash($newPassword, PASSWORD_DEFAULT));
        $updateUserStmt->bindValue(':admin_id',$idAdmin);
        $updateUserStmt->execute();
        return 'les modifications ont bien été prises en compte!';
    }

} 

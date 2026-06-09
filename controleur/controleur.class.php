<?php
require_once("modele/modele.class.php");

class Controleur {
    private $unModele;

    public function __construct() {
        $this->unModele = new Modele();
    }

    /* =====================================================
     * VALIDATION
     * ===================================================== */
    public function validerDonnees($data, $isInscription = false) {
        $erreurs = [];

        if (!empty($data['nom'])) {
            $nom = trim($data['nom']);
            if (strlen($nom) < 2) {
                $erreurs[] = "Le nom doit contenir au moins 2 caractères.";
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s\-']+$/u", $nom)) {
                $erreurs[] = "Le nom ne peut contenir que des lettres.";
            }
        }

        if (!empty($data['prenom'])) {
            $prenom = trim($data['prenom']);
            if (strlen($prenom) < 2) {
                $erreurs[] = "Le prénom doit contenir au moins 2 caractères.";
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s\-']+$/u", $prenom)) {
                $erreurs[] = "Le prénom ne peut contenir que des lettres.";
            }
        }

        if (!empty($data['email']) && !filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = "L'email doit être valide (contenir @ et un domaine comme .fr, .com).";
        }

        if (!empty($data['tel'])) {
            $tel_propre = preg_replace('/[^0-9]/', '', $data['tel']);
            if (strlen($tel_propre) < 10) {
                $erreurs[] = "Le téléphone doit contenir au moins 10 chiffres.";
            }
            if (!preg_match("/^[0-9\s\-\+\(\)]+$/", $data['tel'])) {
                $erreurs[] = "Le téléphone ne peut contenir que des chiffres, espaces, +, -, (, ).";
            }
        }

        if (!empty($data['date_code']) && !empty($data['date_permis'])) {
            if ($data['date_code'] === $data['date_permis']) {
                $erreurs[] = "La date prévue du code ne peut pas être identique à celle du permis.";
            }
            if (strtotime($data['date_permis']) < strtotime($data['date_code'])) {
                $erreurs[] = "La date du permis doit être postérieure à celle du code.";
            }
        }

        if ($isInscription) {
            if (empty($data['mdp'])) {
                $erreurs[] = "Le mot de passe est obligatoire.";
            } else {
                $erreurs = array_merge($erreurs, $this->reglesMotDePasse($data['mdp']));
            }
            if (!empty($data['mdp']) && !empty($data['mdp2']) && $data['mdp'] !== $data['mdp2']) {
                $erreurs[] = "Les mots de passe ne correspondent pas.";
            }
        }

        if (!$isInscription && !empty($data['mdp'])) {
            $erreurs = array_merge($erreurs, $this->reglesMotDePasse($data['mdp']));
        }

        return $erreurs;
    }

    private function reglesMotDePasse($mdp) {
        $erreurs = [];
        if (strlen($mdp) < 8) {
            $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
        if (preg_match('/\s/', $mdp)) {
            $erreurs[] = "Le mot de passe ne peut pas contenir d'espaces.";
        }
        if (!preg_match('/[A-Z]/', $mdp)) {
            $erreurs[] = "Le mot de passe doit contenir au moins une majuscule.";
        }
        if (!preg_match('/[0-9]/', $mdp)) {
            $erreurs[] = "Le mot de passe doit contenir au moins un chiffre.";
        }
        return $erreurs;
    }

    /* =====================================================
     * CONNEXION
     * ===================================================== */
    public function verifConnexion($email, $mdp) {
        return $this->unModele->verifConnexion(trim($email), $mdp);
    }

    public function verifConnexionCandidat($email, $mdp) {
        return $this->unModele->verifConnexionCandidat(trim($email), $mdp);
    }

    public function verifConnexionMoniteur($email, $mdp) {
        return $this->unModele->verifConnexionMoniteur(trim($email), $mdp);
    }

    /* =====================================================
     * PLANNING
     * ===================================================== */
    public function selectCours_byCandidat($idcandidat) {
        return $this->unModele->selectCours_byCandidat($idcandidat);
    }

    public function selectCours_byMoniteur($idmoniteur) {
        return $this->unModele->selectCours_byMoniteur($idmoniteur);
    }

    public function countCoursRestants($idcandidat) {
        return $this->unModele->countCoursRestants($idcandidat);
    }

    /* =====================================================
     * CANDIDATS
     * ===================================================== */
    public function insert_candidat($tab) {
        $this->unModele->insert_candidat($tab);
    }

    public function selectAll_candidats() {
        return $this->unModele->selectAll_candidats();
    }

    public function delete_candidat($idcandidat) {
        $this->unModele->delete_candidat($idcandidat);
    }

    public function selectWhere_candidat($idcandidat) {
        return $this->unModele->selectWhere_candidat($idcandidat);
    }

    public function update_candidat($tab) {
        $this->unModele->update_candidat($tab);
    }

    public function changerMotDePassePremierConnexion($idcandidat, $nouveau_mdp) {
        $this->unModele->changerMotDePassePremierConnexion($idcandidat, $nouveau_mdp);
    }

    /* =====================================================
     * MONITEURS
     * ===================================================== */
    public function insert_moniteur($tab) {
        return $this->unModele->insert_moniteur($tab);
    }

    public function update_moniteur($tab) {
        return $this->unModele->update_moniteur($tab);
    }

    public function delete_moniteur($idmoniteur) {
        return $this->unModele->delete_moniteur($idmoniteur);
    }

    public function selectWhere_moniteur($idmoniteur) {
        return $this->unModele->selectWhere_moniteur($idmoniteur);
    }

    public function selectAll_moniteurs() {
        return $this->unModele->selectAll_moniteurs();
    }

    /* =====================================================
     * VEHICULES
     * ===================================================== */
    public function insert_vehicule($tab) {
        $this->unModele->insert_vehicule($tab);
    }

    public function selectAll_vehicules() {
        return $this->unModele->selectAll_vehicules();
    }

    public function delete_vehicule($idvehicule) {
        $this->unModele->delete_vehicule($idvehicule);
    }

    public function selectWhere_vehicule($idvehicule) {
        return $this->unModele->selectWhere_vehicule($idvehicule);
    }

    public function update_vehicule($tab) {
        $this->unModele->update_vehicule($tab);
    }

    /* =====================================================
     * COURS
     * ===================================================== */
    public function insert_cours($tab) {
        $this->unModele->insert_cours($tab);
    }

    public function selectAll_cours() {
        return $this->unModele->selectAll_cours();
    }

    public function selectWhere_cours($idcours) {
        return $this->unModele->selectWhere_cours($idcours);
    }

    public function update_cours($tab) {
        $this->unModele->update_cours($tab);
    }

    public function delete_cours($idcours) {
        $this->unModele->delete_cours($idcours);
    }

    /* =====================================================
     * MOI (profil utilisateur)
     * ===================================================== */
    public function selectWhere_utilisateur($idutilisateur) {
        return $this->unModele->selectWhere_utilisateur($idutilisateur);
    }

    public function update_mon_profil($idutilisateur, $tab) {
        $this->unModele->update_mon_profil($idutilisateur, $tab);
    }

    public function getIdUtilisateur_byMoniteur($idmoniteur) {
        return $this->unModele->getIdUtilisateur_byMoniteur($idmoniteur);
    }

    public function getIdUtilisateur_byCandidat($idcandidat) {
        return $this->unModele->getIdUtilisateur_byCandidat($idcandidat);
    }

    /* =====================================================
     * ACTIONS MONITEUR
     * ===================================================== */
    public function update_statut_cours_moniteur($idcours, $idmoniteur, $statut) {
        $this->unModele->update_statut_cours_moniteur($idcours, $idmoniteur, $statut);
    }

    public function selectCandidats_byMoniteur($idmoniteur) {
        return $this->unModele->selectCandidats_byMoniteur($idmoniteur);
    }

    public function selectAll_vehicules_avec_etat() {
        return $this->unModele->selectAll_vehicules_avec_etat();
    }
}

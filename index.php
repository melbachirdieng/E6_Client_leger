<?php
session_start();
require_once("controleur/controleur.class.php");
$unControleur = new Controleur();

$message = '';
$leCandidat = $leMoniteur = $leVehicule = $leCours = null;
$lescandidats = $lesmoniteurs = $lesvehicules = $lescours = array();

// === CHANGEMENT DE MOT DE PASSE PREMIÈRE CONNEXION ===
if (isset($_POST['changer_mdp_premier'])) {
    if ($_POST['nouveau_mdp'] !== $_POST['nouveau_mdp2']) {
        $message = '<div class="alert alert-error">❌ Les mots de passe ne correspondent pas.</div>';
    } elseif (strlen($_POST['nouveau_mdp']) < 8) {
        $message = '<div class="alert alert-error">❌ Le mot de passe doit contenir au moins 8 caractères.</div>';
    } else {
        $unControleur->changerMotDePassePremierConnexion($_SESSION['idcandidat'], $_POST['nouveau_mdp']);
        $_SESSION['premier_connexion'] = 0;
        header("Location: index.php?page=50");
        exit();
    }
}

// === CONNEXION ===
if (isset($_POST['Connexion'])) {
    $user = $unControleur->verifConnexion($_POST['email'], $_POST['mdp']);
    if ($user) {
        $_SESSION['idutilisateur'] = $user['idutilisateur'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        // Rôle issu directement de la BDD (pas en dur dans le code)
        $_SESSION['role'] = $user['role'];
        header("Location: index.php?page=5");
        exit();
    }

    $candidat = $unControleur->verifConnexionCandidat($_POST['email'], $_POST['mdp']);
    if ($candidat) {
        $_SESSION['idutilisateur'] = $candidat['idutilisateur'];
        $_SESSION['email'] = $candidat['email'];
        $_SESSION['nom'] = $candidat['nom'];
        $_SESSION['prenom'] = $candidat['prenom'];
        $_SESSION['idcandidat'] = $candidat['idcandidat'];
        $_SESSION['role'] = 'candidat';
        $_SESSION['date_prevue_code'] = $candidat['date_prevue_code'];
        $_SESSION['date_prevue_permis'] = $candidat['date_prevue_permis'];
        $_SESSION['premier_connexion'] = $candidat['premier_connexion'];

        if ($candidat['premier_connexion'] == 1) {
            header("Location: index.php?page=52");
            exit();
        }
        header("Location: index.php?page=50");
        exit();
    }

    $moniteur = $unControleur->verifConnexionMoniteur($_POST['email'], $_POST['mdp']);
    if ($moniteur) {
        $_SESSION['idutilisateur'] = $moniteur['idutilisateur'];
        $_SESSION['email'] = $moniteur['email'];
        $_SESSION['nom'] = $moniteur['nom'];
        $_SESSION['prenom'] = $moniteur['prenom'];
        $_SESSION['idmoniteur'] = $moniteur['idmoniteur'];
        $_SESSION['role'] = 'moniteur';
        header("Location: index.php?page=60");
        exit();
    }

    $message = '<div class="alert alert-error">Identifiants incorrects</div>';
}

// === INSCRIPTION ===
if (isset($_POST['Sinscrire'])) {
    $erreurs = $unControleur->validerDonnees($_POST, true);

    if (empty($erreurs)) {
        try {
            $_POST['premier_connexion'] = 0;
            $unControleur->insert_candidat($_POST);
            $message = '<div class="alert alert-success">✅ Inscription réussie ! Nous vous contacterons sous 24h.</div>';
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false || strpos($e->getMessage(), '1062') !== false) {
                $message = '<div class="alert alert-error">❌ Cet email est déjà utilisé.</div>';
            } else {
                $message = '<div class="alert alert-error">❌ Erreur lors de l\'inscription.</div>';
            }
        }
    } else {
        $message = '<div class="alert alert-error">❌ ' . implode('<br>', $erreurs) . '</div>';
    }
}

// === GESTION ADMIN ===
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

    if (isset($_POST['valider'])) {
        $erreurs = $unControleur->validerDonnees($_POST, true);
        if (empty($erreurs)) {
            try {
                $_POST['premier_connexion'] = 1;
                $unControleur->insert_candidat($_POST);
                header("Location: index.php?page=5");
                exit();
            } catch (Exception $e) {
                $message = '<div class="alert alert-error">❌ Cet email existe déjà.</div>';
            }
        } else {
            $message = '<div class="alert alert-error">❌ ' . implode('<br>', $erreurs) . '</div>';
        }
    }

    if (isset($_POST['Modifier'])) {
        $erreurs = $unControleur->validerDonnees($_POST);
        if (empty($erreurs)) {
            $unControleur->update_candidat($_POST);
            header("Location: index.php?page=5");
            exit();
        } else {
            $message = '<div class="alert alert-error">❌ ' . implode('<br>', $erreurs) . '</div>';
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'sup' && isset($_GET['idcandidat'])) {
        $unControleur->delete_candidat($_GET['idcandidat']);
        header("Location: index.php?page=5");
        exit();
    }

    if (isset($_POST['valider_moniteur'])) {
        $erreurs = $unControleur->validerDonnees($_POST);
        if (empty($erreurs)) {
            try {
                $unControleur->insert_moniteur($_POST);
                header("Location: index.php?page=6");
                exit();
            } catch (Exception $e) {
                $message = '<div class="alert alert-error">❌ Cet email existe déjà.</div>';
            }
        } else {
            $message = '<div class="alert alert-error">❌ ' . implode('<br>', $erreurs) . '</div>';
        }
    }

    if (isset($_POST['ModifierMoniteur'])) {
        $erreurs = $unControleur->validerDonnees($_POST);
        if (empty($erreurs)) {
            $unControleur->update_moniteur($_POST);
            header("Location: index.php?page=6");
            exit();
        } else {
            $message = '<div class="alert alert-error">❌ ' . implode('<br>', $erreurs) . '</div>';
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'supMoniteur' && isset($_GET['idmoniteur'])) {
        $unControleur->delete_moniteur($_GET['idmoniteur']);
        header("Location: index.php?page=6");
        exit();
    }

    if (isset($_POST['valider_vehicule'])) {
        $imageName = 'default-car.jpg';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 5000000) {
                $imageName = uniqid() . '.' . $ext;
                if (!is_dir('uploads/vehicules')) {
                    mkdir('uploads/vehicules', 0777, true);
                }
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/vehicules/' . $imageName);
            }
        }
        $_POST['image'] = $imageName;
        $unControleur->insert_vehicule($_POST);
        header("Location: index.php?page=7");
        exit();
    }

    if (isset($_POST['ModifierVehicule'])) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 5000000) {
                $imageName = uniqid() . '.' . $ext;
                if (!is_dir('uploads/vehicules')) {
                    mkdir('uploads/vehicules', 0777, true);
                }
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/vehicules/' . $imageName);
                $_POST['image'] = $imageName;
            }
        } else {
            $vehicule = $unControleur->selectWhere_vehicule($_POST['idvehicule']);
            $_POST['image'] = $vehicule['image'];
        }
        $unControleur->update_vehicule($_POST);
        header("Location: index.php?page=7");
        exit();
    }

    if (isset($_GET['action']) && $_GET['action'] == 'supVehicule' && isset($_GET['idvehicule'])) {
        $unControleur->delete_vehicule($_GET['idvehicule']);
        header("Location: index.php?page=7");
        exit();
    }

    if (isset($_POST['planifier'])) {
        try {
            $unControleur->insert_cours($_POST);
            header("Location: index.php?page=8");
            exit();
        } catch (Exception $e) {
            $message = '<div class="alert alert-error">❌ ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
    if (isset($_POST['ModifierCours'])) {
        try {
            $unControleur->update_cours($_POST);
            header("Location: index.php?page=8");
            exit();
        } catch (Exception $e) {
            $message = '<div class="alert alert-error">❌ ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
    if (isset($_GET['action']) && $_GET['action'] == 'supCours' && isset($_GET['idcours'])) {
        $unControleur->delete_cours($_GET['idcours']);
        header("Location: index.php?page=8");
        exit();
    }
}

// === DÉCONNEXION (uniquement par POST pour empêcher la déco forcée via image piégée) ===
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// === MODIFIER MON PROFIL (candidat ou moniteur connecté) ===
if (isset($_POST['Modifier_mon_profil'])) {
    $erreurs = $unControleur->validerDonnees($_POST);
    if (empty($erreurs)) {
        try {
            $unControleur->update_mon_profil($_SESSION['idutilisateur'], $_POST);
            $_SESSION['nom'] = $_POST['nom'];
            $_SESSION['prenom'] = $_POST['prenom'];
            $_SESSION['email'] = $_POST['email'];
            $message = '<div class="alert alert-success">✅ Profil mis à jour.</div>';
        } catch (Exception $e) {
            $message = '<div class="alert alert-error">❌ Erreur : email déjà utilisé ?</div>';
        }
    } else {
        $message = '<div class="alert alert-error">❌ ' . implode('<br>', $erreurs) . '</div>';
    }
}

// === MONITEUR : valider / annuler son cours ===
if (isset($_SESSION['role']) && $_SESSION['role'] === 'moniteur'
    && isset($_POST['action_cours']) && isset($_POST['idcours'])) {
    $statut = $_POST['action_cours'] === 'valider' ? 'Effectué' : 'Annulé';
    try {
        $unControleur->update_statut_cours_moniteur($_POST['idcours'], $_SESSION['idmoniteur'], $statut);
        header("Location: index.php?page=60");
        exit();
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">❌ ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Castellane Auto</title>
    <link rel="stylesheet" href="design/style.css">
</head>
<body>

<?php include("vue/entete.php"); ?>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'candidat' && $_SESSION['premier_connexion'] == 0): ?>
    <div style="background: linear-gradient(135deg, #0F4C81 0%, #0F4C81 100%); color: white; padding: 15px 20px; text-align: center; font-weight: 600;">
        Dates prévues :
        <span style="margin: 0 20px;">
            Code : <?= !empty($_SESSION['date_prevue_code']) ? date('d/m/Y', strtotime($_SESSION['date_prevue_code'])) : 'Non définie' ?>
        </span>
        <span>
            Permis : <?= !empty($_SESSION['date_prevue_permis']) ? date('d/m/Y', strtotime($_SESSION['date_prevue_permis'])) : 'Non définie' ?>
        </span>
    </div>
<?php endif; ?>

<main>
    <?php if($message) echo $message; ?>

    <?php
    $page = $_GET['page'] ?? 1;

    switch ($page) {
        case 1: include("vue/public/accueil.php"); break;
        case 2: include("vue/public/tarifs.php"); break;
        case 3:
            $lesvehicules = $unControleur->selectAll_vehicules();
            $lesvehicules = array_filter($lesvehicules, function($v) {
                return $v['etat'] == 'Disponible';
            });
            include("vue/public/flotte.php");
            break;
        case 4: include("vue/public/test_code.php"); break;
        case 10: include("vue/public/vue_inscription.php"); break;
        case 99: include("vue/vue_connexion.php"); break;

        case 50:
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'candidat') {
                if ($_SESSION['premier_connexion'] == 1) {
                    header("Location: index.php?page=52");
                    exit();
                }
                $lescours = $unControleur->selectCours_byCandidat($_SESSION['idcandidat']);
                $nbRestants = $unControleur->countCoursRestants($_SESSION['idcandidat']);
                include("vue/admin/vue_planning_candidat.php");
            } else {
                header("Location: index.php?page=99");
                exit();
            }
            break;

        case 52:
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'candidat' && $_SESSION['premier_connexion'] == 1) {
                include("vue/candidat/changement_mdp_premier.php");
            } else {
                header("Location: index.php?page=50");
                exit();
            }
            break;

        case 53:
            // Candidat : voir / modifier son profil
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'candidat') {
                $monProfil = $unControleur->selectWhere_utilisateur($_SESSION['idutilisateur']);
                include("vue/candidat/vue_profil_candidat.php");
            } else { header("Location: index.php?page=99"); exit(); }
            break;

        case 60:
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'moniteur') {
                $lescours = $unControleur->selectCours_byMoniteur($_SESSION['idmoniteur']);
                include("vue/moniteur/vue_planning_moniteur.php");
            } else {
                header("Location: index.php?page=99");
                exit();
            }
            break;

        case 61:
            // Moniteur : ses candidats (lecture seule)
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'moniteur') {
                $lescandidats = $unControleur->selectCandidats_byMoniteur($_SESSION['idmoniteur']);
                include("vue/moniteur/vue_candidats_moniteur.php");
            } else { header("Location: index.php?page=99"); exit(); }
            break;

        case 62:
            // Moniteur : voir les véhicules de l'auto-école (lecture seule, état visible)
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'moniteur') {
                $lesvehicules = $unControleur->selectAll_vehicules_avec_etat();
                include("vue/moniteur/vue_vehicules_moniteur.php");
            } else { header("Location: index.php?page=99"); exit(); }
            break;

        case 63:
            // Moniteur : voir / modifier son profil
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'moniteur') {
                $monProfil = $unControleur->selectWhere_utilisateur($_SESSION['idutilisateur']);
                include("vue/moniteur/vue_profil_moniteur.php");
            } else { header("Location: index.php?page=99"); exit(); }
            break;

        case 5:
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                    $leCandidat = $unControleur->selectWhere_candidat($_GET['idcandidat']);
                }
                include("vue/admin/vue_insert_candidat.php");
                $lescandidats = $unControleur->selectAll_candidats();
                include("vue/admin/vue_select_candidat.php");
            } else {
                header("Location: index.php?page=99");
                exit();
            }
            break;

        case 6:
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                if (isset($_GET['action']) && $_GET['action'] == 'editMoniteur') {
                    $leMoniteur = $unControleur->selectWhere_moniteur($_GET['idmoniteur']);
                }
                include("vue/admin/vue_insert_moniteur.php");
                $lesmoniteurs = $unControleur->selectAll_moniteurs();
                include("vue/admin/vue_select_moniteur.php");
            } else {
                header("Location: index.php?page=99");
                exit();
            }
            break;

        case 7:
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                if (isset($_GET['action']) && $_GET['action'] == 'editVehicule') {
                    $leVehicule = $unControleur->selectWhere_vehicule($_GET['idvehicule']);
                }
                include("vue/admin/vue_insert_vehicule.php");
                $lesvehicules = $unControleur->selectAll_vehicules();
                include("vue/admin/vue_select_vehicule.php");
            } else {
                header("Location: index.php?page=99");
                exit();
            }
            break;

        case 8:
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                if (isset($_GET['action']) && $_GET['action'] == 'editCours') {
                    $leCours = $unControleur->selectWhere_cours($_GET['idcours']);
                }
                $lescandidats = $unControleur->selectAll_candidats();
                $lesmoniteurs = $unControleur->selectAll_moniteurs();
                $lesvehicules = $unControleur->selectAll_vehicules();
                include("vue/admin/vue_insert_cours.php");
                $lescours = $unControleur->selectAll_cours();
                include("vue/admin/vue_select_cours.php");
            } else {
                header("Location: index.php?page=99");
                exit();
            }
            break;

        default: include("vue/public/accueil.php"); break;
    }
    ?>
</main>

<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    include("vue/public/footer.php");
}
?>

</body>
</html>

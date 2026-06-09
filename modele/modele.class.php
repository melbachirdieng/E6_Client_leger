<?php
class Modele {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=auto_ecole;charset=utf8mb4", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log("PDO connect failed: " . $e->getMessage());
            throw new RuntimeException("Service indisponible : impossible de joindre la base de données.");
        }
    }

    /* --- CONNEXION --- */

    public function verifConnexion($email, $mdp) {
        $req = "SELECT * FROM utilisateur WHERE email = :email AND mdp = :mdp AND role = 'admin'";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":email" => trim($email), ":mdp" => trim($mdp)));
        return $select->fetch();
    }

    public function verifConnexionCandidat($email, $mdp) {
        $req = "SELECT c.idcandidat, u.idutilisateur, u.nom, u.prenom, u.email, u.premier_connexion,
                        c.date_prevue_code, c.date_prevue_permis, c.est_etudiant, c.nom_ecole
                FROM utilisateur u
                INNER JOIN candidats c ON c.idutilisateur = u.idutilisateur
                WHERE u.email = :email AND u.mdp = :mdp AND u.role = 'candidat'";
        $select = $this->pdo->prepare($req);
        $select->execute([":email" => trim($email), ":mdp" => trim($mdp)]);
        return $select->fetch();
    }

    public function verifConnexionMoniteur($email, $mdp) {
        $req = "SELECT m.idmoniteur, u.idutilisateur, u.nom, u.prenom, u.email,
                        m.experience, m.type_permis
                FROM utilisateur u
                INNER JOIN moniteur m ON m.idutilisateur = u.idutilisateur
                WHERE u.email = :email AND u.mdp = :mdp AND u.role = 'moniteur'";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":email" => trim($email), ":mdp" => trim($mdp)));
        return $select->fetch();
    }

    /* --- PLANNING --- */
    public function selectCours_byCandidat($idcandidat) {
        $req = "SELECT c.*,
                   CONCAT(mu.nom, ' ', mu.prenom) as nom_moniteur,
                   CONCAT(v.marque, ' ', v.modele) as modele_vehicule,
                   v.immatriculation
            FROM cours c
            INNER JOIN moniteur m ON c.idmoniteur = m.idmoniteur
            INNER JOIN utilisateur mu ON m.idutilisateur = mu.idutilisateur
            INNER JOIN vehicule v ON c.idvehicule = v.idvehicule
            WHERE c.idcandidat = :idcandidat
            ORDER BY c.date_cours ASC, c.heure_debut ASC";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":idcandidat" => $idcandidat));
        return $select->fetchAll();
    }

    public function selectCours_byMoniteur($idmoniteur) {
        $req = "SELECT c.*,
                   CONCAT(cu.nom, ' ', cu.prenom) as nom_candidat,
                   cu.tel as tel_candidat,
                   CONCAT(v.marque, ' ', v.modele) as modele_vehicule,
                   v.immatriculation
            FROM cours c
            INNER JOIN candidats cand ON c.idcandidat = cand.idcandidat
            INNER JOIN utilisateur cu ON cand.idutilisateur = cu.idutilisateur
            INNER JOIN vehicule v ON c.idvehicule = v.idvehicule
            WHERE c.idmoniteur = :idmoniteur
            ORDER BY c.date_cours ASC, c.heure_debut ASC";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":idmoniteur" => $idmoniteur));
        return $select->fetchAll();
    }

    public function countCoursRestants($idcandidat) {
        $req = "SELECT COUNT(*) as nb FROM cours WHERE idcandidat = :idcandidat AND statut = 'À venir'";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":idcandidat" => $idcandidat));
        $result = $select->fetch();
        return $result['nb'];
    }

    /* --- CANDIDATS --- */
    public function insert_candidat($tab) {
        // Transaction: INSERT utilisateur PUIS candidats
        try {
            $this->pdo->beginTransaction();

            // 1. INSERT dans utilisateur
            $req_user = "INSERT INTO utilisateur
                         (nom, prenom, email, mdp, tel, adresse, role, premier_connexion)
                         VALUES
                         (:nom, :prenom, :email, :mdp, :tel, :adresse, 'candidat', :premier_connexion)";
            $insert_user = $this->pdo->prepare($req_user);

            $insert_user->execute([
                ":nom" => trim($tab['nom']),
                ":prenom" => trim($tab['prenom']),
                ":email" => trim($tab['email']),
                ":tel" => isset($tab['tel']) ? trim($tab['tel']) : null,
                ":adresse" => isset($tab['adresse']) ? trim($tab['adresse']) : null,
                ":mdp" => trim($tab['mdp']),
                ":premier_connexion" => $tab['premier_connexion'] ?? 1
            ]);

            $idutilisateur = $this->pdo->lastInsertId();

            // 2. INSERT dans candidats
            $req_cand = "INSERT INTO candidats
                         (idutilisateur, est_etudiant, nom_ecole, date_prevue_code, date_prevue_permis)
                         VALUES
                         (:idutilisateur, :est_etudiant, :nom_ecole, NULL, NULL)";
            $insert_cand = $this->pdo->prepare($req_cand);
            $insert_cand->execute([
                ":idutilisateur" => $idutilisateur,
                ":est_etudiant" => $tab['est_etudiant'] ?? 0,
                ":nom_ecole" => isset($tab['nom_ecole']) ? trim($tab['nom_ecole']) : null
            ]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function selectAll_candidats() {
        $req = "SELECT c.idcandidat, u.idutilisateur, u.nom, u.prenom, u.email, u.tel, u.adresse,
                        c.est_etudiant, c.nom_ecole, c.date_prevue_code, c.date_prevue_permis
                FROM candidats c
                INNER JOIN utilisateur u ON c.idutilisateur = u.idutilisateur
                ORDER BY u.nom ASC";
        $select = $this->pdo->prepare($req);
        $select->execute();
        return $select->fetchAll();
    }

    public function delete_candidat($idcandidat) {
        $req_find = "SELECT idutilisateur FROM candidats WHERE idcandidat = :idcandidat";
        $find = $this->pdo->prepare($req_find);
        $find->execute(array(":idcandidat" => $idcandidat));
        $result = $find->fetch();

        if ($result) {
            // Supprimer l'utilisateur parent → la FK CASCADE supprime automatiquement le candidat
            $req = "DELETE FROM utilisateur WHERE idutilisateur = :idutilisateur";
            $delete = $this->pdo->prepare($req);
            $delete->execute(array(":idutilisateur" => $result['idutilisateur']));
        }
    }

    public function selectWhere_candidat($idcandidat) {
        $req = "SELECT c.idcandidat, u.idutilisateur, u.nom, u.prenom, u.email, u.tel, u.adresse,
                        c.est_etudiant, c.nom_ecole, c.date_prevue_code, c.date_prevue_permis
                FROM candidats c
                INNER JOIN utilisateur u ON c.idutilisateur = u.idutilisateur
                WHERE c.idcandidat = :idcandidat";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":idcandidat" => $idcandidat));
        return $select->fetch();
    }

    /** Mise à jour du profil par l'utilisateur lui-même (candidat ou moniteur).
     *  Ne touche QUE les champs personnels (pas le rôle ni les liens FK). */
    public function update_mon_profil($idutilisateur, $tab) {
        $req = "UPDATE utilisateur
                SET nom = :nom, prenom = :prenom, email = :email,
                    tel = :tel, adresse = :adresse
                WHERE idutilisateur = :idutilisateur";
        $update = $this->pdo->prepare($req);
        $update->execute([
            ":nom" => trim($tab['nom']),
            ":prenom" => trim($tab['prenom']),
            ":email" => trim($tab['email']),
            ":tel" => isset($tab['tel']) ? trim($tab['tel']) : null,
            ":adresse" => isset($tab['adresse']) ? trim($tab['adresse']) : null,
            ":idutilisateur" => $idutilisateur
        ]);
    }

    /** Récupère le profil utilisateur (sans le mdp) à partir de son id. */
    public function selectWhere_utilisateur($idutilisateur) {
        $req = "SELECT idutilisateur, nom, prenom, email, tel, adresse, role
                FROM utilisateur WHERE idutilisateur = :idutilisateur";
        $select = $this->pdo->prepare($req);
        $select->execute([":idutilisateur" => $idutilisateur]);
        return $select->fetch();
    }

    /** Trouve l'idutilisateur du moniteur. */
    public function getIdUtilisateur_byMoniteur($idmoniteur) {
        $req = "SELECT idutilisateur FROM moniteur WHERE idmoniteur = :idmoniteur";
        $s = $this->pdo->prepare($req);
        $s->execute([":idmoniteur" => $idmoniteur]);
        $r = $s->fetch();
        return $r ? $r['idutilisateur'] : null;
    }

    /** Trouve l'idutilisateur du candidat. */
    public function getIdUtilisateur_byCandidat($idcandidat) {
        $req = "SELECT idutilisateur FROM candidats WHERE idcandidat = :idcandidat";
        $s = $this->pdo->prepare($req);
        $s->execute([":idcandidat" => $idcandidat]);
        $r = $s->fetch();
        return $r ? $r['idutilisateur'] : null;
    }

    public function update_candidat($tab) {
        try {
            $this->pdo->beginTransaction();

            // Trouver idutilisateur
            $req_find = "SELECT idutilisateur FROM candidats WHERE idcandidat = :idcandidat";
            $find = $this->pdo->prepare($req_find);
            $find->execute(array(":idcandidat" => $tab['idcandidat']));
            $cand = $find->fetch();
            $idutilisateur = $cand['idutilisateur'];

            // UPDATE utilisateur
            if (!empty($tab['mdp'])) {
                $req_user = "UPDATE utilisateur SET nom=:nom, prenom=:prenom, email=:email, mdp=:mdp, tel=:tel, adresse=:adresse WHERE idutilisateur=:idutilisateur";
                $update_user = $this->pdo->prepare($req_user);
                $update_user->execute(array(
                    ":nom" => trim($tab['nom']),
                    ":prenom" => trim($tab['prenom']),
                    ":email" => trim($tab['email']),
                    ":mdp" => trim($tab['mdp']),
                    ":tel" => isset($tab['tel']) ? trim($tab['tel']) : null,
                    ":adresse" => isset($tab['adresse']) ? trim($tab['adresse']) : null,
                    ":idutilisateur" => $idutilisateur
                ));
            } else {
                $req_user = "UPDATE utilisateur SET nom=:nom, prenom=:prenom, email=:email, tel=:tel, adresse=:adresse WHERE idutilisateur=:idutilisateur";
                $update_user = $this->pdo->prepare($req_user);
                $update_user->execute(array(
                    ":nom" => trim($tab['nom']),
                    ":prenom" => trim($tab['prenom']),
                    ":email" => trim($tab['email']),
                    ":tel" => isset($tab['tel']) ? trim($tab['tel']) : null,
                    ":adresse" => isset($tab['adresse']) ? trim($tab['adresse']) : null,
                    ":idutilisateur" => $idutilisateur
                ));
            }

            // UPDATE candidats
            $req_cand = "UPDATE candidats SET est_etudiant=:est_etudiant, nom_ecole=:nom_ecole, date_prevue_code=:date_prevue_code, date_prevue_permis=:date_prevue_permis WHERE idcandidat=:idcandidat";
            $update_cand = $this->pdo->prepare($req_cand);
            $update_cand->execute(array(
                ":est_etudiant" => $tab['est_etudiant'] ?? 0,
                ":nom_ecole" => isset($tab['nom_ecole']) ? trim($tab['nom_ecole']) : null,
                ":date_prevue_code" => isset($tab['date_code']) ? $tab['date_code'] : null,
                ":date_prevue_permis" => isset($tab['date_permis']) ? $tab['date_permis'] : null,
                ":idcandidat" => $tab['idcandidat']
            ));

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function changerMotDePassePremierConnexion($idcandidat, $nouveau_mdp) {
        try {
            $this->pdo->beginTransaction();

            // Trouver idutilisateur
            $req_find = "SELECT idutilisateur FROM candidats WHERE idcandidat = :idcandidat";
            $find = $this->pdo->prepare($req_find);
            $find->execute(array(":idcandidat" => $idcandidat));
            $cand = $find->fetch();

            if ($cand) {
                $req = "UPDATE utilisateur SET mdp = :mdp, premier_connexion = 0 WHERE idutilisateur = :idutilisateur";
                $update = $this->pdo->prepare($req);
                $update->execute([
                    ":mdp" => trim($nouveau_mdp),
                    ":idutilisateur" => $cand['idutilisateur']
                ]);
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /* --- MONITEURS --- */
    public function insert_moniteur($tab) {
        try {
            $this->pdo->beginTransaction();

            // 1. INSERT utilisateur
            $req_user = "INSERT INTO utilisateur
                         (nom, prenom, email, mdp, tel, adresse, role, premier_connexion)
                         VALUES
                         (:nom, :prenom, :email, :mdp, :tel, :adresse, 'moniteur', 0)";
            $insert_user = $this->pdo->prepare($req_user);

            $insert_user->execute(array(
                ":nom" => trim($tab['nom']),
                ":prenom" => trim($tab['prenom']),
                ":email" => trim($tab['email']),
                ":mdp" => trim($tab['mdp']),
                ":tel" => isset($tab['tel']) ? trim($tab['tel']) : null,
                ":adresse" => isset($tab['adresse']) ? trim($tab['adresse']) : null
            ));

            $idutilisateur = $this->pdo->lastInsertId();

            // 2. INSERT moniteur
            $req_mon = "INSERT INTO moniteur (idutilisateur, experience, type_permis)
                        VALUES (:idutilisateur, :experience, :type_permis)";
            $insert_mon = $this->pdo->prepare($req_mon);
            $insert_mon->execute(array(
                ":idutilisateur" => $idutilisateur,
                ":experience" => $tab['experience'] ?? 0,
                ":type_permis" => isset($tab['type_permis']) ? trim($tab['type_permis']) : null
            ));

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function selectAll_moniteurs() {
        $req = "SELECT m.idmoniteur, u.idutilisateur, u.nom, u.prenom, u.email, u.tel, u.adresse,
                        m.experience, m.type_permis
                FROM moniteur m
                INNER JOIN utilisateur u ON m.idutilisateur = u.idutilisateur
                ORDER BY u.nom ASC";
        $select = $this->pdo->prepare($req);
        $select->execute();
        return $select->fetchAll();
    }

    public function delete_moniteur($idmoniteur) {
        $req_find = "SELECT idutilisateur FROM moniteur WHERE idmoniteur = :idmoniteur";
        $find = $this->pdo->prepare($req_find);
        $find->execute(array(":idmoniteur" => $idmoniteur));
        $result = $find->fetch();

        if ($result) {
            // Supprimer l'utilisateur parent → la FK CASCADE supprime automatiquement le moniteur
            $req = "DELETE FROM utilisateur WHERE idutilisateur = :idutilisateur";
            $delete = $this->pdo->prepare($req);
            $delete->execute(array(":idutilisateur" => $result['idutilisateur']));
        }
    }

    public function selectWhere_moniteur($idmoniteur) {
        $req = "SELECT m.idmoniteur, u.idutilisateur, u.nom, u.prenom, u.email, u.tel, u.adresse,
                        m.experience, m.type_permis
                FROM moniteur m
                INNER JOIN utilisateur u ON m.idutilisateur = u.idutilisateur
                WHERE m.idmoniteur = :idmoniteur";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":idmoniteur" => $idmoniteur));
        return $select->fetch();
    }

    public function update_moniteur($tab) {
        try {
            $this->pdo->beginTransaction();

            // Trouver idutilisateur
            $req_find = "SELECT idutilisateur FROM moniteur WHERE idmoniteur = :idmoniteur";
            $find = $this->pdo->prepare($req_find);
            $find->execute(array(":idmoniteur" => $tab['idmoniteur']));
            $mon = $find->fetch();
            $idutilisateur = $mon['idutilisateur'];

            // UPDATE utilisateur
            if (!empty($tab['mdp'])) {
                $req_user = "UPDATE utilisateur SET nom=:nom, prenom=:prenom, email=:email, mdp=:mdp, tel=:tel, adresse=:adresse WHERE idutilisateur=:idutilisateur";
                $update_user = $this->pdo->prepare($req_user);
                $update_user->execute(array(
                    ":nom" => trim($tab['nom']),
                    ":prenom" => trim($tab['prenom']),
                    ":email" => trim($tab['email']),
                    ":mdp" => trim($tab['mdp']),
                    ":tel" => isset($tab['tel']) ? trim($tab['tel']) : null,
                    ":adresse" => isset($tab['adresse']) ? trim($tab['adresse']) : null,
                    ":idutilisateur" => $idutilisateur
                ));
            } else {
                $req_user = "UPDATE utilisateur SET nom=:nom, prenom=:prenom, email=:email, tel=:tel, adresse=:adresse WHERE idutilisateur=:idutilisateur";
                $update_user = $this->pdo->prepare($req_user);
                $update_user->execute(array(
                    ":nom" => trim($tab['nom']),
                    ":prenom" => trim($tab['prenom']),
                    ":email" => trim($tab['email']),
                    ":tel" => isset($tab['tel']) ? trim($tab['tel']) : null,
                    ":adresse" => isset($tab['adresse']) ? trim($tab['adresse']) : null,
                    ":idutilisateur" => $idutilisateur
                ));
            }

            // UPDATE moniteur
            $req_mon = "UPDATE moniteur SET experience=:experience, type_permis=:type_permis WHERE idmoniteur=:idmoniteur";
            $update_mon = $this->pdo->prepare($req_mon);
            $update_mon->execute(array(
                ":experience" => $tab['experience'] ?? 0,
                ":type_permis" => isset($tab['type_permis']) ? trim($tab['type_permis']) : null,
                ":idmoniteur" => $tab['idmoniteur']
            ));

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /* --- VEHICULES --- */
    public function insert_vehicule($tab) {
        $req = "INSERT INTO vehicule VALUES (null, :marque, :modele, :immatriculation, :image, :etat)";
        $insert = $this->pdo->prepare($req);
        $insert->execute(array(
            ":marque" => trim($tab['marque']),
            ":modele" => trim($tab['modele']),
            ":immatriculation" => trim($tab['immatriculation']),
            ":image" => $tab['image'] ?? 'default-car.jpg',
            ":etat" => trim($tab['etat'])
        ));
    }

    public function selectAll_vehicules() {
        $req = "SELECT * FROM vehicule ORDER BY marque ASC";
        $select = $this->pdo->prepare($req);
        $select->execute();
        return $select->fetchAll();
    }

    public function delete_vehicule($idvehicule) {
        $req = "DELETE FROM vehicule WHERE idvehicule = :idvehicule";
        $delete = $this->pdo->prepare($req);
        $delete->execute(array(":idvehicule" => $idvehicule));
    }

    public function selectWhere_vehicule($idvehicule) {
        $req = "SELECT * FROM vehicule WHERE idvehicule = :idvehicule";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":idvehicule" => $idvehicule));
        return $select->fetch();
    }

    public function update_vehicule($tab) {
        $req = "UPDATE vehicule SET marque=:marque, modele=:modele, immatriculation=:immatriculation, image=:image, etat=:etat WHERE idvehicule=:idvehicule";
        $update = $this->pdo->prepare($req);
        $update->execute(array(
            ":marque" => trim($tab['marque']),
            ":modele" => trim($tab['modele']),
            ":immatriculation" => trim($tab['immatriculation']),
            ":image" => $tab['image'] ?? 'default-car.jpg',
            ":etat" => trim($tab['etat']),
            ":idvehicule" => $tab['idvehicule']
        ));
    }

    /* --- COURS --- */
    private function verifierConflitHoraire($date, $hd, $hf, $idmon, $idveh, $idcand, $idcoursExclu = null) {
        if (strtotime($hd) >= strtotime($hf)) {
            throw new RuntimeException("L'heure de fin doit être postérieure à l'heure de début.");
        }
        $req = "SELECT c.idcours,
                       CONCAT(cu.nom, ' ', cu.prenom) AS nom_candidat,
                       CONCAT(mu.nom, ' ', mu.prenom) AS nom_moniteur,
                       v.immatriculation,
                       c.heure_debut, c.heure_fin,
                       (c.idmoniteur = :idmon) AS conflit_mon,
                       (c.idvehicule = :idveh) AS conflit_veh,
                       (c.idcandidat = :idcand) AS conflit_cand
                FROM cours c
                INNER JOIN candidats cand ON c.idcandidat = cand.idcandidat
                INNER JOIN utilisateur cu ON cand.idutilisateur = cu.idutilisateur
                INNER JOIN moniteur m ON c.idmoniteur = m.idmoniteur
                INNER JOIN utilisateur mu ON m.idutilisateur = mu.idutilisateur
                INNER JOIN vehicule v ON c.idvehicule = v.idvehicule
                WHERE c.date_cours = :date_cours
                  AND c.statut = 'À venir'
                  AND (c.idmoniteur = :idmon OR c.idvehicule = :idveh OR c.idcandidat = :idcand)
                  AND c.heure_debut < :hf
                  AND c.heure_fin   > :hd";
        $params = [
            ":date_cours" => $date,
            ":hd" => $hd, ":hf" => $hf,
            ":idmon" => $idmon, ":idveh" => $idveh, ":idcand" => $idcand
        ];
        if ($idcoursExclu !== null) {
            $req .= " AND c.idcours <> :idcoursExclu";
            $params[":idcoursExclu"] = $idcoursExclu;
        }
        $stmt = $this->pdo->prepare($req);
        $stmt->execute($params);
        $conflit = $stmt->fetch();
        if ($conflit) {
            $cibles = [];
            if ($conflit['conflit_mon'])  $cibles[] = "le moniteur " . $conflit['nom_moniteur'];
            if ($conflit['conflit_veh'])  $cibles[] = "le véhicule " . $conflit['immatriculation'];
            if ($conflit['conflit_cand']) $cibles[] = "le candidat " . $conflit['nom_candidat'];
            $h = substr($conflit['heure_debut'], 0, 5) . '-' . substr($conflit['heure_fin'], 0, 5);
            throw new RuntimeException("Conflit de planning : " . implode(', ', $cibles) . " déjà occupé(s) sur le créneau $h.");
        }
    }

    public function insert_cours($tab) {
        // RG : on ne peut pas planifier un cours avec un véhicule en réparation / indisponible
        if (!$this->vehiculeEstDisponible($tab['idvehicule'])) {
            throw new RuntimeException("Ce véhicule n'est pas disponible (en réparation ou hors service).");
        }
        $this->verifierConflitHoraire(
            $tab['date_cours'], $tab['heure_debut'], $tab['heure_fin'],
            $tab['idmoniteur'], $tab['idvehicule'], $tab['idcandidat']
        );
        $req = "INSERT INTO cours VALUES (null, :date_cours, :heure_debut, :heure_fin, 'À venir', :idvehicule, :idmoniteur, :idcandidat)";
        $insert = $this->pdo->prepare($req);
        $insert->execute(array(
            ":date_cours" => $tab['date_cours'],
            ":heure_debut" => $tab['heure_debut'],
            ":heure_fin" => $tab['heure_fin'],
            ":idcandidat" => $tab['idcandidat'],
            ":idmoniteur" => $tab['idmoniteur'],
            ":idvehicule" => $tab['idvehicule']
        ));
    }

    public function selectAll_cours() {
        $req = "SELECT c.*,
                   cu.nom as nom_candidat, cu.prenom as prenom_candidat,
                   mu.nom as nom_moniteur, mu.prenom as prenom_moniteur,
                   v.modele as modele_vehicule, v.immatriculation
                FROM cours c
                INNER JOIN candidats cand ON c.idcandidat = cand.idcandidat
                INNER JOIN utilisateur cu ON cand.idutilisateur = cu.idutilisateur
                INNER JOIN moniteur m ON c.idmoniteur = m.idmoniteur
                INNER JOIN utilisateur mu ON m.idutilisateur = mu.idutilisateur
                INNER JOIN vehicule v ON c.idvehicule = v.idvehicule
                ORDER BY c.date_cours DESC, c.heure_debut DESC";
        $select = $this->pdo->prepare($req);
        $select->execute();
        return $select->fetchAll();
    }

    public function selectWhere_cours($idcours) {
        $req = "SELECT * FROM cours WHERE idcours = :idcours";
        $select = $this->pdo->prepare($req);
        $select->execute(array(":idcours" => $idcours));
        return $select->fetch();
    }

    public function update_cours($tab) {
        if (($tab['statut'] ?? '') === 'À venir') {
            // RG : véhicule doit être Disponible si le cours reste planifié
            if (!$this->vehiculeEstDisponible($tab['idvehicule'])) {
                throw new RuntimeException("Ce véhicule n'est pas disponible (en réparation ou hors service).");
            }
            $this->verifierConflitHoraire(
                $tab['date_cours'], $tab['heure_debut'], $tab['heure_fin'],
                $tab['idmoniteur'], $tab['idvehicule'], $tab['idcandidat'],
                $tab['idcours']
            );
        }
        $req = "UPDATE cours SET date_cours=:date_cours, heure_debut=:heure_debut, heure_fin=:heure_fin, statut=:statut, idcandidat=:idcandidat, idmoniteur=:idmoniteur, idvehicule=:idvehicule WHERE idcours=:idcours";
        $update = $this->pdo->prepare($req);
        $update->execute(array(
            ":date_cours" => $tab['date_cours'],
            ":heure_debut" => $tab['heure_debut'],
            ":heure_fin" => $tab['heure_fin'],
            ":statut" => $tab['statut'],
            ":idcandidat" => $tab['idcandidat'],
            ":idmoniteur" => $tab['idmoniteur'],
            ":idvehicule" => $tab['idvehicule'],
            ":idcours" => $tab['idcours']
        ));
    }

    public function delete_cours($idcours) {
        $req = "DELETE FROM cours WHERE idcours = :idcours";
        $delete = $this->pdo->prepare($req);
        $delete->execute(array(":idcours" => $idcours));
    }

    /** Le moniteur change le statut d'un de SES cours (Effectué ou Annulé).
     *  Sécurité : on vérifie que le cours appartient bien au moniteur connecté. */
    public function update_statut_cours_moniteur($idcours, $idmoniteur, $statut) {
        // Whitelist des statuts autorisés pour le moniteur
        if (!in_array($statut, ['Effectué', 'Annulé'], true)) {
            throw new RuntimeException("Statut non autorisé.");
        }
        $req = "UPDATE cours SET statut = :statut
                WHERE idcours = :idcours AND idmoniteur = :idmoniteur";
        $upd = $this->pdo->prepare($req);
        $upd->execute([
            ":statut" => $statut,
            ":idcours" => $idcours,
            ":idmoniteur" => $idmoniteur
        ]);
        if ($upd->rowCount() === 0) {
            throw new RuntimeException("Ce cours ne vous appartient pas ou n'existe pas.");
        }
    }

    /** Liste les candidats QUI ONT (ou ont eu) au moins un cours avec ce moniteur. */
    public function selectCandidats_byMoniteur($idmoniteur) {
        $req = "SELECT DISTINCT c.idcandidat, u.nom, u.prenom, u.email, u.tel,
                       COUNT(co.idcours) AS nb_cours,
                       SUM(CASE WHEN co.statut = 'Effectué' THEN 1 ELSE 0 END) AS nb_effectues,
                       SUM(CASE WHEN co.statut = 'À venir'  THEN 1 ELSE 0 END) AS nb_a_venir
                FROM candidats c
                INNER JOIN utilisateur u ON c.idutilisateur = u.idutilisateur
                INNER JOIN cours co       ON co.idcandidat   = c.idcandidat
                WHERE co.idmoniteur = :idmoniteur
                GROUP BY c.idcandidat, u.nom, u.prenom, u.email, u.tel
                ORDER BY u.nom ASC";
        $s = $this->pdo->prepare($req);
        $s->execute([":idmoniteur" => $idmoniteur]);
        return $s->fetchAll();
    }

    /** Liste des véhicules avec leur état (utilisé par le moniteur en lecture seule). */
    public function selectAll_vehicules_avec_etat() {
        $req = "SELECT * FROM vehicule ORDER BY etat ASC, marque ASC";
        $s = $this->pdo->prepare($req);
        $s->execute();
        return $s->fetchAll();
    }

    /** Vérifie qu'un véhicule est Disponible (utilisé avant insert_cours). */
    public function vehiculeEstDisponible($idvehicule) {
        $req = "SELECT etat FROM vehicule WHERE idvehicule = :idvehicule";
        $s = $this->pdo->prepare($req);
        $s->execute([":idvehicule" => $idvehicule]);
        $v = $s->fetch();
        return $v && $v['etat'] === 'Disponible';
    }
}
?>

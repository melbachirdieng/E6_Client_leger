-- =====================================================
-- auto_ecole.sql — Structure avec héritage utilisateur
-- Table mère : utilisateur
-- Tables filles : candidats, moniteur
-- =====================================================

DROP DATABASE IF EXISTS auto_ecole;
CREATE DATABASE auto_ecole CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE auto_ecole;

SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- TABLE MÈRE : utilisateur
-- =====================================================

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE `utilisateur` (
  `idutilisateur` int NOT NULL AUTO_INCREMENT,
  `nom`           varchar(50)  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom`        varchar(50)  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email`         varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp`           varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel`           varchar(25)  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse`       varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role`          enum('admin','candidat','moniteur') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'candidat',
  `premier_connexion` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idutilisateur`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mapping des IDs :
-- 1  = admin Lejars
-- 2  = moniteur Benahmed  (idmoniteur=1)
-- 3  = moniteur Dupont    (idmoniteur=2)
-- 4  = moniteur Dubois    (idmoniteur=3)
-- 5  = moniteur Martin    (idmoniteur=4)
-- 6  = candidat goat      (idcandidat=1)
-- 7  = candidat legoat    (idcandidat=2)  ← email corrigé (doublon avec moniteur)
-- 8  = candidat Maria     (idcandidat=3)
-- 9  = candidat Haroun    (idcandidat=4)
-- 10 = candidat Youma     (idcandidat=5)
-- 11 = candidat Rayna     (idcandidat=6)
-- 12 = candidat lagoat    (idcandidat=7)
-- 13 = candidat 1234      (idcandidat=8)
-- 14 = candidat bsb       (idcandidat=9)
-- 15 = candidat legoat2   (idcandidat=10)

INSERT INTO `utilisateur` (`idutilisateur`, `nom`, `prenom`, `email`, `mdp`, `tel`, `adresse`, `role`, `premier_connexion`) VALUES
-- Admin
(1,  'Lejars',    'Murielle', 'admin@castellane.fr',    '123', NULL,         NULL,           'admin',    0),
-- Moniteurs
(2,  'Benahmed',  'Okacha',   'benahmed@castellane.fr', '123', '78967567',   'paris',        'moniteur', 0),
(3,  'Dupont',    'Jean',     'dupont@castellane.fr',   '123', '65456542',   'paris',        'moniteur', 0),
(4,  'Dubois',    'Marie',    'dubois@castellane.fr',   '123', '6789765678', 'paris',        'moniteur', 0),
(5,  'Martin',    'Sophie',   'martin@castellane.fr',   '123', '6789678',    'paris',        'moniteur', 0),
-- Candidats
(6,  'leplusbo',  'bachirGoat', 'goat@gmail.com',       '123', '23455644',   'paris',        'candidat', 0),
(7,  'legoat',    'legoat',   'legoat.cand@gmail.com',  '123', '345676543',  'paris la france', 'candidat', 0),
(8,  'Benadjila', 'Maria',    'maria@gmail.com',        '123', '5654567',    'paris',        'candidat', 1),
(9,  'Haroun',    'Djihane',  'haroun@gmail.com',       '123', '78086789',   'paris',        'candidat', 1),
(10, 'Drame',     'Youma',    'drame@gmail.com',        '123', '6789778',    'paris',        'candidat', 1),
(11, 'Aboghe',    'Rayna',    'aboghe@gmail.com',       '123', '567345678',  'paris',        'candidat', 1),
(12, 'lagoat',    'lagoat',   'lagoat@gmail.com',       '123', '753464374',  'paris la france', 'candidat', 1),
(13, 'bsb',       'bsb',      'bsb@gmail.com',          '123', '1234567891', 'paris',        'candidat', 1),
(14, 'legoat2',   'legoat2',  'legoat2.cand@gmail.com', '123', '345676543',  'paris la france', 'candidat', 1);

-- =====================================================
-- TABLE FILLE : candidats
-- =====================================================

DROP TABLE IF EXISTS `candidats`;
CREATE TABLE `candidats` (
  `idcandidat`        int NOT NULL AUTO_INCREMENT,
  `idutilisateur`     int NOT NULL,
  `est_etudiant`      tinyint(1) DEFAULT 0,
  `nom_ecole`         varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_prevue_code`  date DEFAULT NULL,
  `date_prevue_permis` date DEFAULT NULL,
  PRIMARY KEY (`idcandidat`),
  KEY `fk_cand_util` (`idutilisateur`),
  CONSTRAINT `fk_cand_util` FOREIGN KEY (`idutilisateur`) REFERENCES `utilisateur` (`idutilisateur`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- idcandidat originaux conservés pour compatibilité FK dans cours
INSERT INTO `candidats` (`idcandidat`, `idutilisateur`, `est_etudiant`, `nom_ecole`, `date_prevue_code`, `date_prevue_permis`) VALUES
(1,  6,  1, 'iris', '2026-02-27', '2026-03-20'),
(2,  7,  1, '',     NULL,         NULL),
(3,  8,  1, 'iris', NULL,         NULL),
(4,  9,  1, 'iris', NULL,         NULL),
(5,  10, 1, 'iris', NULL,         NULL),
(6,  11, 1, 'iris', NULL,         NULL),
(7,  12, 1, '',     NULL,         NULL),
(8,  13, 1, '',     NULL,         NULL),
(9,  14, 1, '',     NULL,         NULL);

-- =====================================================
-- TABLE FILLE : moniteur
-- =====================================================

DROP TABLE IF EXISTS `moniteur`;
CREATE TABLE `moniteur` (
  `idmoniteur`    int NOT NULL AUTO_INCREMENT,
  `idutilisateur` int NOT NULL,
  `experience`    int DEFAULT NULL,
  `type_permis`   varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idmoniteur`),
  KEY `fk_mon_util` (`idutilisateur`),
  CONSTRAINT `fk_mon_util` FOREIGN KEY (`idutilisateur`) REFERENCES `utilisateur` (`idutilisateur`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- idmoniteur originaux conservés pour compatibilité FK dans cours
INSERT INTO `moniteur` (`idmoniteur`, `idutilisateur`, `experience`, `type_permis`) VALUES
(1, 2, 10, 'B'),
(2, 3, 4,  'B+A'),
(3, 4, 7,  'B'),
(4, 5, 8,  'A');

-- =====================================================
-- TABLE : vehicule
-- =====================================================

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE `vehicule` (
  `idvehicule`    int NOT NULL AUTO_INCREMENT,
  `marque`        varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modele`        varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `immatriculation` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image`         varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat`          varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT 'Disponible',
  PRIMARY KEY (`idvehicule`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `vehicule` (`idvehicule`, `marque`, `modele`, `immatriculation`, `image`, `etat`) VALUES
(1,  'Seat',       'leon',     'CC-456-DK', 'veh_698d497022e9b9.80690019.jpg',  'Disponible'),
(2,  'Seat',       'ibiza',    'PC-786-EF', 'veh_698d497c645732.88364249.jpg',  'Disponible'),
(3,  'Peugeot',    '208',      'CC-456-DD', 'veh_698d49acc48336.04340770.jpg',  'En réparation'),
(4,  'Renault',    'megane',   'CC-456-YU', 'veh_698d49ce2dc391.97557048.jpg',  'Disponible'),
(5,  'Nissan',     'Micra',    'AD-489-DL', 'veh_698d49eb32aaa9.50188729.jpg',  'Disponible'),
(6,  'Citroen',    'C3',       'VB-695-FU', 'veh_698d4a0f3a22c8.85627882.jpg',  'Disponible'),
(7,  'BMW',        'serie 1',  'PC-490-JI', 'veh_698d4aaaed5843.55517181.jpg',  'Disponible'),
(8,  'Dacia',      'Duster',   'EC-332-OL', 'veh_698d4ad93e1bb6.92559462.jpg',  'Disponible'),
(9,  'Audi',       'TT',       'LK-790-YT', 'veh_698d4afbcc6775.02741508.jpg',  'Indisponible'),
(10, 'Volkswagen', 'golf',     'NH-480-HH', 'veh_698d4b1ca104b3.17771375.jpg',  'Disponible'),
(11, 'Chevrolet',  'onix',     'UC-461-JH', 'veh_698d4b576c9568.45850727.jpg',  'Disponible'),
(12, 'Volkswagen', 'polo',     'MC-990-TI', 'veh_698d4b7f0608e9.37366082.jpg',  'Disponible'),
(13, 'Kia',        'sportage', 'LK-390-FD', 'veh_698d4bb17bffd6.93315154.jpg',  'Disponible'),
(14, 'Renault',    'clio',     'AC-460-VG', 'veh_698d4bf883e162.10162.jpg',     'Disponible'),
(15, 'Dacia',      'sandero',  'PP-790-EZ', 'veh_698d4c2f015b71.05371.jpg',     'Disponible'),
(16, 'Audi',       'S3',       'MU-466-DI', 'veh_698d4d241b6eb7.27327254.jpg',  'Disponible');

-- =====================================================
-- TABLE : cours
-- =====================================================

DROP TABLE IF EXISTS `cours`;
CREATE TABLE `cours` (
  `idcours`    int NOT NULL AUTO_INCREMENT,
  `date_cours` date DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin`  time DEFAULT NULL,
  `statut`     varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'À venir',
  `idvehicule` int NOT NULL,
  `idmoniteur` int NOT NULL,
  `idcandidat` int NOT NULL,
  PRIMARY KEY (`idcours`),
  KEY `fk_cours_veh` (`idvehicule`),
  KEY `fk_cours_mon` (`idmoniteur`),
  KEY `fk_cours_cand` (`idcandidat`),
  CONSTRAINT `fk_cours_veh`  FOREIGN KEY (`idvehicule`) REFERENCES `vehicule`   (`idvehicule`) ON DELETE CASCADE,
  CONSTRAINT `fk_cours_mon`  FOREIGN KEY (`idmoniteur`) REFERENCES `moniteur`   (`idmoniteur`) ON DELETE CASCADE,
  CONSTRAINT `fk_cours_cand` FOREIGN KEY (`idcandidat`) REFERENCES `candidats`  (`idcandidat`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cours` (`idcours`, `date_cours`, `heure_debut`, `heure_fin`, `statut`, `idvehicule`, `idmoniteur`, `idcandidat`) VALUES
(1,  '2026-02-13', '07:50:00', '08:50:00', 'À venir',  7,  4, 3),
(2,  '2026-02-11', '09:00:00', '10:00:00', 'Effectué', 7,  4, 3),
(3,  '2026-02-15', '11:00:00', '12:00:00', 'À venir',  12, 1, 2),
(4,  '2026-02-10', '13:00:00', '14:00:00', 'Effectué', 16, 1, 2),
(5,  '2026-02-26', '11:00:00', '12:00:00', 'À venir',  2,  3, 1),
(6,  '2026-02-03', '17:00:00', '18:00:00', 'Effectué', 14, 3, 1),
(7,  '2026-02-19', '10:50:00', '11:50:00', 'À venir',  10, 2, 4),
(8,  '2026-02-04', '12:00:00', '13:00:00', 'Effectué', 12, 2, 4),
(9,  '2026-02-05', '14:30:00', '15:30:00', 'Effectué', 13, 3, 5),
(10, '2026-02-28', '08:55:00', '09:55:00', 'À venir',  2,  2, 5),
(11, '2026-03-05', '09:45:00', '10:45:00', 'À venir',  2,  3, 2),
(12, '2026-03-25', '12:00:00', '13:30:00', 'À venir',  14, 4, 2),
(13, '2026-02-08', '08:00:00', '09:00:00', 'Effectué', 2,  2, 6),
(14, '2026-02-28', '10:00:00', '11:00:00', 'À venir',  4,  2, 6),
(15, '2026-03-20', '15:00:00', '16:00:00', 'À venir',  16, 4, 1),
(16, '2026-02-20', '17:45:00', '18:45:00', 'À venir',  2,  1, 3);

SET FOREIGN_KEY_CHECKS = 1;
 Insertion des données dans la table FOOD
INSERT INTO FOOD (foo_name, foo_proteines, foo_lipides, foo_glucides, foo_calories, foo_weight) VALUES
('Poulet grillé', 31.0, 3.6, 0.0, 165, 100.0),
('Riz blanc', 2.7, 0.3, 28.0, 130, 100.0),
('Brocoli', 2.8, 0.4, 7.2, 55, 100.0),
('Saumon', 25.0, 13.0, 0.0, 206, 100.0),
('Pomme', 0.3, 0.2, 14.0, 52, 100.0);

-- Insertion des données dans la table NAMEMEAL
INSERT INTO NAMEMEAL (nam_label, nam_description) VALUES
('Petit-déjeuner', 'Repas du matin'),
('Déjeuner', 'Repas de midi'),
('Dîner', 'Repas du soir'),
('Collation', 'Petit en-cas');

-- Insertion des données dans la table OBJECTIF
INSERT INTO OBJECTIF (obj_label, obj_state) VALUES
('Perte de poids', TRUE),
('Maintien', TRUE),
('Prise de masse', FALSE);

-- Insertion des données dans la table ROLE
INSERT INTO ROLE (rol_label) VALUES
('Utilisateur'),
('Administrateur');

-- Insertion des données dans la table USER
INSERT INTO USER (use_firstname, use_lastname, use_email, use_birthday, use_town, use_sexe, rol_id) VALUES
('Jean', 'Dupont', 'jean.dupont@email.com', '1990-05-15', 'Paris', TRUE, 1),
('Marie', 'Martin', 'marie.martin@email.com', '1988-09-22', 'Lyon', FALSE, 1),
('Admin', 'Système', 'admin@systeme.com', '1985-01-01', 'Marseille', TRUE, 2);

-- Insertion des données dans la table HEALTHDATA
INSERT INTO HEALTHDATA (hea_actualWeight, hea_height, hea_weightObjectif, hea_workoutObjectifPerWeek, use_id) VALUES
(80.0, 175.0, 75.0, 3, 1),
(65.0, 165.0, 65.0, 2, 2);

-- Insertion des données dans la table MEAL
INSERT INTO MEAL (mea_totalCalories, mea_totalProteines, mea_totalGlucides, mea_totalLipides, use_id) VALUES
(500.0, 30.0, 60.0, 20.0, 1),
(600.0, 40.0, 70.0, 25.0, 2);

-- Insertion des données dans la table TRAINING
INSERT INTO TRAINING (tra_date) VALUES
(CURDATE()),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY));

-- Insertion des données dans la table EXERCICE
INSERT INTO EXERCICE (exe_label, exe_weight, exe_nbSerie, exe_nbRepetition) VALUES
('Squat', 50, 3, 12),
('Bench Press', 70, 4, 10);

-- Insertion des données dans la table addOn
INSERT INTO addOn (foo_id,use_id) VALUES
(1 ,1),
(2 ,2);

-- Insertion des données dans la table composing
INSERT INTO composing (mea_id ,foo_id) VALUES 
(1 ,1),
(2 ,2);

-- Insertion des données dans la table name
INSERT INTO name (nam_id ,mea_id) VALUES 
(1 ,1),
(2 ,2);

-- Insertion des données dans la table constitute
INSERT INTO constitute (tra_id ,use_id) VALUES 
(1 ,1),
(2 ,2);
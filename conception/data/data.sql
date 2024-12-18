-- Filière : 
INSERT INTO filiere(id, description) VALUES ('FIL1','Informatique');

-- Niveau 
INSERT INTO niveau(id, nom) VALUES ('L1','Licence 1'), 
('L2','Licence 2'), 
('L3','Licence 3'), 
('M1','Master 1'), 
('M2','Master 2');

INSERT INTO session values ('SES1','2023-09-10'), ('SES2','2024-02-10');

INSERT INTO session_semestre(idSession, idSemestre) values ('SES1','S1'), ('SES2','S2'); 

-- Semestre 
INSERT INTO semestre(id,description, idNiveau) VALUES('S1', 'Semestre 1', 'L1'),
('S2', 'Semestre 2', 'L1');

-- Insertion de données dans la table matieres avec IDs basés sur les codes des matières

-- Insertion des matières pour le semestre 1 (S1)
INSERT INTO matieres (id, nom, credit, idSemestre, idFiliere)
VALUES
    ('INF101', 'Programmation procédurale', 7, 'S1', 'FIL1'),
    ('INF104', 'HTML et Introduction au Web', 5, 'S1', 'FIL1'),
    ('INF107', 'Informatique de Base', 4, 'S1', 'FIL1'),
    ('MTH101', 'Arithmétique et nombres', 4, 'S1', 'FIL1'),
    ('MTH102', 'Analyse mathématique', 6, 'S1', 'FIL1'),
    ('ORG101', 'Techniques de communication', 4, 'S1', 'FIL1'),
    ('INF102', 'Bases de données relationnelles', 5, 'S2', 'FIL1'),
    ('INF103', 'Bases de l administration système', 5, 'S2', 'FIL1'),
    ('INF105', 'Maintenance matériel et logiciel', 4, 'S2', 'FIL1'),
    ('INF106', 'Compléments de programmation', 6, 'S2', 'FIL1'),
    ('MTH103', 'Calcul Vectoriel et Matriciel', 6, 'S2', 'FIL1'),
    ('MTH105', 'Probabilité et Statistique', 4, 'S2', 'FIL1');


insert into examen

-- -- Insertion de données de test dans la table etudiant
-- INSERT INTO etudiant (id, nom, prenom, dateNaissance) 
-- VALUES ('ETU0001','Durand', 'Emma', '2000-05-15'),
-- ('ETU0002','Martin', 'Lucas', '1999-08-20'),
-- ('ETU0003','Lefevre', 'Chloe', '2001-12-03'),
-- ('ETU0004','Petit', 'Louis', '1998-03-11'),
-- ('ETU0005','Morel', 'Sophie', '2002-07-19'),
-- ('ETU0006','Roux', 'Maxime', '1997-09-29'),
-- ('ETU0007','Fournier', 'Camille', '2000-11-25'),
-- ('ETU0008','Girard', 'Thomas', '1999-02-14'),
-- ('ETU0009','Andre', 'Julie', '2001-06-30'),
-- ('ETU0010','Lambert', 'Arthur', '1998-04-09');



-- -- Inscription
-- -- Insertion des données dans la table inscription
-- INSERT INTO inscription (id, dateInscription, idEtudiant, idSemestre)
-- VALUES 
-- ('INSCR0001','2023-01-15', 'ETU0001', 'S1'),
-- ('INSCR0002','2023-01-15', 'ETU0002', 'S1'),
-- ('INSCR0003','2024-03-15', 'ETU0001', 'S2'),
-- ('INSCR0004','2024-03-15', 'ETU0002', 'S2'),
-- ('INSCR0005','2024-03-15', 'ETU0009', 'S2'),
-- ('INSCR0006','2023-10-15', 'ETU0003', 'S3'),
-- ('INSCR0007','2023-10-15', 'ETU0004', 'S3'),
-- ('INSCR0008','2023-10-15', 'ETU0005', 'S3'),
-- ('INSCR0009','2024-03-15', 'ETU0003', 'S4'),
-- ('INSCR0010','2024-03-15', 'ETU0004', 'S4'),
-- ('INSCR0011','2024-03-15', 'ETU0005', 'S2');


-- -- Insertion des données dans la table notes
-- INSERT INTO notes (valeur, idInscription, idMatiere)
-- VALUES 
-- (12.5, 'INSCR0001', 'INF101'), -- Emma
-- (14.0, 'INSCR0001', 'INF104'),
-- (10.0, 'INSCR0002', 'INF101'), -- Lucas
-- (15.5, 'INSCR0002', 'INF107'),
-- (16.0, 'INSCR0003', 'INF107'), -- Emma
-- (13.5, 'INSCR0003', 'MTH103'),
-- (NULL, 'INSCR0004', 'INF107'), -- Lucas (absent pour INF107)
-- (11.0, 'INSCR0004', 'MTH103'), 
-- (14.5, 'INSCR0005', 'MTH105'), -- Julie
-- (15.0, 'INSCR0006', 'MTH101'), -- Chloe
-- (12.0, 'INSCR0007', 'MTH101'), -- Louis
-- (17.5, 'INSCR0008', 'ORG101'), -- Sophie
-- (13.0, 'INSCR0009', 'INF102'), -- Chloe
-- (14.0, 'INSCR0009', 'INF103'),
-- (NULL, 'INSCR0010', 'INF105'), -- Louis (absent pour INF105)
-- (16.0, 'INSCR0011', 'INF106'); -- Sophie

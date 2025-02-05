
-- Données de test de trigger  : INSERTION

 INSERT INTO Utilisateur(mail, mdp, nom, prenom, date_naissance, idGenre, salt) 
 values ('test@gmail.com', '1234', 'Test', 'Test', '2000-12-12', 'GR01',''), 
        ('jean@gmail.com', '1234', 'Jean', 'Jean', '2001-05-12', 'GR02','');


-- Données de test de trigger : UPDATE 

UPDATE Utilisateur set salt = 'salt' where id = 'USR000000018';



-- Suppression : 

DELETE FROM Utilisateur where id = 'USR000000019';

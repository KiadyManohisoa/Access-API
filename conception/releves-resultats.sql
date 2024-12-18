CREATE TABLE niveau(
   id VARCHAR(50)   DEFAULT CONCAT('NIV', LPAD(nextval('seq_niveau')::TEXT, 4, '0')),
   nom VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE filiere(
   id VARCHAR(50)  DEFAULT CONCAT('FIL', LPAD(nextval('seq_filiere')::TEXT, 4, '0')),
   description VARCHAR(50)  default '',
   PRIMARY KEY(id)
);

CREATE TABLE semestre(
   id VARCHAR(50)   DEFAULT CONCAT('SMT', LPAD(nextval('seq_semestre')::TEXT, 4, '0')),
   description VARCHAR(50)  NOT NULL,
   idNiveau VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idNiveau) REFERENCES niveau(id)
);


CREATE TABLE matieres(
   id VARCHAR(50)   DEFAULT CONCAT('MTR', LPAD(nextval('seq_matieres')::TEXT, 4, '0')),
   nom VARCHAR(50)  NOT NULL,
   credit INTEGER check (credit > 0),
   idSemestre VARCHAR(50)  NOT NULL,
   idFiliere  VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idSemestre) REFERENCES semestre(id),
   FOREIGN KEY(idFiliere) REFERENCES filiere(id)
);


CREATE TABLE etudiant(
   id VARCHAR(50) DEFAULT CONCAT('ETU', LPAD(nextval('seq_examen')::TEXT, 9, '0')),
   nom VARCHAR(50)  NOT NULL default '',
   prenom VARCHAR(50)  default '',
   dateNaissance VARCHAR(50)  NOT NULL,
   idFiliere VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idFiliere) REFERENCES filiere(id)
);

CREATE TABLE session (
   id VARCHAR(50) DEFAULT CONCAT('SES', LPAD(nextval('seq_session')::TEXT, 4, '0')),
   dateInscription date default current_date ,
   PRIMARY KEY(id)
);

CREATE TABLE session_semestre(
   id VARCHAR(50) DEFAULT CONCAT('SSM', LPAD(nextval('seq_sessionsemestre')::TEXT, 4, '0')),
   idSession VARCHAR(50) NOT Null,
   idSemestre VARCHAR(50) NOT Null,
   PRIMARY KEY(id),
   FOREIGN KEY(idSession) REFERENCES session(id),
   FOREIGN KEY(idSemestre) REFERENCES semestre(id)
);

CREATE TABLE inscription(
   id VARCHAR(50) DEFAULT CONCAT('INSCR', LPAD(nextval('seq_inscription')::TEXT, 9, '0')),
   idEtudiant VARCHAR(50)  NOT NULL,
   idSessionSemestre VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idEtudiant) REFERENCES etudiant(id),
   FOREIGN KEY(idSessionSemestre) REFERENCES session_semestre(id)
);

CREATE TABLE examen(
   id VARCHAR(50) ,
   dateExamen DATE default current_date,
   idMatiere VARCHAR(50)  NOT NULL,
   idSession VARCHAR(50),
   PRIMARY KEY(id),
   FOREIGN KEY(idMatiere) REFERENCES matieres(id),
   FOREIGN KEY(idSession) REFERENCES session(id)
);

CREATE TABLE notes(
   id VARCHAR(50)   DEFAULT CONCAT('NT', LPAD(nextval('seq_notes')::TEXT, 9, '0')),
   valeur NUMERIC(5,2)   default 0,
   idInscription VARCHAR(50)  NOT NULL,
   idExamen VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idInscription) REFERENCES inscription(id),
   FOREIGN KEY(idExamen) REFERENCES examen(id)
);


ALTER TABLE examen
ALTER COLUMN id SET DEFAULT CONCAT('EXM', LPAD(nextval('seq_examen')::TEXT, 4, '0'));

-- ALTER TABLE notes
-- ALTER COLUMN id SET DEFAULT CONCAT('NT', LPAD(nextval('seq_examen')::TEXT, 9, '0'));

-- ALTER TABLE etudiant
-- ALTER COLUMN id SET DEFAULT CONCAT('ETU', LPAD(nextval('seq_examen')::TEXT, 9, '0'));

-- ALTER TABLE inscription
-- ALTER COLUMN id SET DEFAULT CONCAT('INSCR', LPAD(nextval('seq_inscription')::TEXT, 9, '0'));


INSERT INTO examen(dateExamen, )
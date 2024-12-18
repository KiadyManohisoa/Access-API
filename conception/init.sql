create database relevesNotes ;

\c relevesnotes 

-- Création des séquences pour les tables
CREATE SEQUENCE seq_etudiant START 1;
CREATE SEQUENCE seq_examen START 1;
CREATE SEQUENCE seq_filiere START 1;
CREATE SEQUENCE seq_niveau START 1;
CREATE SEQUENCE seq_semestre START 1;
CREATE SEQUENCE seq_matieres START 1;
CREATE SEQUENCE seq_inscription START 1;
CREATE SEQUENCE seq_notes START 1;
CREATE SEQUENCE seq_session START 1;
CREATE SEQUENCE seq_sessionsemestre START 1;
-- Notes - Inscription   

create or replace view v_notes_matieres as select n.*, idMatiere from notes n join examen e on e.id = idExamen join matieres m on m.id = idMatiere;

create or replace view v_etudiant_filiere as select e.*, description as nomFiliere from etudiant e join filiere f on f.id = idFiliere ;


create or replace view v_notes_inscription as select n.*, idEtudiant, idSessionSemestre from v_notes_matieres n join inscription i on idInscription = i.id ;

create or replace view v_notes_inscription_sessionSemetre as select v.*, idSemestre, idSession from v_notes_inscription v join session_semestre ss on idSessionSemestre = ss.id ;


create or replace view v_notes_inscription_sessionSemetre_details as select v.*, e.nom, prenom, nomFiliere, s.description as nomSemestre, idNiveau ,dateInscription, m.nom as nomMatiere  from v_notes_inscription_sessionSemetre v join v_etudiant_filiere e on idEtudiant = e.id join semestre s on s.id = idSemestre join session ss on ss.id = idSession join matieres m on idMatiere  = m.id ;


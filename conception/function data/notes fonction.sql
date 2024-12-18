CREATE OR REPLACE PROCEDURE generer_notes(noteMin NUMERIC(5,2), noteMax NUMERIC(5,2))
AS $$
DECLARE
    id_inscription VARCHAR(50);
    id_examen VARCHAR(50);
    session_id VARCHAR(50); -- Variable pour stocker l'idSession
    random_note NUMERIC(5,2);
BEGIN
    -- Boucle pour chaque examen avec sa session associée
    FOR id_examen, session_id IN 
        (SELECT id, idsession FROM examen) LOOP
        -- Boucle pour chaque inscription liée à la session du semestre
        FOR id_inscription IN 
            (SELECT i.id 
             FROM inscription i 
             JOIN session_semestre ss ON i.idSessionSemestre = ss.id
             WHERE idSession = session_id) LOOP
            -- Générer une note aléatoire entre noteMin et noteMax
            random_note := noteMin + (noteMax - noteMin) * random();

            -- Insérer dans la table notes
            INSERT INTO notes (valeur, idInscription, idExamen)
            VALUES (random_note, id_inscription, id_examen);
        END LOOP;
    END LOOP;
END;
$$ LANGUAGE plpgsql;



-- Appel de la fonction 

call generer_notes(1,20)

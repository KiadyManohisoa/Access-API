CREATE OR REPLACE PROCEDURE generer_inscriptions()
LANGUAGE plpgsql AS $$
DECLARE
    etudiant_id VARCHAR(50);
    session_semestre_id VARCHAR(50);
BEGIN
    FOR session_semestre_id IN (SELECT id FROM session_semestre) LOOP
        FOR etudiant_id IN (SELECT id FROM etudiant) LOOP
            INSERT INTO inscription (idEtudiant, idSessionSemestre)
            VALUES (etudiant_id, session_semestre_id);
        END LOOP;
    END LOOP;
END;
$$;

-- Appel 

call generer_inscriptions();
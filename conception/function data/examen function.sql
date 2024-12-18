CREATE OR REPLACE PROCEDURE generer_examens(nombre_examens INT, date_debut DATE, date_fin DATE)
AS $$
DECLARE
    id_matiere VARCHAR(50);
    i INT;
    random_date DATE;
BEGIN
    -- Boucle sur chaque matière
    FOR id_matiere IN (SELECT id FROM matieres) LOOP
        -- Générer `nombre_examens` pour chaque matière
        FOR i IN 1..nombre_examens LOOP
            -- Génération d'une date aléatoire entre date_debut et date_fin
            random_date := date_debut + (random() * (date_fin - date_debut))::INT;
            
            -- Insertion dans la table examen
            INSERT INTO examen (id, dateExamen, idMatiere)
            VALUES (
                CONCAT('EXAM', LPAD(nextval('seq_examen')::TEXT, 9, '0')), -- Génération d'un ID unique
                random_date,
                id_matiere
            );
        END LOOP;
    END LOOP;
END;
$$ LANGUAGE plpgsql;


-- Appel de a fonction 

CALL generer_examens(1,'2023-09-10','2024-07-01');
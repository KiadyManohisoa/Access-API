CREATE OR REPLACE PROCEDURE generer_etudiants(datemin DATE, datemax DATE, nombre_lignes INT)
LANGUAGE plpgsql AS $$
DECLARE
    i INT;
    random_date DATE;
BEGIN
    FOR i IN 1..nombre_lignes LOOP
        random_date := datemin + (random() * (datemax - datemin))::INT;
        INSERT INTO etudiant (nom, prenom, dateNaissance, idFiliere)
        VALUES (
            'Nom ' || i,
            'Prenom ' || i,
            random_date::TEXT,
            (SELECT id FROM filiere ORDER BY random() LIMIT 1) -- Sélection aléatoire d'une filière existante
        );
    END LOOP;
END;
$$;


-- Appel de la fonction 

CALL generer_etudiants('2001-01-01', '2005-12-31',10);

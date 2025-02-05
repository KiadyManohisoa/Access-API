-- Création de la table historiqueUtilisateur

-- Création de la fonction de trigger
CREATE OR REPLACE FUNCTION insertionHistorique()
RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO historiqueUtilisateur (idUser, operation, dateExecution)
        VALUES (NEW.id, 'INSERT', NOW());
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO historiqueUtilisateur (idUser, operation, dateExecution)
        VALUES (NEW.id, 'UPDATE', NOW());
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO historiqueUtilisateur (idUser, operation, dateExecution)
        VALUES (OLD.id, 'DELETE', NOW());
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

-- Création du trigger sur la table utilisateur
CREATE TRIGGER ecouteurUtilisateur
AFTER INSERT OR UPDATE OR DELETE ON utilisateur
FOR EACH ROW EXECUTE FUNCTION insertionHistorique();

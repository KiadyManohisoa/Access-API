-- Suppression des vues : 

DO $$ 
DECLARE 
    r RECORD; 
BEGIN 
    FOR r IN (SELECT table_name FROM information_schema.views WHERE table_schema = 'public') 
    LOOP 
        EXECUTE 'DROP VIEW IF EXISTS public.' || r.table_name || ' CASCADE'; 
    END LOOP; 
END $$;


-- Suppression des tables : 

DO $$ 
DECLARE 
    r RECORD; 
BEGIN 
    FOR r IN (SELECT table_name FROM information_schema.tables WHERE table_schema = 'public') 
    LOOP 
        EXECUTE 'DROP TABLE IF EXISTS public.' || r.table_name || ' CASCADE'; 
    END LOOP; 
END $$;

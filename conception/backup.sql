--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: generer_etudiants(date, date, integer); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.generer_etudiants(IN datemin date, IN datemax date, IN nombre_lignes integer)
    LANGUAGE plpgsql
    AS $$
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
            (SELECT id FROM filiere ORDER BY random() LIMIT 1) -- S‚lection al‚atoire d'une filiŠre existante
        );
    END LOOP;
END;
$$;


ALTER PROCEDURE public.generer_etudiants(IN datemin date, IN datemax date, IN nombre_lignes integer) OWNER TO postgres;

--
-- Name: generer_examens(integer, date, date); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.generer_examens(IN nombre_examens integer, IN date_debut date, IN date_fin date)
    LANGUAGE plpgsql
    AS $$
DECLARE
    id_matiere VARCHAR(50);
    i INT;
    random_date DATE;
BEGIN
    -- Boucle sur chaque matiŠre
    FOR id_matiere IN (SELECT id FROM matieres) LOOP
        -- G‚n‚rer `nombre_examens` pour chaque matiŠre
        FOR i IN 1..nombre_examens LOOP
            -- G‚n‚ration d'une date al‚atoire entre date_debut et date_fin
            random_date := date_debut + (random() * (date_fin - date_debut))::INT;
            
            -- Insertion dans la table examen
            INSERT INTO examen (id, dateExamen, idMatiere)
            VALUES (
                CONCAT('EXAM', LPAD(nextval('seq_examen')::TEXT, 9, '0')), -- G‚n‚ration d'un ID unique
                random_date,
                id_matiere
            );
        END LOOP;
    END LOOP;
END;
$$;


ALTER PROCEDURE public.generer_examens(IN nombre_examens integer, IN date_debut date, IN date_fin date) OWNER TO postgres;

--
-- Name: generer_inscriptions(); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.generer_inscriptions()
    LANGUAGE plpgsql
    AS $$
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


ALTER PROCEDURE public.generer_inscriptions() OWNER TO postgres;

--
-- Name: generer_notes(numeric, numeric); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.generer_notes(IN notemin numeric, IN notemax numeric)
    LANGUAGE plpgsql
    AS $$
DECLARE
    id_inscription VARCHAR(50);
    id_examen VARCHAR(50);
    session_id VARCHAR(50); -- Variable pour stocker l'idSession
    random_note NUMERIC(5,2);
BEGIN
    -- Boucle pour chaque examen avec sa session associ‚e
    FOR id_examen, session_id IN 
        (SELECT id, idsession FROM examen) LOOP
        -- Boucle pour chaque inscription li‚e … la session du semestre
        FOR id_inscription IN 
            (SELECT i.id 
             FROM inscription i 
             JOIN session_semestre ss ON i.idSessionSemestre = ss.id
             WHERE idSession = session_id) LOOP
            -- G‚n‚rer une note al‚atoire entre noteMin et noteMax
            random_note := noteMin + (noteMax - noteMin) * random();

            -- Ins‚rer dans la table notes
            INSERT INTO notes (valeur, idInscription, idExamen)
            VALUES (random_note, id_inscription, id_examen);
        END LOOP;
    END LOOP;
END;
$$;


ALTER PROCEDURE public.generer_notes(IN notemin numeric, IN notemax numeric) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO postgres;

--
-- Name: seq_examen; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_examen
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_examen OWNER TO postgres;

--
-- Name: etudiant; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.etudiant (
    id character varying(50) DEFAULT concat('ETU', lpad((nextval('public.seq_examen'::regclass))::text, 9, '0'::text)) NOT NULL,
    nom character varying(50) DEFAULT ''::character varying NOT NULL,
    prenom character varying(50) DEFAULT ''::character varying,
    datenaissance character varying(50) NOT NULL,
    idfiliere character varying(50) NOT NULL
);


ALTER TABLE public.etudiant OWNER TO postgres;

--
-- Name: examen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.examen (
    id character varying(50) NOT NULL,
    dateexamen date DEFAULT CURRENT_DATE,
    idmatiere character varying(50) NOT NULL,
    idsession character varying(50)
);


ALTER TABLE public.examen OWNER TO postgres;

--
-- Name: seq_filiere; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_filiere
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_filiere OWNER TO postgres;

--
-- Name: filiere; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.filiere (
    id character varying(50) DEFAULT concat('FIL', lpad((nextval('public.seq_filiere'::regclass))::text, 4, '0'::text)) NOT NULL,
    description character varying(50) DEFAULT ''::character varying
);


ALTER TABLE public.filiere OWNER TO postgres;

--
-- Name: seq_inscription; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_inscription
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_inscription OWNER TO postgres;

--
-- Name: inscription; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.inscription (
    id character varying(50) DEFAULT concat('INSCR', lpad((nextval('public.seq_inscription'::regclass))::text, 9, '0'::text)) NOT NULL,
    idetudiant character varying(50) NOT NULL,
    idsessionsemestre character varying(50) NOT NULL
);


ALTER TABLE public.inscription OWNER TO postgres;

--
-- Name: seq_matieres; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_matieres
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_matieres OWNER TO postgres;

--
-- Name: matieres; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.matieres (
    id character varying(50) DEFAULT concat('MTR', lpad((nextval('public.seq_matieres'::regclass))::text, 4, '0'::text)) NOT NULL,
    nom character varying(50) NOT NULL,
    credit integer,
    idsemestre character varying(50) NOT NULL,
    idfiliere character varying(50) NOT NULL,
    CONSTRAINT matieres_credit_check CHECK ((credit > 0))
);


ALTER TABLE public.matieres OWNER TO postgres;

--
-- Name: seq_niveau; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_niveau
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_niveau OWNER TO postgres;

--
-- Name: niveau; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.niveau (
    id character varying(50) DEFAULT concat('NIV', lpad((nextval('public.seq_niveau'::regclass))::text, 4, '0'::text)) NOT NULL,
    nom character varying(50) NOT NULL
);


ALTER TABLE public.niveau OWNER TO postgres;

--
-- Name: seq_notes; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_notes
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_notes OWNER TO postgres;

--
-- Name: notes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notes (
    id character varying(50) DEFAULT concat('NT', lpad((nextval('public.seq_notes'::regclass))::text, 9, '0'::text)) NOT NULL,
    valeur numeric(5,2) DEFAULT 0,
    idinscription character varying(50) NOT NULL,
    idexamen character varying(50) NOT NULL
);


ALTER TABLE public.notes OWNER TO postgres;

--
-- Name: seq_semestre; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_semestre
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_semestre OWNER TO postgres;

--
-- Name: semestre; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.semestre (
    id character varying(50) DEFAULT concat('SMT', lpad((nextval('public.seq_semestre'::regclass))::text, 4, '0'::text)) NOT NULL,
    description character varying(50) NOT NULL,
    idniveau character varying(50) NOT NULL
);


ALTER TABLE public.semestre OWNER TO postgres;

--
-- Name: seq_etudiant; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_etudiant
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_etudiant OWNER TO postgres;

--
-- Name: seq_session; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_session
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_session OWNER TO postgres;

--
-- Name: seq_sessionsemestre; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_sessionsemestre
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_sessionsemestre OWNER TO postgres;

--
-- Name: session; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.session (
    id character varying(50) DEFAULT concat('SES', lpad((nextval('public.seq_session'::regclass))::text, 4, '0'::text)) NOT NULL,
    dateinscription date DEFAULT CURRENT_DATE
);


ALTER TABLE public.session OWNER TO postgres;

--
-- Name: session_semestre; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.session_semestre (
    id character varying(50) DEFAULT concat('SSM', lpad((nextval('public.seq_sessionsemestre'::regclass))::text, 4, '0'::text)) NOT NULL,
    idsession character varying(50) NOT NULL,
    idsemestre character varying(50) NOT NULL
);


ALTER TABLE public.session_semestre OWNER TO postgres;

--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
\.


--
-- Data for Name: etudiant; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.etudiant (id, nom, prenom, datenaissance, idfiliere) FROM stdin;
ETU002315252	Nom 1	Prenom 1	2002-03-03	FIL1
ETU002315253	Nom 2	Prenom 2	2004-08-25	FIL1
ETU002315254	Nom 3	Prenom 3	2002-07-17	FIL1
ETU002315255	Nom 4	Prenom 4	2001-12-04	FIL1
ETU002315256	Nom 5	Prenom 5	2002-02-20	FIL1
ETU002315257	Nom 6	Prenom 6	2005-10-15	FIL1
ETU002315258	Nom 7	Prenom 7	2004-01-08	FIL1
ETU002315259	Nom 8	Prenom 8	2004-07-12	FIL1
ETU002315260	Nom 9	Prenom 9	2003-05-12	FIL1
ETU002315261	Nom 10	Prenom 10	2005-06-18	FIL1
\.


--
-- Data for Name: examen; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.examen (id, dateexamen, idmatiere, idsession) FROM stdin;
EXAM002315262	2024-03-10	INF101	SES1
EXAM002315263	2023-12-05	INF104	SES1
EXAM002315264	2024-06-26	INF107	SES1
EXAM002315265	2024-06-01	MTH101	SES1
EXAM002315266	2024-01-22	MTH102	SES1
EXAM002315267	2024-02-20	ORG101	SES1
EXAM002315268	2024-06-27	INF102	SES2
EXAM002315269	2024-06-25	INF103	SES2
EXAM002315270	2023-09-22	INF105	SES2
EXAM002315271	2024-02-02	INF106	SES2
EXAM002315272	2024-06-28	MTH103	SES2
EXAM002315273	2023-10-16	MTH105	SES2
\.


--
-- Data for Name: filiere; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.filiere (id, description) FROM stdin;
FIL1	Informatique
\.


--
-- Data for Name: inscription; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.inscription (id, idetudiant, idsessionsemestre) FROM stdin;
INSCR000166669	ETU002315252	SSM0001
INSCR000166670	ETU002315253	SSM0001
INSCR000166671	ETU002315254	SSM0001
INSCR000166672	ETU002315255	SSM0001
INSCR000166673	ETU002315256	SSM0001
INSCR000166674	ETU002315257	SSM0001
INSCR000166675	ETU002315258	SSM0001
INSCR000166676	ETU002315259	SSM0001
INSCR000166677	ETU002315260	SSM0001
INSCR000166678	ETU002315261	SSM0001
INSCR000166679	ETU002315252	SSM0002
INSCR000166680	ETU002315253	SSM0002
INSCR000166681	ETU002315254	SSM0002
INSCR000166682	ETU002315255	SSM0002
INSCR000166683	ETU002315256	SSM0002
INSCR000166684	ETU002315257	SSM0002
INSCR000166685	ETU002315258	SSM0002
INSCR000166686	ETU002315259	SSM0002
INSCR000166687	ETU002315260	SSM0002
INSCR000166688	ETU002315261	SSM0002
\.


--
-- Data for Name: matieres; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.matieres (id, nom, credit, idsemestre, idfiliere) FROM stdin;
INF101	Programmation proc‚durale	7	S1	FIL1
INF104	HTML et Introduction au Web	5	S1	FIL1
INF107	Informatique de Base	4	S1	FIL1
MTH101	Arithm‚tique et nombres	4	S1	FIL1
MTH102	Analyse math‚matique	6	S1	FIL1
ORG101	Techniques de communication	4	S1	FIL1
INF102	Bases de donn‚es relationnelles	5	S2	FIL1
INF103	Bases de l administration systŠme	5	S2	FIL1
INF105	Maintenance mat‚riel et logiciel	4	S2	FIL1
INF106	Compl‚ments de programmation	6	S2	FIL1
MTH103	Calcul Vectoriel et Matriciel	6	S2	FIL1
MTH105	Probabilit‚ et Statistique	4	S2	FIL1
\.


--
-- Data for Name: niveau; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.niveau (id, nom) FROM stdin;
L1	Licence 1
L2	Licence 2
L3	Licence 3
M1	Master 1
M2	Master 2
\.


--
-- Data for Name: notes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notes (id, valeur, idinscription, idexamen) FROM stdin;
NT001000009	11.40	INSCR000166669	EXAM002315262
NT001000010	7.95	INSCR000166670	EXAM002315262
NT001000011	6.97	INSCR000166671	EXAM002315262
NT001000012	6.38	INSCR000166672	EXAM002315262
NT001000013	13.98	INSCR000166673	EXAM002315262
NT001000014	10.26	INSCR000166674	EXAM002315262
NT001000015	19.74	INSCR000166675	EXAM002315262
NT001000016	1.97	INSCR000166676	EXAM002315262
NT001000017	7.15	INSCR000166677	EXAM002315262
NT001000018	2.59	INSCR000166678	EXAM002315262
NT001000019	3.66	INSCR000166669	EXAM002315263
NT001000020	18.85	INSCR000166670	EXAM002315263
NT001000021	3.22	INSCR000166671	EXAM002315263
NT001000022	17.70	INSCR000166672	EXAM002315263
NT001000023	7.49	INSCR000166673	EXAM002315263
NT001000024	5.42	INSCR000166674	EXAM002315263
NT001000025	10.42	INSCR000166675	EXAM002315263
NT001000026	14.96	INSCR000166676	EXAM002315263
NT001000027	1.06	INSCR000166677	EXAM002315263
NT001000028	18.56	INSCR000166678	EXAM002315263
NT001000029	17.00	INSCR000166669	EXAM002315264
NT001000030	2.11	INSCR000166670	EXAM002315264
NT001000031	10.80	INSCR000166671	EXAM002315264
NT001000032	13.34	INSCR000166672	EXAM002315264
NT001000033	7.19	INSCR000166673	EXAM002315264
NT001000034	16.57	INSCR000166674	EXAM002315264
NT001000035	16.70	INSCR000166675	EXAM002315264
NT001000036	6.44	INSCR000166676	EXAM002315264
NT001000037	5.07	INSCR000166677	EXAM002315264
NT001000038	5.64	INSCR000166678	EXAM002315264
NT001000039	1.21	INSCR000166669	EXAM002315265
NT001000040	10.82	INSCR000166670	EXAM002315265
NT001000041	11.13	INSCR000166671	EXAM002315265
NT001000042	2.62	INSCR000166672	EXAM002315265
NT001000043	17.56	INSCR000166673	EXAM002315265
NT001000044	4.07	INSCR000166674	EXAM002315265
NT001000045	1.24	INSCR000166675	EXAM002315265
NT001000046	18.97	INSCR000166676	EXAM002315265
NT001000047	10.07	INSCR000166677	EXAM002315265
NT001000048	10.68	INSCR000166678	EXAM002315265
NT001000049	12.30	INSCR000166669	EXAM002315266
NT001000050	6.83	INSCR000166670	EXAM002315266
NT001000051	6.00	INSCR000166671	EXAM002315266
NT001000052	19.61	INSCR000166672	EXAM002315266
NT001000053	5.25	INSCR000166673	EXAM002315266
NT001000054	18.87	INSCR000166674	EXAM002315266
NT001000055	5.90	INSCR000166675	EXAM002315266
NT001000056	4.43	INSCR000166676	EXAM002315266
NT001000057	15.03	INSCR000166677	EXAM002315266
NT001000058	8.08	INSCR000166678	EXAM002315266
NT001000059	8.40	INSCR000166669	EXAM002315267
NT001000060	17.39	INSCR000166670	EXAM002315267
NT001000061	17.06	INSCR000166671	EXAM002315267
NT001000062	9.84	INSCR000166672	EXAM002315267
NT001000063	10.45	INSCR000166673	EXAM002315267
NT001000064	5.49	INSCR000166674	EXAM002315267
NT001000065	6.21	INSCR000166675	EXAM002315267
NT001000066	19.71	INSCR000166676	EXAM002315267
NT001000067	15.29	INSCR000166677	EXAM002315267
NT001000068	17.73	INSCR000166678	EXAM002315267
NT001000069	9.49	INSCR000166679	EXAM002315268
NT001000070	1.54	INSCR000166680	EXAM002315268
NT001000071	12.21	INSCR000166681	EXAM002315268
NT001000072	13.75	INSCR000166682	EXAM002315268
NT001000073	9.61	INSCR000166683	EXAM002315268
NT001000074	4.13	INSCR000166684	EXAM002315268
NT001000075	7.09	INSCR000166685	EXAM002315268
NT001000076	8.77	INSCR000166686	EXAM002315268
NT001000077	7.26	INSCR000166687	EXAM002315268
NT001000078	8.67	INSCR000166688	EXAM002315268
NT001000079	16.21	INSCR000166679	EXAM002315269
NT001000080	16.72	INSCR000166680	EXAM002315269
NT001000081	17.18	INSCR000166681	EXAM002315269
NT001000082	19.16	INSCR000166682	EXAM002315269
NT001000083	8.58	INSCR000166683	EXAM002315269
NT001000084	16.25	INSCR000166684	EXAM002315269
NT001000085	1.96	INSCR000166685	EXAM002315269
NT001000086	5.85	INSCR000166686	EXAM002315269
NT001000087	7.58	INSCR000166687	EXAM002315269
NT001000088	9.87	INSCR000166688	EXAM002315269
NT001000089	19.24	INSCR000166679	EXAM002315270
NT001000090	15.99	INSCR000166680	EXAM002315270
NT001000091	12.86	INSCR000166681	EXAM002315270
NT001000092	3.23	INSCR000166682	EXAM002315270
NT001000093	15.72	INSCR000166683	EXAM002315270
NT001000094	11.02	INSCR000166684	EXAM002315270
NT001000095	9.52	INSCR000166685	EXAM002315270
NT001000096	14.43	INSCR000166686	EXAM002315270
NT001000097	6.38	INSCR000166687	EXAM002315270
NT001000098	19.38	INSCR000166688	EXAM002315270
NT001000099	14.62	INSCR000166679	EXAM002315271
NT001000100	19.69	INSCR000166680	EXAM002315271
NT001000101	15.79	INSCR000166681	EXAM002315271
NT001000102	3.83	INSCR000166682	EXAM002315271
NT001000103	3.55	INSCR000166683	EXAM002315271
NT001000104	18.00	INSCR000166684	EXAM002315271
NT001000105	11.16	INSCR000166685	EXAM002315271
NT001000106	4.18	INSCR000166686	EXAM002315271
NT001000107	1.03	INSCR000166687	EXAM002315271
NT001000108	11.88	INSCR000166688	EXAM002315271
NT001000109	4.07	INSCR000166679	EXAM002315272
NT001000110	9.66	INSCR000166680	EXAM002315272
NT001000111	4.92	INSCR000166681	EXAM002315272
NT001000112	13.43	INSCR000166682	EXAM002315272
NT001000113	7.88	INSCR000166683	EXAM002315272
NT001000114	1.51	INSCR000166684	EXAM002315272
NT001000115	3.59	INSCR000166685	EXAM002315272
NT001000116	4.03	INSCR000166686	EXAM002315272
NT001000117	5.38	INSCR000166687	EXAM002315272
NT001000118	7.02	INSCR000166688	EXAM002315272
NT001000119	15.92	INSCR000166679	EXAM002315273
NT001000120	11.48	INSCR000166680	EXAM002315273
NT001000121	13.62	INSCR000166681	EXAM002315273
NT001000122	3.00	INSCR000166682	EXAM002315273
NT001000123	19.21	INSCR000166683	EXAM002315273
NT001000124	8.83	INSCR000166684	EXAM002315273
NT001000125	9.40	INSCR000166685	EXAM002315273
NT001000126	15.39	INSCR000166686	EXAM002315273
NT001000127	8.21	INSCR000166687	EXAM002315273
NT001000128	18.67	INSCR000166688	EXAM002315273
\.


--
-- Data for Name: semestre; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.semestre (id, description, idniveau) FROM stdin;
S1	Semestre 1	L1
S2	Semestre 2	L1
\.


--
-- Data for Name: session; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.session (id, dateinscription) FROM stdin;
SES1	2023-09-10
SES2	2024-02-10
\.


--
-- Data for Name: session_semestre; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.session_semestre (id, idsession, idsemestre) FROM stdin;
SSM0001	SES1	S1
SSM0002	SES2	S2
\.


--
-- Name: seq_etudiant; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_etudiant', 1, false);


--
-- Name: seq_examen; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_examen', 2315273, true);


--
-- Name: seq_filiere; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_filiere', 1, false);


--
-- Name: seq_inscription; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_inscription', 166688, true);


--
-- Name: seq_matieres; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_matieres', 1, false);


--
-- Name: seq_niveau; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_niveau', 1, false);


--
-- Name: seq_notes; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_notes', 1000128, true);


--
-- Name: seq_semestre; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_semestre', 1, false);


--
-- Name: seq_session; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_session', 1, false);


--
-- Name: seq_sessionsemestre; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_sessionsemestre', 2, true);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: etudiant etudiant_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etudiant
    ADD CONSTRAINT etudiant_pkey PRIMARY KEY (id);


--
-- Name: examen examen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examen
    ADD CONSTRAINT examen_pkey PRIMARY KEY (id);


--
-- Name: filiere filiere_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.filiere
    ADD CONSTRAINT filiere_pkey PRIMARY KEY (id);


--
-- Name: inscription inscription_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscription
    ADD CONSTRAINT inscription_pkey PRIMARY KEY (id);


--
-- Name: matieres matieres_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.matieres
    ADD CONSTRAINT matieres_pkey PRIMARY KEY (id);


--
-- Name: niveau niveau_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.niveau
    ADD CONSTRAINT niveau_pkey PRIMARY KEY (id);


--
-- Name: notes notes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notes
    ADD CONSTRAINT notes_pkey PRIMARY KEY (id);


--
-- Name: semestre semestre_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.semestre
    ADD CONSTRAINT semestre_pkey PRIMARY KEY (id);


--
-- Name: session session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_pkey PRIMARY KEY (id);


--
-- Name: session_semestre session_semestre_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_semestre
    ADD CONSTRAINT session_semestre_pkey PRIMARY KEY (id);


--
-- Name: etudiant etudiant_idfiliere_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etudiant
    ADD CONSTRAINT etudiant_idfiliere_fkey FOREIGN KEY (idfiliere) REFERENCES public.filiere(id);


--
-- Name: examen examen_idmatiere_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examen
    ADD CONSTRAINT examen_idmatiere_fkey FOREIGN KEY (idmatiere) REFERENCES public.matieres(id);


--
-- Name: examen examen_idsession_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examen
    ADD CONSTRAINT examen_idsession_fkey FOREIGN KEY (idsession) REFERENCES public.session(id);


--
-- Name: inscription inscription_idetudiant_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscription
    ADD CONSTRAINT inscription_idetudiant_fkey FOREIGN KEY (idetudiant) REFERENCES public.etudiant(id);


--
-- Name: inscription inscription_idsessionsemestre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscription
    ADD CONSTRAINT inscription_idsessionsemestre_fkey FOREIGN KEY (idsessionsemestre) REFERENCES public.session_semestre(id);


--
-- Name: matieres matieres_idfiliere_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.matieres
    ADD CONSTRAINT matieres_idfiliere_fkey FOREIGN KEY (idfiliere) REFERENCES public.filiere(id);


--
-- Name: matieres matieres_idsemestre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.matieres
    ADD CONSTRAINT matieres_idsemestre_fkey FOREIGN KEY (idsemestre) REFERENCES public.semestre(id);


--
-- Name: notes notes_idexamen_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notes
    ADD CONSTRAINT notes_idexamen_fkey FOREIGN KEY (idexamen) REFERENCES public.examen(id);


--
-- Name: notes notes_idinscription_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notes
    ADD CONSTRAINT notes_idinscription_fkey FOREIGN KEY (idinscription) REFERENCES public.inscription(id);


--
-- Name: semestre semestre_idniveau_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.semestre
    ADD CONSTRAINT semestre_idniveau_fkey FOREIGN KEY (idniveau) REFERENCES public.niveau(id);


--
-- Name: session_semestre session_semestre_idsemestre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_semestre
    ADD CONSTRAINT session_semestre_idsemestre_fkey FOREIGN KEY (idsemestre) REFERENCES public.semestre(id);


--
-- Name: session_semestre session_semestre_idsession_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_semestre
    ADD CONSTRAINT session_semestre_idsession_fkey FOREIGN KEY (idsession) REFERENCES public.session(id);


--
-- PostgreSQL database dump complete
--


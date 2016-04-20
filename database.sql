SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: add_date_on_comm(); Type: FUNCTION; Schema: public; Owner: cartong
--

CREATE FUNCTION add_date_on_comm() RETURNS trigger
    LANGUAGE plpgsql
    AS $$

BEGIN

        NEW."date_publish" = now();

        RETURN NEW;

END;

$$;


ALTER FUNCTION public.add_date_on_comm() OWNER TO cartong;

--
-- Name: add_date_on_insert(); Type: FUNCTION; Schema: public; Owner: cartong
--

CREATE FUNCTION add_date_on_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$

BEGIN

        NEW."Date_register" = now();

        RETURN NEW;

END;

$$;


ALTER FUNCTION public.add_date_on_insert() OWNER TO cartong;

--
-- Name: add_date_on_user_register(); Type: FUNCTION; Schema: public; Owner: cartong
--

CREATE FUNCTION add_date_on_user_register() RETURNS trigger
    LANGUAGE plpgsql
    AS $$

BEGIN

        NEW."date_inscription" = now();

        RETURN NEW;

END;

$$;


ALTER FUNCTION public.add_date_on_user_register() OWNER TO cartong;

--
-- Name: insert_or_update(integer, text, text, text, text, integer, integer); Type: FUNCTION; Schema: public; Owner: cartong
--

CREATE FUNCTION insert_or_update(key integer, descr text, nom text, site text, type_donnee text, echelle integer, sp integer) RETURNS void
    LANGUAGE plpgsql
    AS $$

BEGIN

        LOOP

        UPDATE "Fournisseurs_donnees" SET "Description_structure" = Descr, "Nom_structure" = Nom, "Site" = Site, "Type_donnee" = Type_donnee, "Echelle" = echelle, "Systeme_projection" = sp WHERE "ID" = key;

        IF found THEN

            RETURN;

        END IF;

        BEGIN

            INSERT INTO "Fournisseurs_donnees"("Description_structure", "Nom_structure", "Site", "Type_donnee", "Echelle", "Systeme_projection") VALUES (Descr, Nom, Site, Type_donnee, echelle, sp);

            RETURN;

        EXCEPTION WHEN unique_violation THEN

        END;

        END LOOP;

END;

$$;


ALTER FUNCTION public.insert_or_update(key integer, descr text, nom text, site text, type_donnee text, echelle integer, sp integer) OWNER TO cartong;

--
-- Name: rating(integer, double precision); Type: FUNCTION; Schema: public; Owner: cartong
--

CREATE FUNCTION rating(id integer, score double precision) RETURNS double precision
    LANGUAGE plpgsql
    AS $$

DECLARE

        res double precision;

BEGIN

        UPDATE "Fournisseurs_donnees" SET "Rating" = ("Rating" + score) / 2 WHERE "ID" = id;

        SELECT "Rating" INTO res FROM "Fournisseurs_donnees" WHERE "ID" = id;

        RETURN res;

END;

$$;


ALTER FUNCTION public.rating(id integer, score double precision) OWNER TO cartong;

--
-- Name: Commentaire_id_seq; Type: SEQUENCE; Schema: public; Owner: cartong
--

CREATE SEQUENCE "Commentaire_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Commentaire_id_seq" OWNER TO cartong;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: Commentaire; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Commentaire" (
    id integer DEFAULT nextval('"Commentaire_id_seq"'::regclass) NOT NULL,
    id_fournisseur integer NOT NULL,
    content text NOT NULL,
    id_membre integer NOT NULL,
    date_publish date
);


ALTER TABLE public."Commentaire" OWNER TO cartong;

--
-- Name: Echelle; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Echelle" (
    "ID" integer NOT NULL,
    "Echelle" character(200)
);


ALTER TABLE public."Echelle" OWNER TO cartong;

--
-- Name: Echelle_ID_seq; Type: SEQUENCE; Schema: public; Owner: cartong
--

CREATE SEQUENCE "Echelle_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Echelle_ID_seq" OWNER TO cartong;

--
-- Name: Echelle_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cartong
--

ALTER SEQUENCE "Echelle_ID_seq" OWNED BY "Echelle"."ID";


--
-- Name: Fournisseur_localisation; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Fournisseur_localisation" (
    id_fournisseur integer NOT NULL,
    id_localisation integer NOT NULL
);


ALTER TABLE public."Fournisseur_localisation" OWNER TO cartong;

--
-- Name: Fournisseurs_donnees; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Fournisseurs_donnees" (
    "ID" integer NOT NULL,
    "Nom_structure" character varying(255),
    "Site" character varying(255),
    "Description_structure" text,
    "Type_donnee" character varying(255),
    "Date_register" date,
    "Echelle" integer,
    "Systeme_projection" integer,
    "Rating" double precision DEFAULT (2.5)::double precision,
    field character varying(2044)
);


ALTER TABLE public."Fournisseurs_donnees" OWNER TO cartong;

--
-- Name: Fournisseurs_donnees_ID_seq; Type: SEQUENCE; Schema: public; Owner: cartong
--

CREATE SEQUENCE "Fournisseurs_donnees_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Fournisseurs_donnees_ID_seq" OWNER TO cartong;

--
-- Name: Fournisseurs_donnees_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cartong
--

ALTER SEQUENCE "Fournisseurs_donnees_ID_seq" OWNED BY "Fournisseurs_donnees"."ID";


--
-- Name: Fournisseurs_thematique; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Fournisseurs_thematique" (
    id_fournisseur integer NOT NULL,
    id_thematique integer NOT NULL
);


ALTER TABLE public."Fournisseurs_thematique" OWNER TO cartong;

--
-- Name: Localisation; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Localisation" (
    "ID" integer NOT NULL,
    "Name" character varying(255) NOT NULL
);


ALTER TABLE public."Localisation" OWNER TO cartong;

--
-- Name: Localisation_ID_seq; Type: SEQUENCE; Schema: public; Owner: cartong
--

CREATE SEQUENCE "Localisation_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Localisation_ID_seq" OWNER TO cartong;

--
-- Name: Localisation_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cartong
--

ALTER SEQUENCE "Localisation_ID_seq" OWNED BY "Localisation"."ID";


--
-- Name: Membre_id_seq; Type: SEQUENCE; Schema: public; Owner: cartong
--

CREATE SEQUENCE "Membre_id_seq"
    START WITH 0
    INCREMENT BY 1
    MINVALUE 0
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Membre_id_seq" OWNER TO cartong;

--
-- Name: Membre; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Membre" (
    id integer DEFAULT nextval('"Membre_id_seq"'::regclass) NOT NULL,
    login character varying(255) NOT NULL,
    mail character varying(255) NOT NULL,
    password character varying(500) NOT NULL,
    date_inscription date,
    admin boolean DEFAULT false NOT NULL
);


ALTER TABLE public."Membre" OWNER TO cartong;

--
-- Name: Systeme_projection; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Systeme_projection" (
    "ID" integer NOT NULL,
    "EPSG" character(300),
    "Systeme_projection" character(300)
);


ALTER TABLE public."Systeme_projection" OWNER TO cartong;

--
-- Name: Systeme_projection_ID_seq; Type: SEQUENCE; Schema: public; Owner: cartong
--

CREATE SEQUENCE "Systeme_projection_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Systeme_projection_ID_seq" OWNER TO cartong;

--
-- Name: Systeme_projection_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cartong
--

ALTER SEQUENCE "Systeme_projection_ID_seq" OWNED BY "Systeme_projection"."ID";


--
-- Name: Thematique; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE "Thematique" (
    "ID" integer NOT NULL,
    "Theme" character(200)
);


ALTER TABLE public."Thematique" OWNER TO cartong;

--
-- Name: Thematique_ID_seq; Type: SEQUENCE; Schema: public; Owner: cartong
--

CREATE SEQUENCE "Thematique_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Thematique_ID_seq" OWNER TO cartong;

--
-- Name: Thematique_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cartong
--

ALTER SEQUENCE "Thematique_ID_seq" OWNED BY "Thematique"."ID";


--
-- Name: vs_database_diagrams; Type: TABLE; Schema: public; Owner: cartong; Tablespace:
--

CREATE TABLE vs_database_diagrams (
    name character varying(80),
    diadata text,
    comment character varying(1022),
    preview text,
    lockinfo character varying(80),
    locktime timestamp with time zone,
    version character varying(80)
);


ALTER TABLE public.vs_database_diagrams OWNER TO cartong;

--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Echelle" ALTER COLUMN "ID" SET DEFAULT nextval('"Echelle_ID_seq"'::regclass);


--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Fournisseurs_donnees" ALTER COLUMN "ID" SET DEFAULT nextval('"Fournisseurs_donnees_ID_seq"'::regclass);


--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Localisation" ALTER COLUMN "ID" SET DEFAULT nextval('"Localisation_ID_seq"'::regclass);


--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Systeme_projection" ALTER COLUMN "ID" SET DEFAULT nextval('"Systeme_projection_ID_seq"'::regclass);


--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Thematique" ALTER COLUMN "ID" SET DEFAULT nextval('"Thematique_ID_seq"'::regclass);


--
-- Data for Name: Commentaire; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Commentaire" (id, id_fournisseur, content, id_membre, date_publish) FROM stdin;
9       5       Curabitur faucibus urna quis velit scelerisque hendrerit. Nulla accumsan lectus lorem, eget auctor quam suscipit in. Integer porta et velit sed consectetur. Vivamus nisi nulla, laoreet imperdiet varius id, ornare quis orci. In pretium eros et aliquet interdum. Nam ultricies nisi quis nunc vehicula auctor. Vestibulum mattis scelerisque justo eget tristique. Donec dignissim semper felis, et aliquet metus euismod non. Fusce eget porta nisl. In rhoncus tempor diam, ac rhoncus magna gravida sed.   2       2015-03-25
13      5       Nam tempor magna dui, vitae hendrerit neque vehicula vehicula. Suspendisse fermentum neque est. Nunc elementum ipsum quis iaculis tincidunt. Aenean dapibus in libero quis tempor. Quisque volutpat tortor sed purus pulvinar maximus. Pellentesque rhoncus velit sed urna condimentum, a vestibulum nulla fringilla. In quis venenatis leo. Integer gravida semper augue, at gravida nunc feugiat at. Etiam at placerat mi.      1       2015-03-25
15      5       fsefsefsefsfsfsefsefse  1       2015-03-26
16      5       sfefsefsefsefsef        1       2015-03-26
\.


--
-- Name: Commentaire_id_seq; Type: SEQUENCE SET; Schema: public; Owner: cartong
--

SELECT pg_catalog.setval('"Commentaire_id_seq"', 16, true);


--
-- Data for Name: Echelle; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Echelle" ("ID", "Echelle") FROM stdin;
6       1/25000                                                                                                                                                                                  
7       1/10000                                                                                                                                                                                  
9       1/5000                                                                                                                                                                                   
10      1/2000                                                                                                                                                                                   
16      1222                                                                                                                                                                                     
\.


--
-- Name: Echelle_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: cartong
--

SELECT pg_catalog.setval('"Echelle_ID_seq"', 23, true);


--
-- Data for Name: Fournisseur_localisation; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Fournisseur_localisation" (id_fournisseur, id_localisation) FROM stdin;
\.


--
-- Data for Name: Fournisseurs_donnees; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Fournisseurs_donnees" ("ID", "Nom_structure", "Site", "Description_structure", "Type_donnee", "Date_register", "Echelle", "Systeme_projection", "Rating", field) FROM stdin;
10      USGS    http://earthexplorer.usgs.gov/  Site de diffusion des données de l USGS \N      2015-03-26      7       4       2.5     \N
11      Geohive http://www.geohive.com/ Données de population à l échelle mondiale      \N      2015-03-26      \N      5       2.5     \N
12      ESA     https://earth.esa.int/  Données de l agence spatiale européenne \N      2015-03-26      \N      \N      2.5     \N
13      GADM    http://www.gadm.org/    Découpage administratif mondial \N      2015-03-26      \N      \N      2.5     \N
14      OAK Ridge National Laboratory   http://web.ornl.gov/sci/landscan/       Population mondiale au km2      \N      2015-03-26      \N      \N      2.5     \N
15      NASA SEDAC      http://sedac.ciesin.columbia.edu/data/sets/browse       bases de données sociaux économique     \N      2015-03-26      \N      \N      2.5     \N
16      UNEP Data explorer      http://geodata.grid.unep.ch/    site de téléchargement des bases de données de l UNEP   \N      2015-03-26      \N      \N      2.5     \N
17      NASA STRM       http://dds.cr.usgs.gov/srtm/version2_1/ site de téléchargement de bases de données des MNT Mondial      \N      2015-03-26      \N      \N      2.5     \N
18      Worldclimat     http://www.worldclim.org/       Téléchargement de données climatique mesurée actuelle et future du  GIEC        \N      2015-03-26      \N      \N      2.5     \N
19      ESA     http://maps.elie.ucl.ac.be/CCI/viewer/index.php Téléchargement des données d occupation du sol à l échelle mondiale     \N      2015-03-26      \N      \N      2.5     \N
20      METI/NASA       http://gdem.ersdac.jspacesystems.or.jp/search.jsp       Téléchargement de MNT (30m)     \N      2015-03-26      \N      \N      2.5     \N
21      Humanitarian data exchange      https://data.hdx.rwlabs.org/    Données publiées par les ONG et programmes humanitaires \N      2015-03-26      \N      \N      2.5     \N
22      FAO     http://www.fao.org/geonetwork/srv/fr/main.home  Catalogue de metadonnée de la FAO       \N      2015-03-26      \N      \N      2.5     \N
23      Natural Earth   http://www.naturalearthdata.com/        \N      \N      2015-03-26      \N      \N      2.5     \N
7       SRTM    http://srtm.csi.cgiar.org/      Site de téléchargement du SRTM  \N      2015-03-26      6       3       2.5     \N
8       Geonames        http://download.geonames.org/export/dump/       Base de données de points d interet     \N      2015-03-26      6       1       2.5     \N
9       COD-FOD http://www.humanitarianresponse.info/applications/data  Base de données dédié à l humanitaire   \N      2015-03-26      6       4       2.5     \N
24      global map      http://www.gsi.go.jp/kankyochiri/globalmap_e.html       \N      \N      2015-03-26      \N      \N      2.5     \N
25      NSF Open Topography     http://opentopo.sdsc.edu/gridsphere/gridsphere?cid=datasets     \N      \N      2015-03-26      \N      \N      2.5     \N
26      Atlas of the Biosphere  http://www.sage.wisc.edu/atlas/maps.php                 2015-03-26      6       2       2.5     \N
28      Harmonized world soil database  http://webarchive.iiasa.ac.at/Research/LUC/External-World-soil-database/HTML/index.html?sb=1    \N      \N      2015-03-26      \N      \N      2.5     \N
30      World bank      http://sourceforge.net/projects/googleworldbank/        \N      \N      2015-03-26      \N      \N      2.5     \N
31      Crop Calendar   http://www.sage.wisc.edu/download/sacks/crop_calendar.html      \N      \N      2015-03-26      \N      \N      2.5     \N
32      Geoportail Inspire      http://inspire-geoportal.ec.europa.eu/discovery/        \N      \N      2015-03-26      \N      \N      2.5     \N
33      International water management institute        http://www.iwmigiam.org/info/gmia/default.asp   \N      \N      2015-03-26      \N      \N      2.5     \N
35      World port index        http://msi.nga.mil/NGAPortal/MSI.portal?_nfpb=true&_pageLabel=msi_portal_page_62&pubCode=0015   \N      \N      2015-03-26      \N      \N      2.5     \N
36      Openflights     http://openflights.org/data.html        \N      \N      2015-03-26      \N      \N      2.5     \N
5       Diva-GIS        http://www.diva-gis.org/gdata   Extrait de plusieurs BDD mondiales sur différentes thématiques  rfdst   2015-03-26      6       2       2.5     \N
29      Données UNEP    http://datadownload.unep-wcmc.org/datasets      \N      \N      2015-03-26      \N      \N      3.609375        \N
50      dqzdqdqzdqz     http://carte-ong.com/controllers/edit.php       dqdqzdqzdqzd            2015-03-26      \N      \N      2.5     \N
\.


--
-- Name: Fournisseurs_donnees_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: cartong
--

SELECT pg_catalog.setval('"Fournisseurs_donnees_ID_seq"', 50, true);


--
-- Data for Name: Fournisseurs_thematique; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Fournisseurs_thematique" (id_fournisseur, id_thematique) FROM stdin;
5       1
5       2
5       3
5       4
5       5
5       6
\.


--
-- Data for Name: Localisation; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Localisation" ("ID", "Name") FROM stdin;
\.


--
-- Name: Localisation_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: cartong
--

SELECT pg_catalog.setval('"Localisation_ID_seq"', 1, false);


--
-- Data for Name: Membre; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Membre" (id, login, mail, password, date_inscription, admin) FROM stdin;
2       testUser        user@blabla.fr  $2y$10$0DteVE/af.c0/Yk2dKHv1.H6i4CKM2bt.LhyRI287nvpTx8gs.RGO    2015-03-26      f
1       admin42 admin@admin.com $2y$10$bQlZa.E6X/9EUxC4Ok/C4O8LS/ZzjUeuGS27xRInJSEABPHVKCoQq    2015-03-26      t
\.


--
-- Name: Membre_id_seq; Type: SEQUENCE SET; Schema: public; Owner: cartong
--

SELECT pg_catalog.setval('"Membre_id_seq"', 9, true);


--
-- Data for Name: Systeme_projection; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Systeme_projection" ("ID", "EPSG", "Systeme_projection") FROM stdin;
1       6171 (système géocentrique), 4965 (3D), 4171 (2D)                                                                                                                                                                                                                                                                Réseau Géodésique Français 1993                                                                                                                                                                                                                                           
2       2D : 4807 (Paris, grade) ou 4275 (Greenwich, degré). 3D : 7400 (Paris, grade)                                                                                                                                                                                                                                    Nouvelle Triangulation Française                                                                                                                                                                                                                                          
3       4937 (3D), 4258(2D)                                                                                                                                                                                                                                                                                              European Terrestrial Reference System 1989                                                                                                                                                                                                                                
4       4230                                                                                                                                                                                                                                                                                                             European Datum 1950                                                                                                                                                                                                                                                       
5       4979 (3D), 4326 (2D)                                                                                                                                                                                                                                                                                             World Geodetic System 1984                                                                                                                                                                                                                                                
\.


--
-- Name: Systeme_projection_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: cartong
--

SELECT pg_catalog.setval('"Systeme_projection_ID_seq"', 44, true);


--
-- Data for Name: Thematique; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY "Thematique" ("ID", "Theme") FROM stdin;
7       POI                                                                                                                                                                                      
8       Images satellites                                                                                                                                                                        
10      Densité de population                                                                                                                                                                    
13      Santé                                                                                                                                                                                    
1       Decoupage administratif                                                                                                                                                                  
2       Hydrographie                                                                                                                                                                             
3       Transport                                                                                                                                                                                
4       Relief                                                                                                                                                                                   
5       Occupation du sol                                                                                                                                                                        
6       Population                                                                                                                                                                               
9       Radar                                                                                                                                                                                    
11      Ville                                                                                                                                                                                    
14      Développement                                                                                                                                                                            
15      Sécurité                                                                                                                                                                                 
16      Organisation                                                                                                                                                                             
20      Climat                                                                                                                                                                                   
\.


--
-- Name: Thematique_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: cartong
--

SELECT pg_catalog.setval('"Thematique_ID_seq"', 25, true);


--
-- Data for Name: vs_database_diagrams; Type: TABLE DATA; Schema: public; Owner: cartong
--

COPY vs_database_diagrams (name, diadata, comment, preview, lockinfo, locktime, version) FROM stdin;
htft    \N      \N      \N      postgres*0      2015-03-09 18:34:14.839617+00   \N
\.


--
-- Name: Echelle_pkey; Type: CONSTRAINT; Schema: public; Owner: cartong; Tablespace:
--

ALTER TABLE ONLY "Echelle"
    ADD CONSTRAINT "Echelle_pkey" PRIMARY KEY ("ID");


--
-- Name: Fournisseurs_donnees_pkey; Type: CONSTRAINT; Schema: public; Owner: cartong; Tablespace:
--

ALTER TABLE ONLY "Fournisseurs_donnees"
    ADD CONSTRAINT "Fournisseurs_donnees_pkey" PRIMARY KEY ("ID");


--
-- Name: ID; Type: CONSTRAINT; Schema: public; Owner: cartong; Tablespace:
--

ALTER TABLE ONLY "Thematique"
    ADD CONSTRAINT "ID" PRIMARY KEY ("ID");


--
-- Name: Localisation_pkey; Type: CONSTRAINT; Schema: public; Owner: cartong; Tablespace:
--

ALTER TABLE ONLY "Localisation"
    ADD CONSTRAINT "Localisation_pkey" PRIMARY KEY ("ID");


--
-- Name: Systeme_projection_pkey; Type: CONSTRAINT; Schema: public; Owner: cartong; Tablespace:
--

ALTER TABLE ONLY "Systeme_projection"
    ADD CONSTRAINT "Systeme_projection_pkey" PRIMARY KEY ("ID");


--
-- Name: membre_id; Type: CONSTRAINT; Schema: public; Owner: cartong; Tablespace:
--

ALTER TABLE ONLY "Membre"
    ADD CONSTRAINT membre_id PRIMARY KEY (id);


--
-- Name: unique_id; Type: CONSTRAINT; Schema: public; Owner: cartong; Tablespace:
--

ALTER TABLE ONLY "Commentaire"
    ADD CONSTRAINT unique_id PRIMARY KEY (id);


--
-- Name: index_id; Type: INDEX; Schema: public; Owner: cartong; Tablespace:
--

CREATE INDEX index_id ON "Commentaire" USING btree (id);


--
-- Name: index_id1; Type: INDEX; Schema: public; Owner: cartong; Tablespace:
--

CREATE INDEX index_id1 ON "Membre" USING btree (id);


--
-- Name: Commentaire_date; Type: TRIGGER; Schema: public; Owner: cartong
--

CREATE TRIGGER "Commentaire_date" BEFORE INSERT ON "Commentaire" FOR EACH ROW EXECUTE PROCEDURE add_date_on_comm();


--
-- Name: Fournisseurs_donneesTrg; Type: TRIGGER; Schema: public; Owner: cartong
--

CREATE TRIGGER "Fournisseurs_donneesTrg" BEFORE INSERT OR UPDATE ON "Fournisseurs_donnees" FOR EACH ROW EXECUTE PROCEDURE add_date_on_insert();


--
-- Name: Membre_date_inscription; Type: TRIGGER; Schema: public; Owner: cartong
--

CREATE TRIGGER "Membre_date_inscription" BEFORE INSERT ON "Membre" FOR EACH ROW EXECUTE PROCEDURE add_date_on_user_register();


--
-- Name: lnk_Commentaire_Fournisseurs_donnees; Type: FK CONSTRAINT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Commentaire"
    ADD CONSTRAINT "lnk_Commentaire_Fournisseurs_donnees" FOREIGN KEY (id_fournisseur) REFERENCES "Fournisseurs_donnees"("ID") MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: lnk_Commentaire_Membre; Type: FK CONSTRAINT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Commentaire"
    ADD CONSTRAINT "lnk_Commentaire_Membre" FOREIGN KEY (id_membre) REFERENCES "Membre"(id) MATCH FULL ON DELETE CASCADE;


--
-- Name: lnk_Fournisseur_localisation_Fournisseurs_donnees; Type: FK CONSTRAINT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Fournisseur_localisation"
    ADD CONSTRAINT "lnk_Fournisseur_localisation_Fournisseurs_donnees" FOREIGN KEY (id_fournisseur) REFERENCES "Fournisseurs_donnees"("ID") MATCH FULL;


--
-- Name: lnk_Fournisseur_localisation_Localisation; Type: FK CONSTRAINT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Fournisseur_localisation"
    ADD CONSTRAINT "lnk_Fournisseur_localisation_Localisation" FOREIGN KEY (id_localisation) REFERENCES "Localisation"("ID") MATCH FULL;


--
-- Name: lnk_Fournisseurs_donnees_Echelle; Type: FK CONSTRAINT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Fournisseurs_donnees"
    ADD CONSTRAINT "lnk_Fournisseurs_donnees_Echelle" FOREIGN KEY ("Echelle") REFERENCES "Echelle"("ID") MATCH FULL;


--
-- Name: lnk_Fournisseurs_donnees_Systeme_projection; Type: FK CONSTRAINT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Fournisseurs_donnees"
    ADD CONSTRAINT "lnk_Fournisseurs_donnees_Systeme_projection" FOREIGN KEY ("Systeme_projection") REFERENCES "Systeme_projection"("ID") MATCH FULL;


--
-- Name: lnk_Fournisseurs_thematique_Fournisseurs_donnees; Type: FK CONSTRAINT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Fournisseurs_thematique"
    ADD CONSTRAINT "lnk_Fournisseurs_thematique_Fournisseurs_donnees" FOREIGN KEY (id_fournisseur) REFERENCES "Fournisseurs_donnees"("ID") MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: lnk_Fournisseurs_thematique_Thematique; Type: FK CONSTRAINT; Schema: public; Owner: cartong
--

ALTER TABLE ONLY "Fournisseurs_thematique"
    ADD CONSTRAINT "lnk_Fournisseurs_thematique_Thematique" FOREIGN KEY (id_thematique) REFERENCES "Thematique"("ID") MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

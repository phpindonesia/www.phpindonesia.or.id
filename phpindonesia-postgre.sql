--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- Name: active; Type: TYPE; Schema: public; Owner: phpindonesia
--

CREATE TYPE active AS ENUM (
    'Y',
    'N'
);


ALTER TYPE public.active OWNER TO phpindonesia;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: album; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE album (
    id_album integer NOT NULL,
    title character varying(100) NOT NULL,
    seotitle character varying(100) NOT NULL,
    active character(1) DEFAULT 'Y'::bpchar NOT NULL
);


ALTER TABLE public.album OWNER TO phpindonesia;

--
-- Name: album_id_album_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE album_id_album_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.album_id_album_seq OWNER TO phpindonesia;

--
-- Name: album_id_album_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE album_id_album_seq OWNED BY album.id_album;


--
-- Name: album_id_album_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('album_id_album_seq', 2, true);


--
-- Name: category; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE category (
    id_category integer NOT NULL,
    title character varying(50) NOT NULL,
    seotitle character varying(100) NOT NULL,
    active character(1) DEFAULT 'Y'::bpchar NOT NULL
);


ALTER TABLE public.category OWNER TO phpindonesia;

--
-- Name: category_id_category_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE category_id_category_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.category_id_category_seq OWNER TO phpindonesia;

--
-- Name: category_id_category_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE category_id_category_seq OWNED BY category.id_category;


--
-- Name: category_id_category_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('category_id_category_seq', 1, false);


--
-- Name: comment; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE comment (
    id_comment integer NOT NULL,
    id_post integer NOT NULL,
    name character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    url character varying(100) NOT NULL,
    comment text NOT NULL,
    date date NOT NULL,
    "time" character varying(50) NOT NULL,
    active character(1) DEFAULT 'Y'::bpchar NOT NULL,
    status character(1) DEFAULT 'N'::bpchar NOT NULL
);


ALTER TABLE public.comment OWNER TO phpindonesia;

--
-- Name: comment_id_comment_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE comment_id_comment_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.comment_id_comment_seq OWNER TO phpindonesia;

--
-- Name: comment_id_comment_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE comment_id_comment_seq OWNED BY comment.id_comment;


--
-- Name: comment_id_comment_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('comment_id_comment_seq', 1, false);


--
-- Name: component; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE component (
    id_component integer NOT NULL,
    component character varying(100) NOT NULL,
    date date NOT NULL,
    table_name character varying(100) NOT NULL
);


ALTER TABLE public.component OWNER TO phpindonesia;

--
-- Name: component_id_component_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE component_id_component_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.component_id_component_seq OWNER TO phpindonesia;

--
-- Name: component_id_component_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE component_id_component_seq OWNED BY component.id_component;


--
-- Name: component_id_component_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('component_id_component_seq', 5, true);


--
-- Name: contact; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE contact (
    id_contact integer NOT NULL,
    name_contact character varying(100) NOT NULL,
    email_contact character varying(100) NOT NULL,
    subjek_contact character varying(100) NOT NULL,
    message_contact text NOT NULL,
    status character(1) DEFAULT 'N'::bpchar NOT NULL
);


ALTER TABLE public.contact OWNER TO phpindonesia;

--
-- Name: contact_id_contact_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE contact_id_contact_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.contact_id_contact_seq OWNER TO phpindonesia;

--
-- Name: contact_id_contact_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE contact_id_contact_seq OWNED BY contact.id_contact;


--
-- Name: contact_id_contact_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('contact_id_contact_seq', 1, true);


--
-- Name: event; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE event (
    id_event integer NOT NULL,
    title character varying(50) NOT NULL,
    start timestamp without time zone NOT NULL,
    "end" timestamp without time zone NOT NULL,
    allday character(255) DEFAULT 'true'::bpchar NOT NULL,
    content text NOT NULL,
    seotitle character varying(100) NOT NULL,
    color character varying(7) NOT NULL,
    active character(1) DEFAULT 'Y'::bpchar NOT NULL
);


ALTER TABLE public.event OWNER TO phpindonesia;

--
-- Name: event_id_event_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE event_id_event_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.event_id_event_seq OWNER TO phpindonesia;

--
-- Name: event_id_event_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE event_id_event_seq OWNED BY event.id_event;


--
-- Name: event_id_event_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('event_id_event_seq', 6, true);


--
-- Name: gallery; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE gallery (
    id_gallery integer NOT NULL,
    id_album integer NOT NULL,
    title character varying(100) NOT NULL,
    picture character varying(100) NOT NULL
);


ALTER TABLE public.gallery OWNER TO phpindonesia;

--
-- Name: gallery_id_gallery_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE gallery_id_gallery_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.gallery_id_gallery_seq OWNER TO phpindonesia;

--
-- Name: gallery_id_gallery_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE gallery_id_gallery_seq OWNED BY gallery.id_gallery;


--
-- Name: gallery_id_gallery_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('gallery_id_gallery_seq', 10, true);


--
-- Name: media; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE media (
    id_media integer NOT NULL,
    file_name character varying(100) NOT NULL,
    file_type character varying(50) NOT NULL,
    file_size character varying(50) NOT NULL,
    date date NOT NULL
);


ALTER TABLE public.media OWNER TO phpindonesia;

--
-- Name: media_id_media_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE media_id_media_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.media_id_media_seq OWNER TO phpindonesia;

--
-- Name: media_id_media_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE media_id_media_seq OWNED BY media.id_media;


--
-- Name: media_id_media_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('media_id_media_seq', 1, false);


--
-- Name: menu_id_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE menu_id_seq
    START WITH 29
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.menu_id_seq OWNER TO phpindonesia;

--
-- Name: menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('menu_id_seq', 29, true);


--
-- Name: menu; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE menu (
    id smallint DEFAULT nextval('menu_id_seq'::regclass) NOT NULL,
    parent_id smallint DEFAULT 0 NOT NULL,
    title character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    class character varying(255) NOT NULL,
    "position" smallint DEFAULT 0 NOT NULL,
    group_id smallint DEFAULT (1)::numeric NOT NULL
);


ALTER TABLE public.menu OWNER TO phpindonesia;

--
-- Name: menu_group; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE menu_group (
    id integer NOT NULL,
    title character varying(255) NOT NULL
);


ALTER TABLE public.menu_group OWNER TO phpindonesia;

--
-- Name: menu_group_id_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE menu_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.menu_group_id_seq OWNER TO phpindonesia;

--
-- Name: menu_group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE menu_group_id_seq OWNED BY menu_group.id;


--
-- Name: menu_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('menu_group_id_seq', 1, true);


--
-- Name: oauth; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE oauth (
    id_oauth integer NOT NULL,
    oauth_type character varying(10) NOT NULL,
    oauth_key text NOT NULL,
    oauth_secret text NOT NULL,
    oauth_id character varying(100) NOT NULL,
    oauth_user character varying(100) NOT NULL,
    oauth_token1 text NOT NULL,
    oauth_token2 text NOT NULL,
    oauth_fbtype character varying(10) NOT NULL
);


ALTER TABLE public.oauth OWNER TO phpindonesia;

--
-- Name: oauth_id_oauth_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE oauth_id_oauth_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.oauth_id_oauth_seq OWNER TO phpindonesia;

--
-- Name: oauth_id_oauth_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE oauth_id_oauth_seq OWNED BY oauth.id_oauth;


--
-- Name: oauth_id_oauth_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('oauth_id_oauth_seq', 2, true);


--
-- Name: pages; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE pages (
    id_pages integer NOT NULL,
    title character varying(100) NOT NULL,
    content text NOT NULL,
    seotitle character varying(100) NOT NULL,
    picture character varying(100) NOT NULL,
    active character(1) DEFAULT 'Y'::bpchar NOT NULL
);


ALTER TABLE public.pages OWNER TO phpindonesia;

--
-- Name: pages_id_pages_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE pages_id_pages_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pages_id_pages_seq OWNER TO phpindonesia;

--
-- Name: pages_id_pages_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE pages_id_pages_seq OWNED BY pages.id_pages;


--
-- Name: pages_id_pages_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('pages_id_pages_seq', 9, true);


--
-- Name: post; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE post (
    id_post integer NOT NULL,
    id_category character varying(10) NOT NULL,
    title character varying(100) NOT NULL,
    content text NOT NULL,
    seotitle character varying(100) NOT NULL,
    tag character varying(200) NOT NULL,
    date date NOT NULL,
    "time" time without time zone NOT NULL,
    editor character varying(100) DEFAULT '1'::character varying NOT NULL,
    active character(1) DEFAULT 'Y'::bpchar NOT NULL,
    headline character(1) DEFAULT 'N'::bpchar NOT NULL,
    picture character varying(100) NOT NULL,
    hits integer DEFAULT (1)::numeric NOT NULL
);


ALTER TABLE public.post OWNER TO phpindonesia;

--
-- Name: post_id_post_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE post_id_post_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.post_id_post_seq OWNER TO phpindonesia;

--
-- Name: post_id_post_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE post_id_post_seq OWNED BY post.id_post;


--
-- Name: post_id_post_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('post_id_post_seq', 1, false);


--
-- Name: setting; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE setting (
    id_setting integer NOT NULL,
    website_name character varying(100) NOT NULL,
    website_url character varying(100) NOT NULL,
    website_email character varying(100) NOT NULL,
    meta_description character varying(250) NOT NULL,
    meta_keyword character varying(250) NOT NULL,
    favicon character varying(50) NOT NULL,
    timezone character varying(50) NOT NULL,
    website_maintenance character(1) DEFAULT 'N'::bpchar NOT NULL,
    website_maintenance_tgl character varying(10) NOT NULL,
    website_cache character(1) DEFAULT 'N'::bpchar NOT NULL,
    website_cache_time character varying(10) NOT NULL,
    member_register character(1) DEFAULT 'Y'::bpchar NOT NULL
);


ALTER TABLE public.setting OWNER TO phpindonesia;

--
-- Name: setting_id_setting_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE setting_id_setting_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.setting_id_setting_seq OWNER TO phpindonesia;

--
-- Name: setting_id_setting_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE setting_id_setting_seq OWNED BY setting.id_setting;


--
-- Name: setting_id_setting_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('setting_id_setting_seq', 1, true);


--
-- Name: subscribe; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE subscribe (
    id_subscribe integer NOT NULL,
    email character varying(100) NOT NULL
);


ALTER TABLE public.subscribe OWNER TO phpindonesia;

--
-- Name: subscribe_id_subscribe_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE subscribe_id_subscribe_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subscribe_id_subscribe_seq OWNER TO phpindonesia;

--
-- Name: subscribe_id_subscribe_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE subscribe_id_subscribe_seq OWNED BY subscribe.id_subscribe;


--
-- Name: subscribe_id_subscribe_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('subscribe_id_subscribe_seq', 1, false);


--
-- Name: tag; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE tag (
    id_tag integer NOT NULL,
    tag_title character varying(100) NOT NULL,
    tag_seo character varying(100) NOT NULL,
    count integer NOT NULL
);


ALTER TABLE public.tag OWNER TO phpindonesia;

--
-- Name: tag_id_tag_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE tag_id_tag_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.tag_id_tag_seq OWNER TO phpindonesia;

--
-- Name: tag_id_tag_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE tag_id_tag_seq OWNED BY tag.id_tag;


--
-- Name: tag_id_tag_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('tag_id_tag_seq', 1, false);


--
-- Name: theme; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE theme (
    id_theme integer NOT NULL,
    title character varying(100) NOT NULL,
    author character varying(100) NOT NULL,
    folder character varying(100) NOT NULL,
    active character(1) DEFAULT 'N'::bpchar NOT NULL
);


ALTER TABLE public.theme OWNER TO phpindonesia;

--
-- Name: theme_id_theme_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE theme_id_theme_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.theme_id_theme_seq OWNER TO phpindonesia;

--
-- Name: theme_id_theme_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE theme_id_theme_seq OWNED BY theme.id_theme;


--
-- Name: theme_id_theme_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('theme_id_theme_seq', 1, true);


--
-- Name: traffic; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE traffic (
    ip character varying(20) NOT NULL,
    tanggal date NOT NULL,
    hits integer DEFAULT (1)::numeric NOT NULL,
    online character varying(255) NOT NULL
);


ALTER TABLE public.traffic OWNER TO phpindonesia;

--
-- Name: user_level; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE user_level (
    id_level integer NOT NULL,
    level character varying(100) NOT NULL
);


ALTER TABLE public.user_level OWNER TO phpindonesia;

--
-- Name: user_level_id_level_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE user_level_id_level_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.user_level_id_level_seq OWNER TO phpindonesia;

--
-- Name: user_level_id_level_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE user_level_id_level_seq OWNED BY user_level.id_level;


--
-- Name: user_level_id_level_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('user_level_id_level_seq', 3, true);


--
-- Name: user_role; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE user_role (
    id_role integer NOT NULL,
    id_level integer NOT NULL,
    module character varying(50) NOT NULL,
    read_access character(1) DEFAULT 'N'::bpchar NOT NULL,
    write_access character(1) DEFAULT 'N'::bpchar NOT NULL,
    modify_access character(1) DEFAULT 'N'::bpchar NOT NULL,
    delete_access character(1) DEFAULT 'N'::bpchar NOT NULL
);


ALTER TABLE public.user_role OWNER TO phpindonesia;

--
-- Name: user_role_id_role_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE user_role_id_role_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.user_role_id_role_seq OWNER TO phpindonesia;

--
-- Name: user_role_id_role_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE user_role_id_role_seq OWNED BY user_role.id_role;


--
-- Name: user_role_id_role_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('user_role_id_role_seq', 42, true);


--
-- Name: users; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE users (
    id_user integer NOT NULL,
    username character varying(50) NOT NULL,
    password character varying(50) NOT NULL,
    nama_lengkap character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    no_telp character varying(20) NOT NULL,
    bio text NOT NULL,
    userpicture character varying(100) NOT NULL,
    level character varying(20) DEFAULT '2'::character varying NOT NULL,
    blokir character(1) DEFAULT 'N'::bpchar NOT NULL,
    id_session character varying(100) NOT NULL,
    tgl_daftar date NOT NULL,
    forget_key character varying(100),
    locktype character varying(1) DEFAULT '0'::character varying NOT NULL
);


ALTER TABLE public.users OWNER TO phpindonesia;

--
-- Name: valbum; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE valbum (
    id_album integer NOT NULL,
    title character varying(100) NOT NULL,
    seotitle character varying(100) NOT NULL,
    active character(1) DEFAULT 'Y'::bpchar NOT NULL
);


ALTER TABLE public.valbum OWNER TO phpindonesia;

--
-- Name: valbum_id_album_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE valbum_id_album_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.valbum_id_album_seq OWNER TO phpindonesia;

--
-- Name: valbum_id_album_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE valbum_id_album_seq OWNED BY valbum.id_album;


--
-- Name: valbum_id_album_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('valbum_id_album_seq', 3, true);


--
-- Name: video; Type: TABLE; Schema: public; Owner: phpindonesia; Tablespace: 
--

CREATE TABLE video (
    id_video integer NOT NULL,
    id_album integer NOT NULL,
    title character varying(100) NOT NULL,
    url character varying(300) NOT NULL,
    picture character varying(100) NOT NULL
);


ALTER TABLE public.video OWNER TO phpindonesia;

--
-- Name: video_id_video_seq; Type: SEQUENCE; Schema: public; Owner: phpindonesia
--

CREATE SEQUENCE video_id_video_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.video_id_video_seq OWNER TO phpindonesia;

--
-- Name: video_id_video_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: phpindonesia
--

ALTER SEQUENCE video_id_video_seq OWNED BY video.id_video;


--
-- Name: video_id_video_seq; Type: SEQUENCE SET; Schema: public; Owner: phpindonesia
--

SELECT pg_catalog.setval('video_id_video_seq', 17, true);


--
-- Name: id_album; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY album ALTER COLUMN id_album SET DEFAULT nextval('album_id_album_seq'::regclass);


--
-- Name: id_category; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY category ALTER COLUMN id_category SET DEFAULT nextval('category_id_category_seq'::regclass);


--
-- Name: id_comment; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY comment ALTER COLUMN id_comment SET DEFAULT nextval('comment_id_comment_seq'::regclass);


--
-- Name: id_component; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY component ALTER COLUMN id_component SET DEFAULT nextval('component_id_component_seq'::regclass);


--
-- Name: id_contact; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY contact ALTER COLUMN id_contact SET DEFAULT nextval('contact_id_contact_seq'::regclass);


--
-- Name: id_event; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY event ALTER COLUMN id_event SET DEFAULT nextval('event_id_event_seq'::regclass);


--
-- Name: id_gallery; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY gallery ALTER COLUMN id_gallery SET DEFAULT nextval('gallery_id_gallery_seq'::regclass);


--
-- Name: id_media; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY media ALTER COLUMN id_media SET DEFAULT nextval('media_id_media_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY menu_group ALTER COLUMN id SET DEFAULT nextval('menu_group_id_seq'::regclass);


--
-- Name: id_oauth; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY oauth ALTER COLUMN id_oauth SET DEFAULT nextval('oauth_id_oauth_seq'::regclass);


--
-- Name: id_pages; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY pages ALTER COLUMN id_pages SET DEFAULT nextval('pages_id_pages_seq'::regclass);


--
-- Name: id_post; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY post ALTER COLUMN id_post SET DEFAULT nextval('post_id_post_seq'::regclass);


--
-- Name: id_setting; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY setting ALTER COLUMN id_setting SET DEFAULT nextval('setting_id_setting_seq'::regclass);


--
-- Name: id_subscribe; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY subscribe ALTER COLUMN id_subscribe SET DEFAULT nextval('subscribe_id_subscribe_seq'::regclass);


--
-- Name: id_tag; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY tag ALTER COLUMN id_tag SET DEFAULT nextval('tag_id_tag_seq'::regclass);


--
-- Name: id_theme; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY theme ALTER COLUMN id_theme SET DEFAULT nextval('theme_id_theme_seq'::regclass);


--
-- Name: id_level; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY user_level ALTER COLUMN id_level SET DEFAULT nextval('user_level_id_level_seq'::regclass);


--
-- Name: id_role; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY user_role ALTER COLUMN id_role SET DEFAULT nextval('user_role_id_role_seq'::regclass);


--
-- Name: id_album; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY valbum ALTER COLUMN id_album SET DEFAULT nextval('valbum_id_album_seq'::regclass);


--
-- Name: id_video; Type: DEFAULT; Schema: public; Owner: phpindonesia
--

ALTER TABLE ONLY video ALTER COLUMN id_video SET DEFAULT nextval('video_id_video_seq'::regclass);


--
-- Data for Name: album; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO album VALUES (1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm', 'Y');
INSERT INTO album VALUES (2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm', 'Y');


--
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--



--
-- Data for Name: comment; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--



--
-- Data for Name: component; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO component VALUES (1, 'po-contact', '2014-08-11', 'contact');
INSERT INTO component VALUES (2, 'po-gallery', '2014-08-11', 'gallery');
INSERT INTO component VALUES (3, 'po-comment', '2014-08-11', 'comment');
INSERT INTO component VALUES (4, 'po-video', '2015-07-05', 'video');
INSERT INTO component VALUES (5, 'po-event', '2015-07-05', 'event');


--
-- Data for Name: contact; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--



--
-- Data for Name: event; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO event VALUES (1, 'Hands-On YII Framework', '2012-04-14 08:00:00', '2012-04-14 12:00:00', 'false                                                                                                                                                                                                                                                          ', '&lt;p&gt;Hands-On YII Framework&lt;br /&gt;Saturday, April 14, 2012 at 8:00am&lt;br /&gt;D&#039;Best Fatmawati&lt;br /&gt;Jl. RS. Fatmawati 15, Jakarta, Indonesia 12420&lt;br /&gt;&lt;br /&gt;Melanjutkan PHP Gathering Maret 2012 lalu, PHP Indonesia Group Bekerjasama dengan Yii PHP Framework Pada tanggal 14 April 2012 akan mengadakan Workshop Yii Framework untuk 10 orang peserta, video streaming untuk 25 saluran dan video record untuk di jadikan video tutorial, Pemateri om @Peter Jack Kambey. Bagi Yang berminat silahkan melakukan Pendaftaran di sini :&lt;br /&gt;&lt;br /&gt;http://www.enterprisephpcenter.com/jobs/webinars-schedule/?ee=15&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang ingin datang langsung wajib membayar Rp.35.000. Biaya ini semata-mata hanya untuk konsumsi peserta dan pemateri. Cara pembayaran bisa dibayar langsung atau transfer ke rekening BCA saya sehari sebelum Acara Workshop.&lt;br /&gt;Bagi yang ingin transfer pembayaran untuk konsumsi di workshop bisa transfer langsung ke rekening BCA saya&lt;br /&gt;Norek : 2181617120&lt;br /&gt;a/n : AWALUDIN RAHMADI&lt;br /&gt;&lt;br /&gt;Adapun fasilitas yang disediakan hanya tempat dan dan koneksi internet. Sedangkan laptop bawa masing-masing.&lt;/p&gt;', 'handson-yii-framework', '1BBAE1', 'Y');
INSERT INTO event VALUES (2, 'Hands-On Code Igniter PHP Framework', '2012-04-21 09:00:00', '2012-04-21 16:00:00', 'false                                                                                                                                                                                                                                                          ', '&lt;p&gt;Hands-On Code Igniter PHP Framework&lt;br /&gt;Saturday, April 21, 2012 at 9:00am - 4:00pm&lt;br /&gt;D&#039;Best Fatmawati&lt;br /&gt;Jl. RS. Fatmawati 15, Jakarta, Indonesia 12420&lt;br /&gt;&lt;br /&gt;PHP Indonesia Group Bekerjasama dengan Group Code Igniter Framework Indonesia akan mengadakan Workshop Code Igniter PHP Framework.&lt;br /&gt;&lt;br /&gt;Tanggal : 21 April 2012&lt;br /&gt;Jam : 09.00-16.00&lt;br /&gt;Tempat : Basecamp PHP Indonesia, Kompleks Ruko Dbest Fatmawati Blok D18&lt;br /&gt;Pemateri : Gunawan Wibisono&lt;br /&gt;&lt;br /&gt;Peserta onsite hanya untuk 10 orang peserta, untuk yang online bisa via video streaming untuk 25 saluran dan video record untuk di jadikan video tutorial.&lt;br /&gt;&lt;br /&gt;Bagi Yang berminat silahkan melakukan Pendaftaran di sini :&lt;br /&gt;&lt;br /&gt;http://www.enterprisephpcenter.com/jobs/webinars-schedule/?ee=16&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang ingin datang langsung wajib membayar Rp.35.000. Biaya ini semata-mata hanya untuk konsumsi peserta dan pemateri. Cara pembayaran bisa dibayar langsung atau transfer ke rekening BCA saya sehari sebelum Acara Workshop.&lt;br /&gt;Bagi yang ingin transfer pembayaran untuk konsumsi di workshop bisa transfer langsung ke rekening BCA.&lt;br /&gt;Norek : 2181617120&lt;br /&gt;a/n : AWALUDIN RAHMADI&lt;br /&gt;&lt;br /&gt;Adapun fasilitas yang disediakan hanya tempat dan dan koneksi internet. Sedangkan laptop bawa masing2..&lt;br /&gt;&lt;br /&gt;NB : bagi yang sudah melakukan pembayaran via Transfer, harap mengrimkan konfirmasi via email ke alamat ini : awal@rynet.com.sg&lt;/p&gt;', 'handson-code-igniter-php-framework', '888', 'Y');
INSERT INTO event VALUES (3, 'BaseCamp PHP Indonesia Open House', '2012-04-21 00:00:00', '2012-04-22 00:00:00', 'true                                                                                                                                                                                                                                                           ', '&lt;p&gt;BaseCamp PHP Indonesia Open House&lt;br /&gt;April 21, 2012 - April 22, 2012&lt;br /&gt;Jl. RS Fatmawati No.15 Jakarta Selatan, Kompleks Ruko Golden Plaza(D&#039;Best) Blok D-18, LOTTE Mart Fatmawati&lt;br /&gt;&lt;br /&gt;Untuk menjalin keakraban sesama coder PHP Setiap hari sabtu dan minggu PHP Indonesia Group melaksanakan kegiatan Open House PHP Indonesia di basecamp Fatmawati mulai Pukul 10 Pagi hingga pukul 4 sore.&lt;br /&gt;&lt;br /&gt;Lokasi&lt;br /&gt;&lt;br /&gt;Kompleks Ruko Golden Plaza(D&#039;Best) Blok D-18&lt;br /&gt;Jl. RS Fatmawati No.15&lt;br /&gt;LOTTE Mart Fatmawati&lt;br /&gt;Jakarta 12420, INDONESIA&lt;br /&gt;Phone : +62-21-7506846 (Hanya Sabtu dan Minggu Pukul 10 Pagi hingga Pukul 4 Sore)&lt;br /&gt;&lt;br /&gt;&quot;ACARA INI TERRBUKA BAGI SEMUA ANGGOTA PHP INDONESIA GROUP&quot;&lt;/p&gt;', 'basecamp-php-indonesia-open-house', 'AF64CC', 'Y');
INSERT INTO event VALUES (4, 'PHP How To Program', '2012-04-22 10:00:00', '2012-04-22 16:00:00', 'false                                                                                                                                                                                                                                                          ', '&lt;p&gt;PHP How To Program&lt;br /&gt;Sunday, April 22, 2012 at 10:00am - 4:00pm&lt;br /&gt;D&#039;Best Fatmawati&lt;br /&gt;Jl. RS. Fatmawati 15, Jakarta, Indonesia 12420&lt;br /&gt;&lt;br /&gt;PHP Indonesia Group akan mengadakan Workshop PHP Basic. Workshop PHP Basic ini ditujukan bagi yang baru belajar tentang PHP.&lt;br /&gt;&lt;br /&gt;Tanggal : 22 April 2012&lt;br /&gt;Jam : 10.00-16.00&lt;br /&gt;Tempat : Basecamp PHP Indonesia, Kompleks Ruko Dbest Fatmawati Blok D18&lt;br /&gt;Pemateri : La Jayuhni Yarsyah&lt;br /&gt;&lt;br /&gt;Peserta onsite hanya untuk 10 orang peserta, untuk yang online bisa via video streaming untuk 25 saluran dan video record untuk di jadikan video tutorial.&lt;br /&gt;&lt;br /&gt;Bagi Yang berminat silahkan melakukan Pendaftaran di sini :&lt;br /&gt;&lt;br /&gt;http://www.enterprisephpcenter.com/jobs/webinars-schedule/?ee=17&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang ingin datang langsung wajib membayar Rp.35.000. Biaya ini semata-mata hanya untuk konsumsi peserta dan pemateri. Cara pembayaran bisa dibayar langsung atau transfer ke rekening BCA saya sehari sebelum Acara Workshop.&lt;br /&gt;Bagi yang ingin transfer pembayaran untuk konsumsi di workshop bisa transfer langsung ke rekening BCA.&lt;br /&gt;Norek : 2181617120&lt;br /&gt;a/n : AWALUDIN RAHMADI&lt;br /&gt;&lt;br /&gt;Adapun fasilitas yang disediakan hanya tempat dan dan koneksi internet. Sedangkan laptop bawa masing2..&lt;br /&gt;&lt;br /&gt;NB : bagi yang sudah melakukan pembayaran via Transfer, harap mengrimkan konfirmasi via email ke alamat ini : awal@rynet.com.sg&lt;/p&gt;', 'php-how-to-program', '46B7BF', 'Y');
INSERT INTO event VALUES (5, 'PHP Indonesia Gathering Pacitan Jawa Timur', '2012-04-29 09:00:00', '2012-04-29 17:00:00', 'false                                                                                                                                                                                                                                                          ', '&lt;p&gt;PHP Indonesia Gathering Pacitan Jawa Timur - April 2012&lt;br /&gt;Sunday, April 29, 2012 at 9:00am - 5:00pm&lt;br /&gt;JL. WALANDA MARAMIS NO.2 PACITAN, JAWA TIMUR&lt;br /&gt;&lt;br /&gt;PHP Indonesia Facebook Group Wilayah Pacitan Jawa Timur, akan mengadakan event Gathering / Kopi darat di untuk mempererat keakraban antara sesama member PHP Indonesia, mempertajam skill dan pengetahuan PHP, serta semakin mempopulerkan penggunaan PHP di Indonesia.&lt;br /&gt;&lt;br /&gt;Lokasi Acara di&lt;br /&gt;&lt;br /&gt;SMKN 2 PACITAN JL. WALANDA MARAMIS NO.2 PACITAN, JAWA TIMUR&lt;br /&gt;&lt;br /&gt;Event ini terselenggara atas kerja sama yang erat antara sesama member PHP Indonesia serta kolaborasi dengan corporate sponsors.&lt;br /&gt;&lt;br /&gt;Special Thanks to PT Microsoft Indonesia, Rhynet, Telkom Divre V Jawa Timur.&lt;br /&gt;&lt;br /&gt;Organizing Committee (more volunteers are welcome):&lt;br /&gt;- Eksa Aja&lt;br /&gt;- Krisno W Utomo&lt;br /&gt;- Sony A.K&lt;br /&gt;- Rama Yurindra&lt;br /&gt;- Luri Darmawan&lt;br /&gt;- Ridho Prasetya&lt;/p&gt;', 'php-indonesia-gathering-pacitan-jawa-timur', 'E67E22', 'Y');
INSERT INTO event VALUES (6, 'PHP Webservices', '2012-04-29 10:00:00', '2012-04-29 17:00:00', 'false                                                                                                                                                                                                                                                          ', '&lt;p&gt;PHP Webservices&lt;br /&gt;Sunday, April 29, 2012 at 10:00am - 4:00pm&lt;br /&gt;D&#039;Best Fatmawati&lt;br /&gt;Jl. RS. Fatmawati 15, Jakarta, Indonesia 12420&lt;br /&gt;&lt;br /&gt;PHP Indonesia Group akan mengadakan Workshop PHP webservices. Workshop ini menerangkan tentang bagaimana membuat Aplikasi berbasis Webservices dengan bahasa pemrograman PHP.&lt;br /&gt;&lt;br /&gt;Tanggal : 29 April 2012&lt;br /&gt;Jam : 10.00-16.00&lt;br /&gt;Tempat : Basecamp PHP Indonesia, Kompleks Ruko Dbest Fatmawati Blok D18&lt;br /&gt;Pemateri : Muchamad Rochim&lt;br /&gt;&lt;br /&gt;Peserta onsite hanya untuk 10 orang peserta, untuk yang online bisa via video streaming untuk 25 saluran dan video record untuk di jadikan video tutorial.&lt;br /&gt;&lt;br /&gt;Bagi Yang berminat silahkan melakukan Pendaftaran di sini :&lt;br /&gt;&lt;br /&gt;http://www.enterprisephpcenter.com/jobs/webinars-schedule/?ee=18&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang onsite wajib membayar Rp. 100.000, sedangkan yang ingin mengikutu online via webex tidak dipungut biaya. Peserta yang onsite akan mendapatkan Cemilan Coffe Break, Makan siang, Sertifikat Training, dan DVD Rekaman training.&lt;br /&gt;&lt;br /&gt;Cara pembayaran bisa dibayar langsung atau transfer ke rekening BCA saya sehari sebelum Acara Workshop. Bagi yang ingin transfer pembayaran untuk konsumsi di workshop bisa transfer langsung ke rekening BCA.&lt;br /&gt;Norek : 2181617120&lt;br /&gt;a/n : AWALUDIN RAHMADI&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang sudah bayar harap segera mengkonfirmasi pembayarannya dengan mengirimkan konfimasi pembayaran ke, awal@rynet.com.sg.&lt;br /&gt;&lt;br /&gt;Adapun fasilitas yang disediakan hanya tempat dan dan koneksi internet. Sedangkan laptop bawa masing-masing.&lt;/p&gt;', 'php-webservices', '1EC1B8', 'Y');


--
-- Data for Name: gallery; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO gallery VALUES (1, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-5.jpg');
INSERT INTO gallery VALUES (2, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-4.jpg');
INSERT INTO gallery VALUES (3, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-3.jpg');
INSERT INTO gallery VALUES (4, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-2.jpg');
INSERT INTO gallery VALUES (5, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-1.jpg');
INSERT INTO gallery VALUES (6, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-5.jpg');
INSERT INTO gallery VALUES (7, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-4.jpg');
INSERT INTO gallery VALUES (8, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-3.jpg');
INSERT INTO gallery VALUES (9, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-2.jpg');
INSERT INTO gallery VALUES (10, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-1.jpg');


--
-- Data for Name: media; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--



--
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO menu VALUES (1, 0, 'Home', './', '', 1, 1);
INSERT INTO menu VALUES (2, 0, 'Tentang Kami', 'pages/tentang-kami', 'menu-item-simple-parent', 2, 1);
INSERT INTO menu VALUES (3, 2, 'Struktur Organisasi', 'pages/struktur-organisasi', '', 3, 1);
INSERT INTO menu VALUES (4, 2, 'Sejarah', 'pages/sejarah', '', 2, 1);
INSERT INTO menu VALUES (5, 2, 'Kepengurusan', 'pages/kepengurusan', '', 4, 1);
INSERT INTO menu VALUES (6, 0, 'Program Kerja', 'pages/program-kerja', 'menu-item-simple-parent', 3, 1);
INSERT INTO menu VALUES (7, 6, 'Nasional', 'pages/program-kerja-nasional', '', 1, 1);
INSERT INTO menu VALUES (8, 6, 'Daerah', 'pages/program-kerja-daerah', '', 2, 1);
INSERT INTO menu VALUES (9, 0, 'Dokumen', 'pages/ad-art', 'menu-item-simple-parent', 4, 1);
INSERT INTO menu VALUES (19, 9, 'AD/ART', 'pages/ad-art', '', 1, 1);
INSERT INTO menu VALUES (20, 9, 'Surat Keputusan', 'pages/surat-keputusan', '', 2, 1);
INSERT INTO menu VALUES (21, 0, 'Galeri', 'album', 'menu-item-simple-parent', 5, 1);
INSERT INTO menu VALUES (22, 21, 'Photo', 'album', '', 1, 1);
INSERT INTO menu VALUES (23, 21, 'Video', 'valbum', '', 2, 1);
INSERT INTO menu VALUES (24, 0, 'Kontak', 'contact', '', 6, 1);
INSERT INTO menu VALUES (26, 9, 'Event', 'listevent', '', 3, 1);


--
-- Data for Name: menu_group; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO menu_group VALUES (1, 'Main Menu');


--
-- Data for Name: oauth; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO oauth VALUES (1, 'facebook', '', '', '', '', '', '', '');
INSERT INTO oauth VALUES (2, 'twitter', '', '', '', '', '', '', '');


--
-- Data for Name: pages; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO pages VALUES (1, 'Tentang Kami', '&lt;p&gt;PHP Indonesia adalah komunitas pemrogram berbasis Bahasa Scripting PHP yang pertama kali disusun oleh Rasmus Lerdorf kemudian dikembangkan oleh Zeev Surasky dan Andy Gutzman dengan interpreteur Zend Engines, serta dikembangkan oleh anggota komunitas dari seluruh dunia. Untuk saat ini, bahasa scripting PHP merupakan salah satu bahasa pemrograman berbasis web yang sangat popular, sehubungan dengan trend bisnis saat ini yang cenderung menggunakan aplikasi berbasis web.&lt;br /&gt;&lt;br /&gt;Pada awalnya PHP Indonesia merupakan sebuah Group diskusi online di facebook yang dibuat pada tanggal 8 Februari 2008 oleh Sonny Arlianto Kurniawan, atas usulan Rama Yurindra pada tanggal 6 Februari 2008 disebuah Caf&amp;eacute; di kemang.&lt;br /&gt;&lt;br /&gt;Pada tanggal 31 Maret 2012 bertempat di Auditorium PT Microsoft Gedung BEJ II lt 19, Jakarta, diadakan Gathering anggota yang menjadi salah satu tonggak sejarah penting komunitas PHP Indonesia. Pada pertemuan ini, bertemu para anggota yang memiliki passion untuk lebih mengembangkan komunitas PHP Indonesia tidak hanya sebatas group diskusi online, akan tetapi menyusun struktur organisasi dengan membentuk perwakilan PHP Indonesia diseluruh kota Indonesia yang semuanya dilaksanakan oleh anggota komunitas ini yang memiliki spirit dan passion yang sama. Sejak tahun 2012 hingga tahun 2015 telah terbentuk perwakilan komunitas PHP Indonesia hingga di 14 Provinsi.&lt;br /&gt;&lt;br /&gt;Dalam aktivitasnya, perwakilan PHP Indonesia, secara periodik melakukan Meet Up, Gathering, Workshop, atau seminar, baik bekerja sama dengan Institusi kampus pendidikan tinggi, bekerja sama dengan komunitas IT lainnya, dan bantuan dari perusahaan-perusahaan berbasis telekomunikasi. Sedang di Jakarta, aktivitas komunitas PHP Indonesia cukup banyak mendapat dukungan dari perusahaan IT Multi Nasional seperti PT Microsoft Indonesia, PT IBM Indonesia, Detik.com, perusahaan e-commerce seperti Ezytravel.co,id serta lembaga nirlaba lainnya seperti GEPI (Global Entrepreneur Program Incubator), dan lain-lain.&lt;br /&gt;&lt;br /&gt;Perkembangan anggota diskusi online berkembang sangat pesat, pada awal Juni 2015 telah bergabung lebih dari 81.000 anggota.&amp;nbsp; Banyak anggota serta kenyataan begitu banyak anggota yang memiliki latar belakang keahlian pemrograman dari berbagai bahasa pemrograman serta keahlian tekhnologi informasi lainnya, seperti teknologi jaringan dan multimedia, pada akhirnya komunitas PHP Indonesia tidak lagi khusus bagi pemrogram PHP, akan tetapi sudah menjadi rumah besar bagi komunitas IT nasional. Sehingga group PHP Indonesia di Facebook merupakan group IT di Indonesia yang terbesar dan teraktif di media social Facebook.&lt;/p&gt;

&lt;p&gt;&amp;nbsp;&lt;/p&gt;

&lt;p style=&quot;text-align: center; font-size: 18px;&quot;&gt;&lt;strong&gt;VISI :&lt;/strong&gt;&lt;br /&gt;PHP Indonesia bermaksud menghimpun, mendorong meningkatkan dan memanfaatkan potensi segenap pihak yang bergerak di bidang Pemrograman PHP dan Pemrograman lainnya yang mendukung, untuk mewujudkan suatu kondisi yang saling melengkapi dalam rangka pencapaian tujuan PHP Indonesia.&lt;br /&gt;&lt;br /&gt;&lt;strong&gt;MISI :&lt;/strong&gt;&lt;br /&gt;PHP Indonesia bertujuan menumbuhkan, mengembangkan dan meningkatkan keahlian, produktivitas, profesionalisme, peningkatan daya saing untuk pemenuhan pasar piranti lunak nasional dalam rangka pembangunan bangsa dan negara, melalui sumber daya pemrogram berbasis PHP dalam lingkup nasional, dan meningkatkan kesejahteraan anggota.&lt;/p&gt;', 'tentang-kami', '', 'Y');
INSERT INTO pages VALUES (2, 'Sejarah', '&lt;p&gt;Pada awalnya PHP Indonesia merupakan sebuah Group diskusi online di facebook yang dibuat pada tanggal 8 Februari 2008 oleh Sonny Arlianto Kurniawan, atas usulan Rama Yurindra pada tanggal 6 Februari 2008 disebuah Caf&amp;eacute; di kemang.&lt;br /&gt;&lt;br /&gt;Pada tanggal 31 Maret 2012 bertempat di Auditorium PT Microsoft Gedung BEJ II lt 19, Jakarta, diadakan Gathering anggota yang menjadi salah satu tonggak sejarah penting komunitas PHP Indonesia. Pada pertemuan ini, bertemu para anggota yang memiliki passion untuk lebih mengembangkan komunitas PHP Indonesia tidak hanya sebatas group diskusi online, akan tetapi menyusun struktur organisasi dengan membentuk perwakilan PHP Indonesia diseluruh kota Indonesia yang semuanya dilaksanakan oleh anggota komunitas ini yang memiliki spirit dan passion yang sama. Sejak tahun 2012 hingga tahun 2015 telah terbentuk perwakilan komunitas PHP Indonesia hingga di 14 Provinsi.&lt;/p&gt;', 'sejarah', '', 'Y');
INSERT INTO pages VALUES (5, 'Program Kerja', '&lt;p&gt;Program Kerja PHP Indonesia mencakup namun tidak terbatas pada :&lt;/p&gt;

&lt;ol&gt;

&lt;li&gt;Mengupayakan peningkatan kemampuan dan profesionalisme para anggota dalam menghadapi kemajuan ilmu pengetahuan, teknologi dan perdagangan di bidang telematika khususnya dibidang yang berkaitan dengan pemrograman PHP dalam bentuk pelaksaan seminar, gathering, meetup, workshop dan bentuk edukasi lainnya.&lt;/li&gt;

&lt;li&gt;Membina dan mempererat hubungan kerjasama dengan organisasi, lembaga-lembaga profesional dan perorangan di bidang telematika, baik di dalam maupun di luar negeri, dengan tujuan pengakuan profesi di pasar lokal ataupun internasional yang pada akhirnya akan berimbas pada peningkatan posisi tawar dalam pasar software nasional baik berbasis web ataupun tidak berbasis web.&lt;/li&gt;

&lt;li&gt;PHP Indonesia akan menginisiasi segala aktivitas yang akan meningkatkan posisi tawar pemrogram yang berprofesi sebagai pengembang aplikasi berbasis PHP, untuk tujuan peningkatan kesejahteraan anggota dalam bentuk mengupayakan NOTA KESEPAHAMAN dengan Vendor yang menerbitkan sertfikasi profesi, ataupun harga khusus untuk produk-produk software pendukung kinerja pemrograman dan bentuk-bentuk NOTA KESEPAHAMAN lainnya yang dapat meningkatkan posisi tawar dan taraf kesejahteraan anggota.&lt;/li&gt;

&lt;li&gt;PHP Indonesia akan menginisiasi segala aktivitas yang berkaitan dengan pembentukan kelompok kerja yang akan mengarah pada usaha bersama (mutual corporate) dari para anggota yang berprofesi sebagai free lancer, pembinaan dan pendampingan dari sisi manajemen, bantuan pemasaran dan bantuan hukum bagi anggotanya sehingga di harapkan tumbuh usaha-usaha piranti lunak profesional dan kolegatif.&lt;/li&gt;

&lt;li&gt;Menghindari konflik antar anggota yang berkaitan dengan perebutan pasar PHP Develeper dengan jalan menumbuhkan semangat kolegatif dan pemetaan pasar.&lt;/li&gt;

&lt;/ol&gt;', 'program-kerja', '', 'Y');
INSERT INTO pages VALUES (6, 'Program Kerja Nasional', '&lt;div class=&quot;error-info&quot;&gt;

&lt;h2&gt;Content Under Construction&lt;/h2&gt;

&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;

&lt;/div&gt;', 'program-kerja-nasional', '', 'Y');
INSERT INTO pages VALUES (7, 'Program Kerja Daerah', '&lt;div class=&quot;error-info&quot;&gt;

&lt;h2&gt;Content Under Construction&lt;/h2&gt;

&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;

&lt;/div&gt;', 'program-kerja-daerah', '', 'Y');
INSERT INTO pages VALUES (8, 'AD/ART', '&lt;div class=&quot;error-info&quot;&gt;

&lt;h2&gt;Content Under Construction&lt;/h2&gt;

&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;

&lt;/div&gt;', 'ad-art', '', 'Y');
INSERT INTO pages VALUES (9, 'Surat Keputusan', '&lt;div class=&quot;error-info&quot;&gt;

&lt;h2&gt;Content Under Construction&lt;/h2&gt;

&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;

&lt;/div&gt;', 'surat-keputusan', '', 'Y');
INSERT INTO pages VALUES (3, 'Struktur Organisasi', '&lt;div class=&quot;banner&quot;&gt;&lt;img class=&quot;struktur-org&quot; src=&quot;http://www.phpindonesia.or.id/po-content/po-upload/struktur-organisasi.jpg&quot; alt=&quot;Struktur Organisasi&quot; /&gt;&lt;/div&gt;', 'struktur-organisasi', '', 'Y');
INSERT INTO pages VALUES (4, 'Kepengurusan', '&lt;div class=&quot;error-info&quot;&gt;
&lt;h2&gt;Content Under Construction&lt;/h2&gt;
&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;
&lt;/div&gt;', 'kepengurusan', '', 'Y');


--
-- Data for Name: post; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--



--
-- Data for Name: setting; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO setting VALUES (1, 'PHP Indonesia  Bersama Berkarya Berjaya', 'http://www.phpindonesia.or.id', 'info@phpindonesia.or.id', 'PHP Indonesia is a community for everyone that loves PHP. Our focus is in the PHP world but our topics encompass the entire LAMP stack. Topics include PHP coding, to memcached handling, db optimizations, server stack, web server tuning, code deployin', 'popojicms, website popojicms, cms indonesia, cms terbaik indonesia, cms gratis, cms gratis indonesia, alternatif cms', 'favicon.png', 'Asia/Jakarta', 'N', '', 'N', '', 'Y');


--
-- Data for Name: subscribe; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--



--
-- Data for Name: tag; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--



--
-- Data for Name: theme; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO theme VALUES (1, 'PHP Indonesia', 'Dwira Survivor', 'phpindo', 'Y');


--
-- Data for Name: traffic; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO traffic VALUES ('::1', '2015-07-07', 21, '1436286905');
INSERT INTO traffic VALUES ('::1', '2015-07-08', 37, '1436290073');
INSERT INTO traffic VALUES ('::1', '2015-07-10', 134, '1436546133');
INSERT INTO traffic VALUES ('::1', '2015-07-11', 169, '1436605980');
INSERT INTO traffic VALUES ('202.62.17.127', '2015-07-11', 13, '1436612623');
INSERT INTO traffic VALUES ('36.84.1.132', '2015-07-11', 1, '1436614288');
INSERT INTO traffic VALUES ('202.62.16.118', '2015-07-11', 26, '1436616915');


--
-- Data for Name: user_level; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO user_level VALUES (1, 'admin');
INSERT INTO user_level VALUES (2, 'user');
INSERT INTO user_level VALUES (3, 'member');


--
-- Data for Name: user_role; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO user_role VALUES (1, 1, 'post', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (2, 1, 'category', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (3, 1, 'tag', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (4, 1, 'pages', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (5, 1, 'library', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (6, 1, 'setting', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (7, 1, 'theme', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (8, 1, 'menumanager', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (9, 1, 'component', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (10, 1, 'user', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (11, 1, 'comment', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (12, 1, 'gallery', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (13, 1, 'contact', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (14, 1, 'cogen', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (15, 2, 'post', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (16, 2, 'category', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (17, 2, 'tag', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (18, 2, 'pages', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (19, 2, 'library', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (20, 2, 'setting', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (21, 2, 'theme', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (22, 2, 'menumanager', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (23, 2, 'component', 'Y', 'N', 'N', 'N');
INSERT INTO user_role VALUES (24, 2, 'user', 'Y', 'N', 'Y', 'N');
INSERT INTO user_role VALUES (25, 2, 'comment', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (26, 2, 'gallery', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (27, 2, 'contact', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (28, 2, 'cogen', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (29, 3, 'post', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (30, 3, 'category', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (31, 3, 'tag', 'Y', 'Y', 'Y', 'Y');
INSERT INTO user_role VALUES (32, 3, 'pages', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (33, 3, 'library', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (34, 3, 'setting', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (35, 3, 'theme', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (36, 3, 'menumanager', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (37, 3, 'component', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (38, 3, 'user', 'Y', 'N', 'Y', 'N');
INSERT INTO user_role VALUES (39, 3, 'comment', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (40, 3, 'gallery', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (41, 3, 'contact', 'N', 'N', 'N', 'N');
INSERT INTO user_role VALUES (42, 3, 'cogen', 'N', 'N', 'N', 'N');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO users VALUES (1, 'admweb', 'dfb607a9ad39b8b9af500ae128d18f42', 'Administrator', 'info@phpindonesia.or.id', '08xxxxxxxxxx', 'No matter how exciting or significant a person''s life is, a poorly written biography will make it seem like a snore. On the other hand, a good biographer can draw insight from an ordinary life-because they recognize that even the most exciting life is an ordinary life! After all, a biography isn''t supposed to be a collection of facts assembled in chronological order; it''s the biographer''s interpretation of how that life was different and important.', '', '1', 'N', 'hqer32viqgn9n0qeikhnndbvd4', '2015-07-04', NULL, '0');


--
-- Data for Name: valbum; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO valbum VALUES (1, 'PHP Webinar', 'php-webinar', 'Y');
INSERT INTO valbum VALUES (2, 'PHP Indonesia Event Depok', 'php-indonesia-event-depok', 'Y');
INSERT INTO valbum VALUES (3, 'PHP Indonesia Event Jakarta', 'php-indonesia-event-jakarta', 'Y');


--
-- Data for Name: video; Type: TABLE DATA; Schema: public; Owner: phpindonesia
--

INSERT INTO video VALUES (1, 1, 'Pengenalan PHP di IBM i Bagian 2', 'https://www.youtube.com/embed/iZ0Aywi0rvg', 'php-webinar.jpg');
INSERT INTO video VALUES (2, 1, 'Pengenalan PHP di IBM i Bagian 1', 'https://www.youtube.com/embed/mRsHfJX_IA0', 'php-webinar.jpg');
INSERT INTO video VALUES (3, 1, 'PHP Indonesia With NoSQL Indonesia', 'https://www.youtube.com/embed/mI06K4e-X5c', 'php-webinar.jpg');
INSERT INTO video VALUES (4, 1, 'EPHPC Webinar', 'https://www.youtube.com/embed/GyGyobbY3b8', 'php-webinar.jpg');
INSERT INTO video VALUES (5, 2, 'Code Igniter Crash Course - Breaking The Frameworks', 'https://www.youtube.com/embed/D2sYZvmoDfc', 'php-indonesia-event-depok.jpg');
INSERT INTO video VALUES (6, 3, 'Mengemas Website dengan Harga Layak', 'https://www.youtube.com/embed/GFXSdvqLyno', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (7, 3, 'Women Technopreneurs', 'https://www.youtube.com/embed/gRORkht4QYs', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (8, 3, 'Profesionalisme PHP Indonesia', 'https://www.youtube.com/embed/vE2YaIAZtL8', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (9, 3, 'IBM i Power PHP Indonesia on IBM', 'https://www.youtube.com/embed/joZucxcwB1U', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (10, 3, 'ERP Application PHP Indonesia on IBM', 'https://www.youtube.com/embed/XtVxMqv6p5M', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (11, 3, 'Opening PHP Indonesia on IBM', 'https://www.youtube.com/embed/8XzbjLDXrPM', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (12, 3, 'Optimize PHP Application in High Traffic Environment', 'https://www.youtube.com/embed/0bjpJCggyT4', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (13, 3, 'Ask &amp; Question PHP Indonesia Special Event', 'https://www.youtube.com/embed/7VtkbphDtTs', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (14, 3, 'Introducing AKSI IDE Editor on Yii', 'https://www.youtube.com/embed/1wYgIHdGofU', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (15, 3, 'What New on Yii 2', 'https://www.youtube.com/embed/dZpn34rmtzk', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (16, 3, 'Azure Cloud Platform', 'https://www.youtube.com/embed/YgoGkPepxgs', 'php-indonesia-event-jakarta.jpg');
INSERT INTO video VALUES (17, 3, 'All About PHP Indonesia Community', 'https://www.youtube.com/embed/g93znrO6uaM', 'php-indonesia-event-jakarta.jpg');


--
-- Name: album_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY album
    ADD CONSTRAINT album_pkey PRIMARY KEY (id_album);


--
-- Name: category_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY category
    ADD CONSTRAINT category_pkey PRIMARY KEY (id_category);


--
-- Name: comment_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY comment
    ADD CONSTRAINT comment_pkey PRIMARY KEY (id_comment);


--
-- Name: component_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY component
    ADD CONSTRAINT component_pkey PRIMARY KEY (id_component);


--
-- Name: contact_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY contact
    ADD CONSTRAINT contact_pkey PRIMARY KEY (id_contact);


--
-- Name: event_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY event
    ADD CONSTRAINT event_pkey PRIMARY KEY (id_event);


--
-- Name: gallery_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY gallery
    ADD CONSTRAINT gallery_pkey PRIMARY KEY (id_gallery);


--
-- Name: media_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_pkey PRIMARY KEY (id_media);


--
-- Name: menu_group_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY menu_group
    ADD CONSTRAINT menu_group_pkey PRIMARY KEY (id);


--
-- Name: menu_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (id);


--
-- Name: oauth_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY oauth
    ADD CONSTRAINT oauth_pkey PRIMARY KEY (id_oauth);


--
-- Name: pages_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id_pages);


--
-- Name: post_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_pkey PRIMARY KEY (id_post);


--
-- Name: setting_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY setting
    ADD CONSTRAINT setting_pkey PRIMARY KEY (id_setting);


--
-- Name: subscribe_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY subscribe
    ADD CONSTRAINT subscribe_pkey PRIMARY KEY (id_subscribe);


--
-- Name: tag_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY tag
    ADD CONSTRAINT tag_pkey PRIMARY KEY (id_tag);


--
-- Name: theme_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY theme
    ADD CONSTRAINT theme_pkey PRIMARY KEY (id_theme);


--
-- Name: user_level_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY user_level
    ADD CONSTRAINT user_level_pkey PRIMARY KEY (id_level);


--
-- Name: user_role_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY user_role
    ADD CONSTRAINT user_role_pkey PRIMARY KEY (id_role);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (username);


--
-- Name: valbum_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY valbum
    ADD CONSTRAINT valbum_pkey PRIMARY KEY (id_album);


--
-- Name: video_pkey; Type: CONSTRAINT; Schema: public; Owner: phpindonesia; Tablespace: 
--

ALTER TABLE ONLY video
    ADD CONSTRAINT video_pkey PRIMARY KEY (id_video);


--
-- PostgreSQL database dump complete
--


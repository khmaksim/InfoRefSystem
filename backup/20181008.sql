--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.6
-- Dumped by pg_dump version 9.6.6

-- Started on 2018-10-08 09:24:51

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2688 (class 1262 OID 16393)
-- Dependencies: 2687
-- Name: isys-db; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE "isys-db" IS 'database for ISSZGT app';


--
-- TOC entry 4 (class 2615 OID 17002)
-- Name: access; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA access;


ALTER SCHEMA access OWNER TO postgres;

--
-- TOC entry 1 (class 3079 OID 12387)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2690 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 277 (class 1255 OID 16394)
-- Name: attached_ad(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION attached_ad() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
   if EXISTS(select distinct loid from pg_largeobject WHERE loid=OLD.lo)=true then
	PERFORM lo_unlink(OLD.lo);
   end if;
   return OLD;
end;
$$;


ALTER FUNCTION public.attached_ad() OWNER TO postgres;

--
-- TOC entry 278 (class 1255 OID 16395)
-- Name: controlnotes(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION controlnotes(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
declare
	cur_rec controlstages%rowtype;
	query text;
	res_txt text;
begin
	res_txt := '';
	query := 'select * from controlstages where control='||$1::text||' order by notedate;';
	for cur_rec in execute query loop
		res_txt := res_txt || to_char(cur_rec.notedate, 'DD.MM.YYYY') || ' ' || cur_rec.note || chr(13)||chr(10);
	end loop;
	return res_txt;
end;
$_$;


ALTER FUNCTION public.controlnotes(integer) OWNER TO postgres;

--
-- TOC entry 279 (class 1255 OID 16396)
-- Name: controls_ad(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION controls_ad() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
   insert into freenumbers (number, depart) values (OLD.number, 2);
   delete from controlstages where control = OLD.code;
   update incomings set control=0 where code=OLD.incoming;	
   return OLD;
end;
$$;


ALTER FUNCTION public.controls_ad() OWNER TO postgres;

--
-- TOC entry 280 (class 1255 OID 16397)
-- Name: controls_n(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION controls_n() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
        notify controls;
	return old;
end;
$$;


ALTER FUNCTION public.controls_n() OWNER TO postgres;

--
-- TOC entry 281 (class 1255 OID 16398)
-- Name: incomings_ad(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION incomings_ad() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
   insert into freenumbers (number, depart) values (OLD.number_in, CASE WHEN old.grif < 2 THEN 0 ELSE 1 END);
   delete from attached where incoming=OLD.code;
   return OLD;
end;
$$;


ALTER FUNCTION public.incomings_ad() OWNER TO postgres;

--
-- TOC entry 282 (class 1255 OID 16399)
-- Name: incomings_n(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION incomings_n() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
        notify incomings;
	return old;
end;
$$;


ALTER FUNCTION public.incomings_n() OWNER TO postgres;

--
-- TOC entry 295 (class 1255 OID 16400)
-- Name: new_number(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION new_number(integer) RETURNS character varying
    LANGUAGE plpgsql SECURITY DEFINER
    AS $_$
declare
	cur_rec freenumbers%rowtype;
	minNumber text;
	query text;
	deleteResult integer;
begin
	minNumber:=NULL;
	for cur_rec in select code, number, depart from freenumbers where depart=$1 order by number loop
		query:='delete from freenumbers where code='||cur_rec.code::text||';';
		execute query;
		GET DIAGNOSTICS deleteResult = ROW_COUNT;
		if deleteResult > 0 then
			minNumber:=cur_rec.number;
			EXIT;
		end if;
	end loop;
	if minNumber is NULL then
           if $1=0 then
		minNumber:='Н-'||nextval('number_in_ns_seq')::text;
	   elsif $1=1 then
		minNumber:='П-'||nextval('number_in_s_seq')::text;
           elsif $1=2 then	
		minNumber:='К-'||nextval('number_control_seq')::text;
           elsif $1=3 then	
		minNumber:=nextval('number_out_ns_seq')::text;
           end if;
	end if;
	return minNumber;
end;
$_$;


ALTER FUNCTION public.new_number(integer) OWNER TO postgres;

--
-- TOC entry 296 (class 1255 OID 16401)
-- Name: out_attached_ad(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION out_attached_ad() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
   if EXISTS(select distinct loid from pg_largeobject WHERE loid=OLD.lo)=true then
	PERFORM lo_unlink(OLD.lo);
   end if;
   return OLD;
end;
$$;


ALTER FUNCTION public.out_attached_ad() OWNER TO postgres;

--
-- TOC entry 297 (class 1255 OID 16402)
-- Name: outgoings_ad(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION outgoings_ad() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
   insert into freenumbers (number, depart) values (OLD.number_in, 3);
   delete from out_attached where outgoing=OLD.code;
   return OLD;
end;
$$;


ALTER FUNCTION public.outgoings_ad() OWNER TO postgres;

--
-- TOC entry 298 (class 1255 OID 16403)
-- Name: outgoings_n(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION outgoings_n() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
        notify outgoings;
	return old;
end;
$$;


ALTER FUNCTION public.outgoings_n() OWNER TO postgres;

--
-- TOC entry 299 (class 1255 OID 16404)
-- Name: plpgsql_call_handler(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION plpgsql_call_handler() RETURNS language_handler
    LANGUAGE c
    AS '$libdir/plpgsql', 'plpgsql_call_handler';


ALTER FUNCTION public.plpgsql_call_handler() OWNER TO postgres;

SET search_path = access, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 265 (class 1259 OID 17016)
-- Name: access_right; Type: TABLE; Schema: access; Owner: postgres
--

CREATE TABLE access_right (
    id integer NOT NULL,
    oid_table integer NOT NULL,
    access_mask integer NOT NULL,
    id_role integer NOT NULL
);


ALTER TABLE access_right OWNER TO postgres;

--
-- TOC entry 264 (class 1259 OID 17014)
-- Name: access_right_id_seq; Type: SEQUENCE; Schema: access; Owner: postgres
--

CREATE SEQUENCE access_right_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE access_right_id_seq OWNER TO postgres;

--
-- TOC entry 2691 (class 0 OID 0)
-- Dependencies: 264
-- Name: access_right_id_seq; Type: SEQUENCE OWNED BY; Schema: access; Owner: postgres
--

ALTER SEQUENCE access_right_id_seq OWNED BY access_right.id;


--
-- TOC entry 269 (class 1259 OID 17047)
-- Name: group; Type: TABLE; Schema: access; Owner: postgres
--

CREATE TABLE "group" (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE "group" OWNER TO postgres;

--
-- TOC entry 268 (class 1259 OID 17045)
-- Name: group_id_seq; Type: SEQUENCE; Schema: access; Owner: postgres
--

CREATE SEQUENCE group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE group_id_seq OWNER TO postgres;

--
-- TOC entry 2692 (class 0 OID 0)
-- Dependencies: 268
-- Name: group_id_seq; Type: SEQUENCE OWNED BY; Schema: access; Owner: postgres
--

ALTER SEQUENCE group_id_seq OWNED BY "group".id;


--
-- TOC entry 271 (class 1259 OID 17058)
-- Name: group_role; Type: TABLE; Schema: access; Owner: postgres
--

CREATE TABLE group_role (
    id integer NOT NULL,
    id_role integer NOT NULL,
    id_group integer NOT NULL
);


ALTER TABLE group_role OWNER TO postgres;

--
-- TOC entry 270 (class 1259 OID 17056)
-- Name: group_role_id_seq; Type: SEQUENCE; Schema: access; Owner: postgres
--

CREATE SEQUENCE group_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE group_role_id_seq OWNER TO postgres;

--
-- TOC entry 2693 (class 0 OID 0)
-- Dependencies: 270
-- Name: group_role_id_seq; Type: SEQUENCE OWNED BY; Schema: access; Owner: postgres
--

ALTER SEQUENCE group_role_id_seq OWNED BY group_role.id;


--
-- TOC entry 263 (class 1259 OID 17005)
-- Name: role; Type: TABLE; Schema: access; Owner: postgres
--

CREATE TABLE role (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE role OWNER TO postgres;

--
-- TOC entry 262 (class 1259 OID 17003)
-- Name: role_id_seq; Type: SEQUENCE; Schema: access; Owner: postgres
--

CREATE SEQUENCE role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE role_id_seq OWNER TO postgres;

--
-- TOC entry 2694 (class 0 OID 0)
-- Dependencies: 262
-- Name: role_id_seq; Type: SEQUENCE OWNED BY; Schema: access; Owner: postgres
--

ALTER SEQUENCE role_id_seq OWNED BY role.id;


--
-- TOC entry 273 (class 1259 OID 17076)
-- Name: user_group; Type: TABLE; Schema: access; Owner: postgres
--

CREATE TABLE user_group (
    id integer NOT NULL,
    id_user integer NOT NULL,
    id_group integer NOT NULL
);


ALTER TABLE user_group OWNER TO postgres;

--
-- TOC entry 272 (class 1259 OID 17074)
-- Name: user_group_id_seq; Type: SEQUENCE; Schema: access; Owner: postgres
--

CREATE SEQUENCE user_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_group_id_seq OWNER TO postgres;

--
-- TOC entry 2695 (class 0 OID 0)
-- Dependencies: 272
-- Name: user_group_id_seq; Type: SEQUENCE OWNED BY; Schema: access; Owner: postgres
--

ALTER SEQUENCE user_group_id_seq OWNED BY user_group.id;


--
-- TOC entry 267 (class 1259 OID 17029)
-- Name: user_role; Type: TABLE; Schema: access; Owner: postgres
--

CREATE TABLE user_role (
    id integer NOT NULL,
    id_role integer NOT NULL,
    id_user integer NOT NULL
);


ALTER TABLE user_role OWNER TO postgres;

--
-- TOC entry 266 (class 1259 OID 17027)
-- Name: user_role_id_seq; Type: SEQUENCE; Schema: access; Owner: postgres
--

CREATE SEQUENCE user_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_role_id_seq OWNER TO postgres;

--
-- TOC entry 2696 (class 0 OID 0)
-- Dependencies: 266
-- Name: user_role_id_seq; Type: SEQUENCE OWNED BY; Schema: access; Owner: postgres
--

ALTER SEQUENCE user_role_id_seq OWNED BY user_role.id;


SET search_path = public, pg_catalog;

--
-- TOC entry 186 (class 1259 OID 16405)
-- Name: access_right; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE access_right (
    user_id integer NOT NULL,
    admin integer NOT NULL,
    omu integer NOT NULL,
    kadr integer NOT NULL,
    telephone integer NOT NULL,
    incoming integer NOT NULL
);


ALTER TABLE access_right OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 16408)
-- Name: access_right_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE access_right_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE access_right_id_seq OWNER TO postgres;

--
-- TOC entry 2697 (class 0 OID 0)
-- Dependencies: 187
-- Name: access_right_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE access_right_id_seq OWNED BY access_right.user_id;


SET default_with_oids = true;

--
-- TOC entry 228 (class 1259 OID 16600)
-- Name: access_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE access_type (
    id integer NOT NULL,
    name text,
    deleted timestamp with time zone
);


ALTER TABLE access_type OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 16609)
-- Name: address_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE address_type (
    id integer NOT NULL,
    name character varying(255),
    deleted timestamp with time zone
);


ALTER TABLE address_type OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16410)
-- Name: addressees; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE addressees (
    code integer NOT NULL,
    short_name text NOT NULL,
    address text,
    note text
);


ALTER TABLE addressees OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 16416)
-- Name: addressees_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE addressees_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE addressees_code_seq OWNER TO postgres;

--
-- TOC entry 2700 (class 0 OID 0)
-- Dependencies: 189
-- Name: addressees_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE addressees_code_seq OWNED BY addressees.code;


SET default_with_oids = false;

--
-- TOC entry 190 (class 1259 OID 16418)
-- Name: antibrutforce; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE antibrutforce (
    id_user integer NOT NULL,
    col integer,
    unban integer,
    deleted timestamp with time zone
);


ALTER TABLE antibrutforce OWNER TO postgres;

SET default_with_oids = true;

--
-- TOC entry 191 (class 1259 OID 16421)
-- Name: attached; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE attached (
    code integer NOT NULL,
    incoming integer NOT NULL,
    lo oid,
    filename text,
    note text,
    mime character varying(255)
);


ALTER TABLE attached OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 16427)
-- Name: attached_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE attached_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE attached_code_seq OWNER TO postgres;

--
-- TOC entry 2701 (class 0 OID 0)
-- Dependencies: 192
-- Name: attached_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE attached_code_seq OWNED BY attached.code;


--
-- TOC entry 232 (class 1259 OID 16615)
-- Name: city; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE city (
    id integer NOT NULL,
    name character varying(255),
    deleted timestamp with time zone
);


ALTER TABLE city OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 16429)
-- Name: controls; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE controls (
    code integer NOT NULL,
    number text NOT NULL,
    incoming integer NOT NULL,
    number_ud text,
    number_ctrl_ud text,
    datecontrol_ud date,
    orderer text,
    datecontrol date NOT NULL,
    datedone date,
    executor text
);


ALTER TABLE controls OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 16448)
-- Name: controls_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE controls_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE controls_code_seq OWNER TO postgres;

--
-- TOC entry 2703 (class 0 OID 0)
-- Dependencies: 195
-- Name: controls_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE controls_code_seq OWNED BY controls.code;


--
-- TOC entry 196 (class 1259 OID 16450)
-- Name: controlstages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE controlstages (
    code integer NOT NULL,
    control integer NOT NULL,
    notedate date NOT NULL,
    note text
);


ALTER TABLE controlstages OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 16456)
-- Name: controlstages_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE controlstages_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE controlstages_code_seq OWNER TO postgres;

--
-- TOC entry 2704 (class 0 OID 0)
-- Dependencies: 197
-- Name: controlstages_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE controlstages_code_seq OWNED BY controlstages.code;


--
-- TOC entry 198 (class 1259 OID 16458)
-- Name: department; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE department (
    id integer NOT NULL,
    fullname text NOT NULL,
    shortname text,
    dep_index text,
    server_addr text,
    note text,
    parent integer DEFAULT 0 NOT NULL,
    active boolean,
    deleted timestamp with time zone
);


ALTER TABLE department OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 16466)
-- Name: departments_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE departments_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE departments_code_seq OWNER TO postgres;

--
-- TOC entry 2705 (class 0 OID 0)
-- Dependencies: 199
-- Name: departments_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE departments_code_seq OWNED BY department.id;


SET default_with_oids = false;

--
-- TOC entry 200 (class 1259 OID 16468)
-- Name: document; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE document (
    name text NOT NULL,
    section text,
    file_name character varying,
    id integer NOT NULL,
    deleted timestamp with time zone
);


ALTER TABLE document OWNER TO postgres;

--
-- TOC entry 274 (class 1259 OID 25194)
-- Name: document_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE document_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE document_id_seq OWNER TO postgres;

--
-- TOC entry 2706 (class 0 OID 0)
-- Dependencies: 274
-- Name: document_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE document_id_seq OWNED BY document.id;


SET default_with_oids = true;

--
-- TOC entry 235 (class 1259 OID 16623)
-- Name: email; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE email (
    id integer NOT NULL,
    id_person integer,
    name character varying(255),
    editable boolean DEFAULT true NOT NULL
);


ALTER TABLE email OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 16629)
-- Name: email_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE email_type (
    id integer NOT NULL,
    name character varying(255),
    deleted timestamp with time zone
);


ALTER TABLE email_type OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 201 (class 1259 OID 16476)
-- Name: enterprise; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE enterprise (
    id integer NOT NULL,
    name text NOT NULL,
    location text,
    head text,
    post text,
    deleted timestamp with time zone
);


ALTER TABLE enterprise OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 16482)
-- Name: enterprise_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE enterprise_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE enterprise_id_seq OWNER TO postgres;

--
-- TOC entry 2709 (class 0 OID 0)
-- Dependencies: 202
-- Name: enterprise_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE enterprise_id_seq OWNED BY enterprise.id;


SET default_with_oids = true;

--
-- TOC entry 203 (class 1259 OID 16484)
-- Name: executors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE executors (
    code integer NOT NULL,
    uname text NOT NULL,
    surname text,
    name text,
    patronymic text,
    birthdate date,
    post text,
    department integer,
    contacts text NOT NULL,
    note text
);


ALTER TABLE executors OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 16490)
-- Name: executors_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE executors_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE executors_code_seq OWNER TO postgres;

--
-- TOC entry 2710 (class 0 OID 0)
-- Dependencies: 204
-- Name: executors_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE executors_code_seq OWNED BY executors.code;


--
-- TOC entry 205 (class 1259 OID 16492)
-- Name: folders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE folders (
    code integer NOT NULL,
    number integer NOT NULL,
    subject text,
    date_from date,
    date_to date
);


ALTER TABLE folders OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 16498)
-- Name: folders_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE folders_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE folders_code_seq OWNER TO postgres;

--
-- TOC entry 2711 (class 0 OID 0)
-- Dependencies: 206
-- Name: folders_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE folders_code_seq OWNED BY folders.code;


--
-- TOC entry 207 (class 1259 OID 16500)
-- Name: freenumbers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE freenumbers (
    code integer NOT NULL,
    number text NOT NULL,
    depart integer NOT NULL
);


ALTER TABLE freenumbers OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 16506)
-- Name: freenumbers_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE freenumbers_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE freenumbers_code_seq OWNER TO postgres;

--
-- TOC entry 2712 (class 0 OID 0)
-- Dependencies: 208
-- Name: freenumbers_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE freenumbers_code_seq OWNED BY freenumbers.code;


--
-- TOC entry 194 (class 1259 OID 16435)
-- Name: incoming_document; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE incoming_document (
    id integer NOT NULL,
    number_in text NOT NULL,
    date_registration date NOT NULL,
    number_primary text,
    date_primary date,
    senders_numbers text,
    security_label integer DEFAULT 0 NOT NULL,
    number_sheets text,
    copies integer DEFAULT 1,
    copies_numbers text,
    subject text,
    "order" text,
    instructions text,
    note text,
    control integer,
    out_where text,
    out_details text,
    out_date date,
    deleted timestamp with time zone
);


ALTER TABLE incoming_document OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 16508)
-- Name: incomings_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE incomings_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE incomings_code_seq OWNER TO postgres;

--
-- TOC entry 2713 (class 0 OID 0)
-- Dependencies: 209
-- Name: incomings_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE incomings_code_seq OWNED BY incoming_document.id;


--
-- TOC entry 241 (class 1259 OID 16640)
-- Name: interpassport_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE interpassport_type (
    id integer NOT NULL,
    name text,
    deleted timestamp with time zone
);


ALTER TABLE interpassport_type OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 16649)
-- Name: medal_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE medal_type (
    id integer NOT NULL,
    name text,
    deleted timestamp with time zone
);


ALTER TABLE medal_type OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 16664)
-- Name: military_rank; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE military_rank (
    id integer NOT NULL,
    name character varying(255),
    deleted timestamp with time zone
);


ALTER TABLE military_rank OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 16537)
-- Name: number_control_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE number_control_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE number_control_seq OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 16539)
-- Name: number_in_ns_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE number_in_ns_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE number_in_ns_seq OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 16541)
-- Name: number_in_s_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE number_in_s_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE number_in_s_seq OWNER TO postgres;

--
-- TOC entry 213 (class 1259 OID 16543)
-- Name: number_out_ns_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE number_out_ns_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE number_out_ns_seq OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 214 (class 1259 OID 16545)
-- Name: object_kii; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE object_kii (
    id integer NOT NULL,
    name_kvito text NOT NULL,
    reg_number text,
    certificate text,
    "order" text,
    id_department integer NOT NULL
);


ALTER TABLE object_kii OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16551)
-- Name: objects_kii_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE objects_kii_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE objects_kii_id_seq OWNER TO postgres;

--
-- TOC entry 2717 (class 0 OID 0)
-- Dependencies: 215
-- Name: objects_kii_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE objects_kii_id_seq OWNED BY object_kii.id;


SET default_with_oids = true;

--
-- TOC entry 216 (class 1259 OID 16553)
-- Name: operators; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE operators (
    code integer NOT NULL,
    uname text NOT NULL,
    surname text,
    name text,
    patronymic text,
    note text
);


ALTER TABLE operators OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16559)
-- Name: operators_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE operators_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE operators_code_seq OWNER TO postgres;

--
-- TOC entry 2718 (class 0 OID 0)
-- Dependencies: 217
-- Name: operators_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE operators_code_seq OWNED BY operators.code;


--
-- TOC entry 218 (class 1259 OID 16561)
-- Name: out_attached; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE out_attached (
    code integer NOT NULL,
    outgoing integer NOT NULL,
    lo oid,
    filename text,
    note text
);


ALTER TABLE out_attached OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16567)
-- Name: out_attached_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE out_attached_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE out_attached_code_seq OWNER TO postgres;

--
-- TOC entry 2719 (class 0 OID 0)
-- Dependencies: 219
-- Name: out_attached_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE out_attached_code_seq OWNED BY out_attached.code;


--
-- TOC entry 220 (class 1259 OID 16569)
-- Name: out_copies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE out_copies (
    code integer NOT NULL,
    outgoing integer NOT NULL,
    copy_number integer,
    addressee integer,
    folder integer,
    note text
);


ALTER TABLE out_copies OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16575)
-- Name: out_copies_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE out_copies_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE out_copies_code_seq OWNER TO postgres;

--
-- TOC entry 2720 (class 0 OID 0)
-- Dependencies: 221
-- Name: out_copies_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE out_copies_code_seq OWNED BY out_copies.code;


--
-- TOC entry 222 (class 1259 OID 16577)
-- Name: outgoings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE outgoings (
    code integer NOT NULL,
    number_out text NOT NULL,
    date_out date NOT NULL,
    subject text NOT NULL,
    notes text,
    grif integer DEFAULT 0 NOT NULL,
    init_number text,
    init_date date,
    init_type integer,
    department integer NOT NULL,
    executor integer,
    executor_fio text NOT NULL,
    executor_contacts text NOT NULL,
    sheets text,
    copies text
);


ALTER TABLE outgoings OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16584)
-- Name: outgoings_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE outgoings_code_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE outgoings_code_seq OWNER TO postgres;

--
-- TOC entry 2721 (class 0 OID 0)
-- Dependencies: 223
-- Name: outgoings_code_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE outgoings_code_seq OWNED BY outgoings.code;


--
-- TOC entry 249 (class 1259 OID 16670)
-- Name: person; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE person (
    id integer NOT NULL,
    firstname text,
    lastname text,
    patronymic text,
    military boolean,
    personal_number text,
    birthday date,
    id_access_type integer,
    id_unit integer,
    id_military_rank integer,
    img_ext character varying(4),
    address text,
    id_city integer,
    note text,
    deleted timestamp with time zone
);


ALTER TABLE person OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 16679)
-- Name: phone_number; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE phone_number (
    id integer NOT NULL,
    id_person integer NOT NULL,
    id_phone_number_type integer NOT NULL,
    deleted timestamp with time zone,
    number character varying NOT NULL
);


ALTER TABLE phone_number OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 253 (class 1259 OID 16685)
-- Name: phone_number_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE phone_number_type (
    id integer NOT NULL,
    name character varying(255),
    deleted timestamp with time zone
);


ALTER TABLE phone_number_type OWNER TO postgres;

SET default_with_oids = true;

--
-- TOC entry 245 (class 1259 OID 16658)
-- Name: position; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "position" (
    id integer NOT NULL,
    name character varying(255),
    deleted timestamp with time zone
);


ALTER TABLE "position" OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 224 (class 1259 OID 16586)
-- Name: product; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE product (
    id integer NOT NULL,
    index character(30) NOT NULL,
    cipher character(50),
    description text,
    image_file_name text,
    deleted timestamp with time zone,
    creator text,
    security_label character varying(20)
);


ALTER TABLE product OWNER TO postgres;

--
-- TOC entry 2725 (class 0 OID 0)
-- Dependencies: 224
-- Name: COLUMN product.creator; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN product.creator IS 'Разработчик';


--
-- TOC entry 2726 (class 0 OID 0)
-- Dependencies: 224
-- Name: COLUMN product.security_label; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN product.security_label IS 'Гриф обрабатываемой информации';


--
-- TOC entry 225 (class 1259 OID 16592)
-- Name: product_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE product_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE product_id_seq OWNER TO postgres;

--
-- TOC entry 2727 (class 0 OID 0)
-- Dependencies: 225
-- Name: product_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE product_id_seq OWNED BY product.id;


--
-- TOC entry 226 (class 1259 OID 16594)
-- Name: role; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE role (
    id integer NOT NULL,
    title character varying(255),
    editable boolean DEFAULT true NOT NULL
);


ALTER TABLE role OWNER TO postgres;

--
-- TOC entry 2728 (class 0 OID 0)
-- Dependencies: 226
-- Name: TABLE role; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE role IS 'The role of security in the system';


--
-- TOC entry 227 (class 1259 OID 16598)
-- Name: role_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE role_id_seq OWNER TO postgres;

--
-- TOC entry 2729 (class 0 OID 0)
-- Dependencies: 227
-- Name: role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE role_id_seq OWNED BY role.id;


--
-- TOC entry 276 (class 1259 OID 33393)
-- Name: scientific_research_design_work; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE scientific_research_design_work (
    id integer NOT NULL,
    year integer NOT NULL,
    file_name character varying,
    deleted timestamp with time zone
);


ALTER TABLE scientific_research_design_work OWNER TO postgres;

--
-- TOC entry 2730 (class 0 OID 0)
-- Dependencies: 276
-- Name: TABLE scientific_research_design_work; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE scientific_research_design_work IS 'НИОКР';


--
-- TOC entry 275 (class 1259 OID 33391)
-- Name: scientific_research_design_work_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE scientific_research_design_work_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE scientific_research_design_work_id_seq OWNER TO postgres;

--
-- TOC entry 2731 (class 0 OID 0)
-- Dependencies: 275
-- Name: scientific_research_design_work_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE scientific_research_design_work_id_seq OWNED BY scientific_research_design_work.id;


--
-- TOC entry 229 (class 1259 OID 16607)
-- Name: taccesstype_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE taccesstype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE taccesstype_id_seq OWNER TO postgres;

--
-- TOC entry 2732 (class 0 OID 0)
-- Dependencies: 229
-- Name: taccesstype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE taccesstype_id_seq OWNED BY access_type.id;


--
-- TOC entry 231 (class 1259 OID 16613)
-- Name: taddresstype_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE taddresstype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE taddresstype_id_seq OWNER TO postgres;

--
-- TOC entry 2733 (class 0 OID 0)
-- Dependencies: 231
-- Name: taddresstype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE taddresstype_id_seq OWNED BY address_type.id;


--
-- TOC entry 233 (class 1259 OID 16619)
-- Name: tcity_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tcity_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tcity_id_seq OWNER TO postgres;

--
-- TOC entry 2734 (class 0 OID 0)
-- Dependencies: 233
-- Name: tcity_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tcity_id_seq OWNED BY city.id;


SET default_with_oids = true;

--
-- TOC entry 255 (class 1259 OID 16697)
-- Name: technique; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE technique (
    id integer DEFAULT nextval('departments_code_seq'::regclass) NOT NULL,
    fullname text NOT NULL,
    shortname text,
    id_department integer,
    deleted timestamp with time zone
);


ALTER TABLE technique OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 16621)
-- Name: technique_code_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE technique_code_seq
    START WITH 11
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE technique_code_seq OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 16627)
-- Name: temail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE temail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE temail_id_seq OWNER TO postgres;

--
-- TOC entry 2735 (class 0 OID 0)
-- Dependencies: 236
-- Name: temail_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE temail_id_seq OWNED BY email.id;


--
-- TOC entry 238 (class 1259 OID 16633)
-- Name: temailtype_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE temailtype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE temailtype_id_seq OWNER TO postgres;

--
-- TOC entry 2736 (class 0 OID 0)
-- Dependencies: 238
-- Name: temailtype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE temailtype_id_seq OWNED BY email_type.id;


SET default_with_oids = false;

--
-- TOC entry 239 (class 1259 OID 16635)
-- Name: test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE test (
    id integer NOT NULL,
    tipo character varying(255),
    images integer
);


ALTER TABLE test OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 16638)
-- Name: test_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE test_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE test_id_seq OWNER TO postgres;

--
-- TOC entry 2737 (class 0 OID 0)
-- Dependencies: 240
-- Name: test_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE test_id_seq OWNED BY test.id;


--
-- TOC entry 242 (class 1259 OID 16647)
-- Name: tinterpassporttype_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tinterpassporttype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tinterpassporttype_id_seq OWNER TO postgres;

--
-- TOC entry 2738 (class 0 OID 0)
-- Dependencies: 242
-- Name: tinterpassporttype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tinterpassporttype_id_seq OWNED BY interpassport_type.id;


--
-- TOC entry 244 (class 1259 OID 16656)
-- Name: tmedaltype_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tmedaltype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tmedaltype_id_seq OWNER TO postgres;

--
-- TOC entry 2739 (class 0 OID 0)
-- Dependencies: 244
-- Name: tmedaltype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tmedaltype_id_seq OWNED BY medal_type.id;


--
-- TOC entry 246 (class 1259 OID 16662)
-- Name: tmilitaryposition_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tmilitaryposition_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tmilitaryposition_id_seq OWNER TO postgres;

--
-- TOC entry 2740 (class 0 OID 0)
-- Dependencies: 246
-- Name: tmilitaryposition_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tmilitaryposition_id_seq OWNED BY "position".id;


--
-- TOC entry 248 (class 1259 OID 16668)
-- Name: tmilitaryrank_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tmilitaryrank_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tmilitaryrank_id_seq OWNER TO postgres;

--
-- TOC entry 2741 (class 0 OID 0)
-- Dependencies: 248
-- Name: tmilitaryrank_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tmilitaryrank_id_seq OWNED BY military_rank.id;


--
-- TOC entry 250 (class 1259 OID 16677)
-- Name: tperson_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tperson_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tperson_id_seq OWNER TO postgres;

--
-- TOC entry 2742 (class 0 OID 0)
-- Dependencies: 250
-- Name: tperson_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tperson_id_seq OWNED BY person.id;


--
-- TOC entry 252 (class 1259 OID 16683)
-- Name: tphone_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tphone_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tphone_id_seq OWNER TO postgres;

--
-- TOC entry 2743 (class 0 OID 0)
-- Dependencies: 252
-- Name: tphone_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tphone_id_seq OWNED BY phone_number.id;


--
-- TOC entry 254 (class 1259 OID 16689)
-- Name: tphonenumbertype_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tphonenumbertype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tphonenumbertype_id_seq OWNER TO postgres;

--
-- TOC entry 2744 (class 0 OID 0)
-- Dependencies: 254
-- Name: tphonenumbertype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tphonenumbertype_id_seq OWNED BY phone_number_type.id;


--
-- TOC entry 256 (class 1259 OID 16704)
-- Name: unit; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE unit (
    id integer NOT NULL,
    id_military_rank integer,
    id_position integer,
    id_department integer,
    id_access_type integer,
    order_number character varying,
    order_owner character varying,
    tariff_category integer,
    dateorderstart date,
    dateorderend date,
    vacant boolean DEFAULT true NOT NULL,
    deleted timestamp with time zone
);


ALTER TABLE unit OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 16712)
-- Name: tunit_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tunit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tunit_id_seq OWNER TO postgres;

--
-- TOC entry 2745 (class 0 OID 0)
-- Dependencies: 257
-- Name: tunit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tunit_id_seq OWNED BY unit.id;


--
-- TOC entry 258 (class 1259 OID 16714)
-- Name: user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "user" (
    id integer NOT NULL,
    role_id integer,
    active boolean DEFAULT true,
    title character varying(255),
    bdate timestamp with time zone,
    adate timestamp with time zone,
    img_ext character varying(4),
    name character varying(255) NOT NULL,
    passwd character varying(255) NOT NULL,
    deleted timestamp with time zone
);


ALTER TABLE "user" OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 16722)
-- Name: user_action; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE user_action (
    user_id integer,
    adate timestamp with time zone,
    title character varying(255)
);


ALTER TABLE user_action OWNER TO postgres;

--
-- TOC entry 260 (class 1259 OID 16725)
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_id_seq OWNER TO postgres;

--
-- TOC entry 2746 (class 0 OID 0)
-- Dependencies: 260
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- TOC entry 261 (class 1259 OID 16727)
-- Name: user_login; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE user_login (
    user_id integer,
    success boolean,
    ldate timestamp with time zone
);


ALTER TABLE user_login OWNER TO postgres;

SET search_path = access, pg_catalog;

--
-- TOC entry 2350 (class 2604 OID 17019)
-- Name: access_right id; Type: DEFAULT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY access_right ALTER COLUMN id SET DEFAULT nextval('access_right_id_seq'::regclass);


--
-- TOC entry 2352 (class 2604 OID 17050)
-- Name: group id; Type: DEFAULT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY "group" ALTER COLUMN id SET DEFAULT nextval('group_id_seq'::regclass);


--
-- TOC entry 2353 (class 2604 OID 17061)
-- Name: group_role id; Type: DEFAULT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY group_role ALTER COLUMN id SET DEFAULT nextval('group_role_id_seq'::regclass);


--
-- TOC entry 2349 (class 2604 OID 17008)
-- Name: role id; Type: DEFAULT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY role ALTER COLUMN id SET DEFAULT nextval('role_id_seq'::regclass);


--
-- TOC entry 2354 (class 2604 OID 17079)
-- Name: user_group id; Type: DEFAULT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY user_group ALTER COLUMN id SET DEFAULT nextval('user_group_id_seq'::regclass);


--
-- TOC entry 2351 (class 2604 OID 17032)
-- Name: user_role id; Type: DEFAULT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY user_role ALTER COLUMN id SET DEFAULT nextval('user_role_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- TOC entry 2330 (class 2604 OID 16749)
-- Name: access_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY access_type ALTER COLUMN id SET DEFAULT nextval('taccesstype_id_seq'::regclass);


--
-- TOC entry 2331 (class 2604 OID 16750)
-- Name: address_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY address_type ALTER COLUMN id SET DEFAULT nextval('taddresstype_id_seq'::regclass);


--
-- TOC entry 2307 (class 2604 OID 16730)
-- Name: addressees code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY addressees ALTER COLUMN code SET DEFAULT nextval('addressees_code_seq'::regclass);


--
-- TOC entry 2308 (class 2604 OID 16731)
-- Name: attached code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY attached ALTER COLUMN code SET DEFAULT nextval('attached_code_seq'::regclass);


--
-- TOC entry 2332 (class 2604 OID 16751)
-- Name: city id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY city ALTER COLUMN id SET DEFAULT nextval('tcity_id_seq'::regclass);


--
-- TOC entry 2309 (class 2604 OID 16732)
-- Name: controls code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY controls ALTER COLUMN code SET DEFAULT nextval('controls_code_seq'::regclass);


--
-- TOC entry 2313 (class 2604 OID 16733)
-- Name: controlstages code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY controlstages ALTER COLUMN code SET DEFAULT nextval('controlstages_code_seq'::regclass);


--
-- TOC entry 2315 (class 2604 OID 16752)
-- Name: department id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY department ALTER COLUMN id SET DEFAULT nextval('departments_code_seq'::regclass);


--
-- TOC entry 2316 (class 2604 OID 25203)
-- Name: document id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY document ALTER COLUMN id SET DEFAULT nextval('document_id_seq'::regclass);


--
-- TOC entry 2334 (class 2604 OID 16753)
-- Name: email id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY email ALTER COLUMN id SET DEFAULT nextval('temail_id_seq'::regclass);


--
-- TOC entry 2335 (class 2604 OID 16754)
-- Name: email_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY email_type ALTER COLUMN id SET DEFAULT nextval('temailtype_id_seq'::regclass);


--
-- TOC entry 2317 (class 2604 OID 16735)
-- Name: enterprise id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY enterprise ALTER COLUMN id SET DEFAULT nextval('enterprise_id_seq'::regclass);


--
-- TOC entry 2318 (class 2604 OID 16736)
-- Name: executors code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY executors ALTER COLUMN code SET DEFAULT nextval('executors_code_seq'::regclass);


--
-- TOC entry 2319 (class 2604 OID 16737)
-- Name: folders code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY folders ALTER COLUMN code SET DEFAULT nextval('folders_code_seq'::regclass);


--
-- TOC entry 2320 (class 2604 OID 16738)
-- Name: freenumbers code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY freenumbers ALTER COLUMN code SET DEFAULT nextval('freenumbers_code_seq'::regclass);


--
-- TOC entry 2311 (class 2604 OID 33583)
-- Name: incoming_document id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY incoming_document ALTER COLUMN id SET DEFAULT nextval('incomings_code_seq'::regclass);


--
-- TOC entry 2337 (class 2604 OID 16756)
-- Name: interpassport_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY interpassport_type ALTER COLUMN id SET DEFAULT nextval('tinterpassporttype_id_seq'::regclass);


--
-- TOC entry 2338 (class 2604 OID 16757)
-- Name: medal_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY medal_type ALTER COLUMN id SET DEFAULT nextval('tmedaltype_id_seq'::regclass);


--
-- TOC entry 2340 (class 2604 OID 16759)
-- Name: military_rank id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY military_rank ALTER COLUMN id SET DEFAULT nextval('tmilitaryrank_id_seq'::regclass);


--
-- TOC entry 2321 (class 2604 OID 16742)
-- Name: object_kii id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY object_kii ALTER COLUMN id SET DEFAULT nextval('objects_kii_id_seq'::regclass);


--
-- TOC entry 2322 (class 2604 OID 16743)
-- Name: operators code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY operators ALTER COLUMN code SET DEFAULT nextval('operators_code_seq'::regclass);


--
-- TOC entry 2323 (class 2604 OID 16744)
-- Name: out_attached code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY out_attached ALTER COLUMN code SET DEFAULT nextval('out_attached_code_seq'::regclass);


--
-- TOC entry 2324 (class 2604 OID 16745)
-- Name: out_copies code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY out_copies ALTER COLUMN code SET DEFAULT nextval('out_copies_code_seq'::regclass);


--
-- TOC entry 2326 (class 2604 OID 16746)
-- Name: outgoings code; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY outgoings ALTER COLUMN code SET DEFAULT nextval('outgoings_code_seq'::regclass);


--
-- TOC entry 2341 (class 2604 OID 16760)
-- Name: person id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY person ALTER COLUMN id SET DEFAULT nextval('tperson_id_seq'::regclass);


--
-- TOC entry 2342 (class 2604 OID 16761)
-- Name: phone_number id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY phone_number ALTER COLUMN id SET DEFAULT nextval('tphone_id_seq'::regclass);


--
-- TOC entry 2343 (class 2604 OID 16762)
-- Name: phone_number_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY phone_number_type ALTER COLUMN id SET DEFAULT nextval('tphonenumbertype_id_seq'::regclass);


--
-- TOC entry 2339 (class 2604 OID 16758)
-- Name: position id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "position" ALTER COLUMN id SET DEFAULT nextval('tmilitaryposition_id_seq'::regclass);


--
-- TOC entry 2327 (class 2604 OID 16747)
-- Name: product id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY product ALTER COLUMN id SET DEFAULT nextval('product_id_seq'::regclass);


--
-- TOC entry 2329 (class 2604 OID 16748)
-- Name: role id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY role ALTER COLUMN id SET DEFAULT nextval('role_id_seq'::regclass);


--
-- TOC entry 2355 (class 2604 OID 33396)
-- Name: scientific_research_design_work id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY scientific_research_design_work ALTER COLUMN id SET DEFAULT nextval('scientific_research_design_work_id_seq'::regclass);


--
-- TOC entry 2336 (class 2604 OID 16755)
-- Name: test id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY test ALTER COLUMN id SET DEFAULT nextval('test_id_seq'::regclass);


--
-- TOC entry 2346 (class 2604 OID 16764)
-- Name: unit id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit ALTER COLUMN id SET DEFAULT nextval('tunit_id_seq'::regclass);


--
-- TOC entry 2348 (class 2604 OID 16765)
-- Name: user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- TOC entry 2675 (class 2613 OID 66227)
-- Name: 66227; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('66227');


ALTER LARGE OBJECT 66227 OWNER TO postgres;

--
-- TOC entry 2676 (class 2613 OID 66234)
-- Name: 66234; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('66234');


ALTER LARGE OBJECT 66234 OWNER TO postgres;

--
-- TOC entry 2677 (class 2613 OID 66236)
-- Name: 66236; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('66236');


ALTER LARGE OBJECT 66236 OWNER TO postgres;

--
-- TOC entry 2678 (class 2613 OID 66238)
-- Name: 66238; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('66238');


ALTER LARGE OBJECT 66238 OWNER TO postgres;

--
-- TOC entry 2679 (class 2613 OID 66240)
-- Name: 66240; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('66240');


ALTER LARGE OBJECT 66240 OWNER TO postgres;

--
-- TOC entry 2680 (class 2613 OID 66242)
-- Name: 66242; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('66242');


ALTER LARGE OBJECT 66242 OWNER TO postgres;

--
-- TOC entry 2681 (class 2613 OID 66244)
-- Name: 66244; Type: BLOB; Schema: -; Owner: postgres
--

SELECT pg_catalog.lo_create('66244');


ALTER LARGE OBJECT 66244 OWNER TO postgres;

SET search_path = access, pg_catalog;

--
-- TOC entry 2663 (class 0 OID 17016)
-- Dependencies: 265
-- Data for Name: access_right; Type: TABLE DATA; Schema: access; Owner: postgres
--

COPY access_right (id, oid_table, access_mask, id_role) FROM stdin;
\.


--
-- TOC entry 2747 (class 0 OID 0)
-- Dependencies: 264
-- Name: access_right_id_seq; Type: SEQUENCE SET; Schema: access; Owner: postgres
--

SELECT pg_catalog.setval('access_right_id_seq', 1, false);


--
-- TOC entry 2667 (class 0 OID 17047)
-- Dependencies: 269
-- Data for Name: group; Type: TABLE DATA; Schema: access; Owner: postgres
--

COPY "group" (id, name) FROM stdin;
\.


--
-- TOC entry 2748 (class 0 OID 0)
-- Dependencies: 268
-- Name: group_id_seq; Type: SEQUENCE SET; Schema: access; Owner: postgres
--

SELECT pg_catalog.setval('group_id_seq', 1, false);


--
-- TOC entry 2669 (class 0 OID 17058)
-- Dependencies: 271
-- Data for Name: group_role; Type: TABLE DATA; Schema: access; Owner: postgres
--

COPY group_role (id, id_role, id_group) FROM stdin;
\.


--
-- TOC entry 2749 (class 0 OID 0)
-- Dependencies: 270
-- Name: group_role_id_seq; Type: SEQUENCE SET; Schema: access; Owner: postgres
--

SELECT pg_catalog.setval('group_role_id_seq', 1, false);


--
-- TOC entry 2661 (class 0 OID 17005)
-- Dependencies: 263
-- Data for Name: role; Type: TABLE DATA; Schema: access; Owner: postgres
--

COPY role (id, name) FROM stdin;
\.


--
-- TOC entry 2750 (class 0 OID 0)
-- Dependencies: 262
-- Name: role_id_seq; Type: SEQUENCE SET; Schema: access; Owner: postgres
--

SELECT pg_catalog.setval('role_id_seq', 1, false);


--
-- TOC entry 2671 (class 0 OID 17076)
-- Dependencies: 273
-- Data for Name: user_group; Type: TABLE DATA; Schema: access; Owner: postgres
--

COPY user_group (id, id_user, id_group) FROM stdin;
\.


--
-- TOC entry 2751 (class 0 OID 0)
-- Dependencies: 272
-- Name: user_group_id_seq; Type: SEQUENCE SET; Schema: access; Owner: postgres
--

SELECT pg_catalog.setval('user_group_id_seq', 1, false);


--
-- TOC entry 2665 (class 0 OID 17029)
-- Dependencies: 267
-- Data for Name: user_role; Type: TABLE DATA; Schema: access; Owner: postgres
--

COPY user_role (id, id_role, id_user) FROM stdin;
\.


--
-- TOC entry 2752 (class 0 OID 0)
-- Dependencies: 266
-- Name: user_role_id_seq; Type: SEQUENCE SET; Schema: access; Owner: postgres
--

SELECT pg_catalog.setval('user_role_id_seq', 1, false);


SET search_path = public, pg_catalog;

--
-- TOC entry 2584 (class 0 OID 16405)
-- Dependencies: 186
-- Data for Name: access_right; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY access_right (user_id, admin, omu, kadr, telephone, incoming) FROM stdin;
20	0	4	7	7	0
3	0	0	0	0	0
2	7	7	7	7	7
\.


--
-- TOC entry 2753 (class 0 OID 0)
-- Dependencies: 187
-- Name: access_right_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('access_right_id_seq', 12, true);


--
-- TOC entry 2626 (class 0 OID 16600)
-- Dependencies: 228
-- Data for Name: access_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY access_type (id, name, deleted) FROM stdin;
2	С	\N
3	СС	\N
4	ОВ	\N
5	ДСП	\N
\.


--
-- TOC entry 2628 (class 0 OID 16609)
-- Dependencies: 230
-- Data for Name: address_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY address_type (id, name, deleted) FROM stdin;
1	Домашний	\N
2	Рабочий	\N
\.


--
-- TOC entry 2586 (class 0 OID 16410)
-- Dependencies: 188
-- Data for Name: addressees; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY addressees (code, short_name, address, note) FROM stdin;
1	Адресат1	\N	\N
2	Адресат2	\N	\N
3	Адресат3	\N	\N
4	Адресат4	\N	\N
5	Адресат5	\N	\N
\.


--
-- TOC entry 2754 (class 0 OID 0)
-- Dependencies: 189
-- Name: addressees_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('addressees_code_seq', 1, false);


--
-- TOC entry 2588 (class 0 OID 16418)
-- Dependencies: 190
-- Data for Name: antibrutforce; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY antibrutforce (id_user, col, unban, deleted) FROM stdin;
20	1	\N	2018-08-16 08:26:45.014466+02
2	12	\N	2018-10-05 09:12:10.752419+02
16	7	\N	2018-10-05 11:03:39.969446+02
3	1	\N	\N
\.


--
-- TOC entry 2589 (class 0 OID 16421)
-- Dependencies: 191
-- Data for Name: attached; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY attached (code, incoming, lo, filename, note, mime) FROM stdin;
\.


--
-- TOC entry 2755 (class 0 OID 0)
-- Dependencies: 192
-- Name: attached_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('attached_code_seq', 15, true);


--
-- TOC entry 2630 (class 0 OID 16615)
-- Dependencies: 232
-- Data for Name: city; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY city (id, name, deleted) FROM stdin;
1	Москва	\N
2	Санкт-Петербург	\N
3	Тамбов	\N
4	Воронеж	\N
5	Щёлково	\N
6	Электросталь	\N
7	Люберцы	\N
8	Железнодорожный	\N
\.


--
-- TOC entry 2591 (class 0 OID 16429)
-- Dependencies: 193
-- Data for Name: controls; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY controls (code, number, incoming, number_ud, number_ctrl_ud, datecontrol_ud, orderer, datecontrol, datedone, executor) FROM stdin;
\.


--
-- TOC entry 2756 (class 0 OID 0)
-- Dependencies: 195
-- Name: controls_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('controls_code_seq', 1, false);


--
-- TOC entry 2594 (class 0 OID 16450)
-- Dependencies: 196
-- Data for Name: controlstages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY controlstages (code, control, notedate, note) FROM stdin;
\.


--
-- TOC entry 2757 (class 0 OID 0)
-- Dependencies: 197
-- Name: controlstages_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('controlstages_code_seq', 1, false);


--
-- TOC entry 2596 (class 0 OID 16458)
-- Dependencies: 198
-- Data for Name: department; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY department (id, fullname, shortname, dep_index, server_addr, note, parent, active, deleted) FROM stdin;
15	4 Армия Воздушно-космических сил (Особого назначения)	4 А ВКС (ОН)				0	t	\N
17	312 ГРСТРОБ	312 ГРСТРОБ				16	t	\N
18	85 Центр Контр КП	85 Центр Контр КП				16	t	\N
19	417 ОРТЦ	417 ОРТЦ				16	t	\N
20	5236 ОРТУ	5236 ОРТУ				16	t	\N
21	572 ОРТУ	572 ОРТУ				16	t	\N
22	1109 ООПТИКЭЛУЗ	1109 ООПТИКЭЛУЗ				16	t	\N
23	164 Пункт ОБРИНФ	164 Пункт ОБРИНФ				16	t	\N
24	Служба ЗГТ	Служба ЗГТ				15	t	\N
16	128 ГЦРКО	128 ГЦРКО	123			15	t	\N
28	qweww	weewqqe	weq			0	t	2018-02-20 18:49:42.721033+01
\.


--
-- TOC entry 2758 (class 0 OID 0)
-- Dependencies: 199
-- Name: departments_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('departments_code_seq', 32, true);


--
-- TOC entry 2598 (class 0 OID 16468)
-- Dependencies: 200
-- Data for Name: document; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY document (name, section, file_name, id, deleted) FROM stdin;
йццйуйцу	Защита информации от НСД|Криптография|Научно-исследовательская работа	C:/Apache24/htdocs/isszgt/upload/document/49.doc	49	\N
8678768	БИЗКТ|Кадровая работа	\N	50	\N
777	Защита информации от НСД	C:/Apache24/htdocs/isszgt/upload/document/51.pdf	51	\N
777	Защита информации от НСД	C:/Apache24/htdocs/isszgt/upload/document/53.pdf	53	2018-10-05 09:10:01.825819+02
777	Защита информации от НСД	C:/Apache24/htdocs/isszgt/upload/document/52.pdf	52	2018-10-05 09:10:03.847819+02
ййййй	Режим секретности	\N	34	2018-02-02 07:41:09.80779+01
Приказ МО РФ № 010	Режим секретности	\N	35	\N
Приказ МО РФ от 30 августа 2006 г. № 046	Режим секретности	\N	36	\N
Приказ МО РФ от 30 августа 2006 г. № 046	Режим секретности	\N	37	\N
Приказ МО РФ от 30 августа 2006 г. № 046	Режим секретности	\N	38	\N
qwerty	Криптография	\N	39	2018-07-10 09:31:34.491432+02
weqqw	Array	\N	41	2018-07-10 09:31:36.293432+02
eqweqwe	Кадровая работа	\N	40	2018-07-10 09:31:38.170432+02
123123	Защита информации от НСД|Кадровая работа|Криптография	\N	42	2018-07-10 09:31:40.298432+02
№ 001	БИЗКТ|Защита информации от НСД|Криптография|Научно-исследовательская работа	\N	43	\N
3213	Защита информации от НСД|Кадровая работа|Криптография|Организация ЗИ|РЭБ	\N	44	\N
йцуйцуйцу	Криптография|Научно-исследовательская работа|Организация ЗИ|РЭБ|Шифровальная работа	\N	45	\N
йцууу213123	Кадровая работа|Криптография	\N	46	\N
222	Кадровая работа|Научно-исследовательская работа	\N	47	\N
1233	Защита информации от НСД|Кадровая работа|Научно-исследовательская работа	\N	48	\N
\.


--
-- TOC entry 2759 (class 0 OID 0)
-- Dependencies: 274
-- Name: document_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('document_id_seq', 53, true);


--
-- TOC entry 2633 (class 0 OID 16623)
-- Dependencies: 235
-- Data for Name: email; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY email (id, id_person, name, editable) FROM stdin;
41	1	novik@mail.ru	t
42	1	pikov@pikov.com	t
47	2	alex@yandex.ru	t
48	3	gordeev@yandex.ru	t
49	4	nikitin@yandex.ru	t
50	5	grachev@yandex.ru	t
51	6	durnev@mail.ru	t
52	7	pikov@yandex.ru	t
53	7	vitaliy@pikov.ru	t
54	7	vitaliy@pikov.com	t
56	8	novik@rambler.ru	t
81	9		t
\.


--
-- TOC entry 2635 (class 0 OID 16629)
-- Dependencies: 237
-- Data for Name: email_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY email_type (id, name, deleted) FROM stdin;
3	Личная	\N
5	Рабочая	\N
\.


--
-- TOC entry 2599 (class 0 OID 16476)
-- Dependencies: 201
-- Data for Name: enterprise; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY enterprise (id, name, location, head, post, deleted) FROM stdin;
2	ООО Рога-и-Копыта	Москва	Иванов	Директор	2018-02-19 10:10:41.718157+01
\.


--
-- TOC entry 2760 (class 0 OID 0)
-- Dependencies: 202
-- Name: enterprise_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('enterprise_id_seq', 2, true);


--
-- TOC entry 2601 (class 0 OID 16484)
-- Dependencies: 203
-- Data for Name: executors; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY executors (code, uname, surname, name, patronymic, birthdate, post, department, contacts, note) FROM stdin;
1	u1	Кучер	Анатолий	Юрьевич	\N	начальник отдела (документационного обеспечения) ГК ВВС	32	1	\N
2	u2	Логунов	Олег	Викторович	\N	референт ГК ВВС	1	1	\N
3	u4	Шишкин	Евгений	Викторович	\N	помощник НГШ ВВС	1	1	\N
4	u5	Кондратьев	Евгений	Вячеславович	\N	помощник ГК ВВС	1	1	\N
5	postgres	Медведков	Андрей	Николаевич	\N	заместитель ГК по вооружению	14	1	\N
\.


--
-- TOC entry 2761 (class 0 OID 0)
-- Dependencies: 204
-- Name: executors_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('executors_code_seq', 5, true);


--
-- TOC entry 2603 (class 0 OID 16492)
-- Dependencies: 205
-- Data for Name: folders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY folders (code, number, subject, date_from, date_to) FROM stdin;
1	1	Федеральные законы РФ, Указы Президента РФ, постановления и распоряжения Правительства РФ	\N	\N
2	2	Приказы Министра обороны РФ и его заместителей	\N	\N
3	3	Директивы Министра обороны РФ, начальника Генерального штаба, заместителей Министра обороны РФ и главнокомандующих видами ВС РФ	\N	\N
4	4	Указания Министра обороны РФ и его заместителей	\N	\N
5	5	Приказы главнокомандующего ВВС	\N	\N
6	6	Приказы начальника Главного штаба ВВС	\N	\N
7	7	Номенклатуры дел, перечни книг и журналов, акты на уничтоженные дела и документы	\N	\N
8	8	Материалы Коллегии МО РФ	\N	\N
9	9	Материалы Военного совета ВВС	\N	\N
10	10	Протоколы совещаний в Федеральных органах власти	\N	\N
11	11	Протоколы совещаний в Минобороны России	\N	\N
12	12	Протоколы совещаний в Главном командовании ВВС	\N	\N
13	13	Исходящие документы, подписанные должностными лицами Главного командования ВВС	\N	\N
14	14	Переписка по вопросам документационного обеспечения и контроля	\N	\N
15	15	Переписка по обращениям граждан	\N	\N
16	16	Переписка по общим, организационным и хозяйственным вопросам	\N	\N
17	17	Переписка по вопросам государственной гражданской службы	\N	\N
18	18	Дело с реестрами	\N	\N
\.


--
-- TOC entry 2762 (class 0 OID 0)
-- Dependencies: 206
-- Name: folders_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('folders_code_seq', 18, true);


--
-- TOC entry 2605 (class 0 OID 16500)
-- Dependencies: 207
-- Data for Name: freenumbers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY freenumbers (code, number, depart) FROM stdin;
1	Н-	1
2	Н-	0
3	Н-	0
4	temp	0
5	temp	0
6	temp	0
7	temp	0
8	temp	0
9	temp	0
10	temp	0
11	Н-13	0
\.


--
-- TOC entry 2763 (class 0 OID 0)
-- Dependencies: 208
-- Name: freenumbers_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('freenumbers_code_seq', 11, true);


--
-- TOC entry 2592 (class 0 OID 16435)
-- Dependencies: 194
-- Data for Name: incoming_document; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY incoming_document (id, number_in, date_registration, number_primary, date_primary, senders_numbers, security_label, number_sheets, copies, copies_numbers, subject, "order", instructions, note, control, out_where, out_details, out_date, deleted) FROM stdin;
15	Н-15	2016-10-03	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
16	Н-16	2016-11-22	\N	\N	Петров	3	2	\N	\N	Текст		Нет		2	1	Нет	2016-11-23	\N
17	Н-17	2016-12-09	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
18	Н-18	2016-12-12	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
14	12d	2015-12-06	\N	\N	Отправители и номера дцйуцйцйокумента	2	4	\N	\N	Содержание	Поручения вышестоящего органа	Указания руководства	Комментарии	2	1		1970-01-01	\N
19	Н-19	2017-06-08	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
20	Н-20	2017-09-18	\N	\N	\N	0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
21	K-111	2018-01-01		\N		2		1						1			\N	\N
\.


--
-- TOC entry 2764 (class 0 OID 0)
-- Dependencies: 209
-- Name: incomings_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('incomings_code_seq', 21, true);


--
-- TOC entry 2639 (class 0 OID 16640)
-- Dependencies: 241
-- Data for Name: interpassport_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY interpassport_type (id, name, deleted) FROM stdin;
1	Служебный	\N
2	Гражданский	\N
\.


--
-- TOC entry 2641 (class 0 OID 16649)
-- Dependencies: 243
-- Data for Name: medal_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY medal_type (id, name, deleted) FROM stdin;
1	За отличие в военной службе III степени	\N
2	За отличие в военной службе II степени	\N
3	За отличие в военной службе I степени	\N
\.


--
-- TOC entry 2645 (class 0 OID 16664)
-- Dependencies: 247
-- Data for Name: military_rank; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY military_rank (id, name, deleted) FROM stdin;
1	Лейтенант	\N
2	Старший лейтенант	\N
3	Капитан	\N
4	Майор	\N
5	Подполковник	\N
6	Полковник	\N
7	Генерал-майор	\N
9	Генерал-полковник	\N
10	Генерал армии	\N
11	Маршал	\N
12	фывфыв	2018-02-09 14:19:08.872457+01
8	Генерал-лейтенант	2018-02-09 14:19:39.851857+01
\.


--
-- TOC entry 2765 (class 0 OID 0)
-- Dependencies: 210
-- Name: number_control_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('number_control_seq', 1, false);


--
-- TOC entry 2766 (class 0 OID 0)
-- Dependencies: 211
-- Name: number_in_ns_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('number_in_ns_seq', 1, false);


--
-- TOC entry 2767 (class 0 OID 0)
-- Dependencies: 212
-- Name: number_in_s_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('number_in_s_seq', 1, false);


--
-- TOC entry 2768 (class 0 OID 0)
-- Dependencies: 213
-- Name: number_out_ns_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('number_out_ns_seq', 1, false);


--
-- TOC entry 2612 (class 0 OID 16545)
-- Dependencies: 214
-- Data for Name: object_kii; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY object_kii (id, name_kvito, reg_number, certificate, "order", id_department) FROM stdin;
22	3432цуй	123	123	234	15
23	qwe123	21	123	44	15
24	wwww	111	222	333	15
27	eeee	q231	eqwe	1222	15
28	dasasddas	qweqwe	12312	414	24
29	wwe	qwww	wwwwwwwwwwwwwwwwwwwwwwwwwwww		15
34	asdsad	\N	\N	\N	15
\.


--
-- TOC entry 2769 (class 0 OID 0)
-- Dependencies: 215
-- Name: objects_kii_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('objects_kii_id_seq', 34, true);


--
-- TOC entry 2614 (class 0 OID 16553)
-- Dependencies: 216
-- Data for Name: operators; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY operators (code, uname, surname, name, patronymic, note) FROM stdin;
\.


--
-- TOC entry 2770 (class 0 OID 0)
-- Dependencies: 217
-- Name: operators_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('operators_code_seq', 1, false);


--
-- TOC entry 2616 (class 0 OID 16561)
-- Dependencies: 218
-- Data for Name: out_attached; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY out_attached (code, outgoing, lo, filename, note) FROM stdin;
\.


--
-- TOC entry 2771 (class 0 OID 0)
-- Dependencies: 219
-- Name: out_attached_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('out_attached_code_seq', 1, false);


--
-- TOC entry 2618 (class 0 OID 16569)
-- Dependencies: 220
-- Data for Name: out_copies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY out_copies (code, outgoing, copy_number, addressee, folder, note) FROM stdin;
\.


--
-- TOC entry 2772 (class 0 OID 0)
-- Dependencies: 221
-- Name: out_copies_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('out_copies_code_seq', 1, false);


--
-- TOC entry 2620 (class 0 OID 16577)
-- Dependencies: 222
-- Data for Name: outgoings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY outgoings (code, number_out, date_out, subject, notes, grif, init_number, init_date, init_type, department, executor, executor_fio, executor_contacts, sheets, copies) FROM stdin;
\.


--
-- TOC entry 2773 (class 0 OID 0)
-- Dependencies: 223
-- Name: outgoings_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('outgoings_code_seq', 1, false);


--
-- TOC entry 2647 (class 0 OID 16670)
-- Dependencies: 249
-- Data for Name: person; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY person (id, firstname, lastname, patronymic, military, personal_number, birthday, id_access_type, id_unit, id_military_rank, img_ext, address, id_city, note, deleted) FROM stdin;
2	Александр	Палатников	Александрович	t	Ф-34324234	2016-03-16	4	3	6	jpg	Советская, дом 44, кв. 33	7	Комментарий про ПАЛАТНИКОВА.	\N
3	Виталий	Гордеев	Александрович	t	Ф-232323	2016-03-16	4	4	6	jpg	Интернациональная, дом 43, кв. 3	1	Комментарий про ГОРДЕЕВА.	\N
4	Александр	Никитин	Сергеевич	t	Ф-345345	2016-03-16	3	2	5	jpg	Борцов, дом 5, кв. 4	1		\N
9	Иван	Иванов	Сергеевич	t	х-123123	2016-12-24	3	1	5	jpg		1		2018-03-14 13:00:03.014898+01
1	Сергей	Заиченко	Павлович	t	М-625354	2016-03-16	3	1	5	jpg	Вязовский	1		2018-03-14 13:02:59.533329+01
8	Егор	Новичихин	Александрович	t	В-546456	1982-12-29	3	8	3	jpg	ул. Заречная, дом 4, кв. 1	6	Новичихин умеет делать автомобили.	2018-03-14 13:15:28.965469+01
7	Виталий	Пиков	Александрович	t	Ф-596456	1979-07-25	3	7	4	jpg	ул. Московская, дом 10, кв. 7	7	Доцент кафедры ИТиЕНД РосНОУ.	2018-03-14 13:18:18.800358+01
5	Антон	Грачев	Николаевич	t	Ф-232323	2016-03-16	3	5	5	jpg	Совецкая, 23-4	3		2018-03-14 14:38:05.221919+01
\.


--
-- TOC entry 2649 (class 0 OID 16679)
-- Dependencies: 251
-- Data for Name: phone_number; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY phone_number (id, id_person, id_phone_number_type, deleted, number) FROM stdin;
117	46	2	\N	6661111
118	46	3	\N	222666
119	47	2	\N	333333
120	47	3	\N	222222
121	47	4	\N	333333
139	47	5	\N	123123
140	3	2	\N	1231234
115	2	2	\N	213123
116	2	3	\N	4213412
\.


--
-- TOC entry 2651 (class 0 OID 16685)
-- Dependencies: 253
-- Data for Name: phone_number_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY phone_number_type (id, name, deleted) FROM stdin;
2	Домашний	\N
3	Рабочий	\N
4	Мобильный	\N
5	Факс	\N
\.


--
-- TOC entry 2643 (class 0 OID 16658)
-- Dependencies: 245
-- Data for Name: position; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "position" (id, name, deleted) FROM stdin;
1	Начальник института	\N
2	Заместитель начальника института	\N
3	Начальник управления	\N
4	Заместитель начальника управления	\N
5	Главный конструктор	\N
6	Начальник отдела	\N
7	Заместитель начальника отдела - старший инженер	\N
8	йцуйцу	2018-02-09 14:20:26.769857+01
\.


--
-- TOC entry 2622 (class 0 OID 16586)
-- Dependencies: 224
-- Data for Name: product; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY product (id, index, cipher, description, image_file_name, deleted, creator, security_label) FROM stdin;
15	683Т50                        	Авангард                                          	Описание для изделия &quot;Авангард&quot; и т.д.	upload/product/15.png	\N	\N	\N
14	11Р7                          	Вьюга                                             	Описание для изделия "Вьюга".	upload/product/14.png	2018-02-19 08:52:08.269506+01	\N	\N
16	55Ж6ММ                        	Небо-НМ                                           	Описание для изделия "Небо-НМ".	upload/product/16.png	\N	ООО Рога и копыта	СС
17	23                            	Авиатор                                           	123213	\N	\N	444123	ДСП
\.


--
-- TOC entry 2774 (class 0 OID 0)
-- Dependencies: 225
-- Name: product_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('product_id_seq', 17, true);


--
-- TOC entry 2624 (class 0 OID 16594)
-- Dependencies: 226
-- Data for Name: role; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY role (id, title, editable) FROM stdin;
1	Администратор	f
2	Читатель	f
\.


--
-- TOC entry 2775 (class 0 OID 0)
-- Dependencies: 227
-- Name: role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('role_id_seq', 7, true);


--
-- TOC entry 2674 (class 0 OID 33393)
-- Dependencies: 276
-- Data for Name: scientific_research_design_work; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY scientific_research_design_work (id, year, file_name, deleted) FROM stdin;
9	2010	C:/Apache24/htdocs/isszgt/upload/scientific_work/9.pdf	2018-02-14 13:33:40.478953+01
8	2013	C:/Apache24/htdocs/isszgt/upload/scientific_work/8.doc	2018-02-14 13:33:42.832953+01
\.


--
-- TOC entry 2776 (class 0 OID 0)
-- Dependencies: 275
-- Name: scientific_research_design_work_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('scientific_research_design_work_id_seq', 9, true);


--
-- TOC entry 2777 (class 0 OID 0)
-- Dependencies: 229
-- Name: taccesstype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('taccesstype_id_seq', 5, true);


--
-- TOC entry 2778 (class 0 OID 0)
-- Dependencies: 231
-- Name: taddresstype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('taddresstype_id_seq', 2, true);


--
-- TOC entry 2779 (class 0 OID 0)
-- Dependencies: 233
-- Name: tcity_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tcity_id_seq', 8, true);


--
-- TOC entry 2653 (class 0 OID 16697)
-- Dependencies: 255
-- Data for Name: technique; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY technique (id, fullname, shortname, id_department, deleted) FROM stdin;
29	www	222	15	2018-02-22 12:20:00.389037+01
30	w	2	15	2018-02-22 12:23:23.3469+01
31	3222222	23eqweqwe	\N	2018-02-22 12:27:39.064352+01
32	1234	1234	15	\N
\.


--
-- TOC entry 2780 (class 0 OID 0)
-- Dependencies: 234
-- Name: technique_code_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('technique_code_seq', 11, false);


--
-- TOC entry 2781 (class 0 OID 0)
-- Dependencies: 236
-- Name: temail_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('temail_id_seq', 81, true);


--
-- TOC entry 2782 (class 0 OID 0)
-- Dependencies: 238
-- Name: temailtype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('temailtype_id_seq', 5, true);


--
-- TOC entry 2637 (class 0 OID 16635)
-- Dependencies: 239
-- Data for Name: test; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY test (id, tipo, images) FROM stdin;
\.


--
-- TOC entry 2783 (class 0 OID 0)
-- Dependencies: 240
-- Name: test_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('test_id_seq', 1, true);


--
-- TOC entry 2784 (class 0 OID 0)
-- Dependencies: 242
-- Name: tinterpassporttype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tinterpassporttype_id_seq', 2, true);


--
-- TOC entry 2785 (class 0 OID 0)
-- Dependencies: 244
-- Name: tmedaltype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tmedaltype_id_seq', 3, true);


--
-- TOC entry 2786 (class 0 OID 0)
-- Dependencies: 246
-- Name: tmilitaryposition_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tmilitaryposition_id_seq', 8, true);


--
-- TOC entry 2787 (class 0 OID 0)
-- Dependencies: 248
-- Name: tmilitaryrank_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tmilitaryrank_id_seq', 12, true);


--
-- TOC entry 2788 (class 0 OID 0)
-- Dependencies: 250
-- Name: tperson_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tperson_id_seq', 47, true);


--
-- TOC entry 2789 (class 0 OID 0)
-- Dependencies: 252
-- Name: tphone_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tphone_id_seq', 140, true);


--
-- TOC entry 2790 (class 0 OID 0)
-- Dependencies: 254
-- Name: tphonenumbertype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tphonenumbertype_id_seq', 5, true);


--
-- TOC entry 2791 (class 0 OID 0)
-- Dependencies: 257
-- Name: tunit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tunit_id_seq', 9, true);


--
-- TOC entry 2654 (class 0 OID 16704)
-- Dependencies: 256
-- Data for Name: unit; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY unit (id, id_military_rank, id_position, id_department, id_access_type, order_number, order_owner, tariff_category, dateorderstart, dateorderend, vacant, deleted) FROM stdin;
2	4	4	15	3	1940980	МО РФ	28	2016-03-08	1970-01-01	t	\N
1	5	3	15	3	3234234	МО РФ	30	2016-03-16	1970-01-01	t	\N
6	4	5	15	3	435345453	МО РФ	35	2016-03-17	1970-01-01	t	\N
5	4	5	15	3	543534534	МО РФ	26	2016-03-16	1970-01-01	t	\N
8	3	7	15	3	1231231	МО РФ	16	2016-03-16	1970-01-01	t	\N
9	1	7	15	3	2	2	22	2016-10-20	1970-01-01	t	\N
4	6	2	15	4	324324	МО РФ	38	2016-03-16	1970-01-01	t	\N
3	6	1	15	4	234234	МО РФ	40	2016-03-16	1970-01-01	t	\N
7	4	6	15	3	123121	МО РФ	18	2016-03-17	1970-01-01	t	\N
\.


--
-- TOC entry 2656 (class 0 OID 16714)
-- Dependencies: 258
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "user" (id, role_id, active, title, bdate, adate, img_ext, name, passwd, deleted) FROM stdin;
3	1	\N	Пиков Виталий Александрович	1979-07-24 00:00:00+02	2018-02-08 00:00:00+01	jpg	pikov	d41d8cd98f00b204e9800998ecf8427e	\N
2	1	t	Администратор	1978-12-31 00:00:00+01	2015-04-14 00:00:00+02	png	admin	134c7fab50842e470cbcf583949d1f7e	\N
16	2	t	Дурнев Василий Валентинович	1953-12-15 00:00:00+01	2018-02-08 00:00:00+01	jpg	durnev	827ccb0eea8a706c4c34a16891f84e7b	\N
20	1	t	Новичихин Егор Александрович	1982-12-28 22:00:00+01	2016-12-30 22:00:00+01	jpg	novich	827ccb0eea8a706c4c34a16891f84e7b	\N
\.


--
-- TOC entry 2657 (class 0 OID 16722)
-- Dependencies: 259
-- Data for Name: user_action; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY user_action (user_id, adate, title) FROM stdin;
\.


--
-- TOC entry 2792 (class 0 OID 0)
-- Dependencies: 260
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('user_id_seq', 23, true);


--
-- TOC entry 2659 (class 0 OID 16727)
-- Dependencies: 261
-- Data for Name: user_login; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY user_login (user_id, success, ldate) FROM stdin;
\.


--
-- TOC entry 2682 (class 0 OID 0)
-- Data for Name: BLOBS; Type: BLOBS; Schema: -; Owner: 
--

SET search_path = pg_catalog;

BEGIN;

SELECT pg_catalog.lo_open('66227', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('66234', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('66236', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('66238', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('66240', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('66242', 131072);
SELECT pg_catalog.lo_close(0);

SELECT pg_catalog.lo_open('66244', 131072);
SELECT pg_catalog.lo_close(0);

COMMIT;

SET search_path = access, pg_catalog;

--
-- TOC entry 2430 (class 2606 OID 17021)
-- Name: access_right access_right_pkey; Type: CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY access_right
    ADD CONSTRAINT access_right_pkey PRIMARY KEY (id);


--
-- TOC entry 2434 (class 2606 OID 17055)
-- Name: group group_pkey; Type: CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_pkey PRIMARY KEY (id);


--
-- TOC entry 2436 (class 2606 OID 17063)
-- Name: group_role group_role_pkey; Type: CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY group_role
    ADD CONSTRAINT group_role_pkey PRIMARY KEY (id);


--
-- TOC entry 2428 (class 2606 OID 17013)
-- Name: role role_pkey; Type: CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY role
    ADD CONSTRAINT role_pkey PRIMARY KEY (id);


--
-- TOC entry 2438 (class 2606 OID 17081)
-- Name: user_group user_group_pkey; Type: CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY user_group
    ADD CONSTRAINT user_group_pkey PRIMARY KEY (id);


--
-- TOC entry 2432 (class 2606 OID 17034)
-- Name: user_role user_role_pkey; Type: CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY user_role
    ADD CONSTRAINT user_role_pkey PRIMARY KEY (id);


SET search_path = public, pg_catalog;

--
-- TOC entry 2357 (class 2606 OID 16894)
-- Name: access_right access_right_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY access_right
    ADD CONSTRAINT access_right_pk PRIMARY KEY (user_id);


--
-- TOC entry 2395 (class 2606 OID 16936)
-- Name: access_type access_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY access_type
    ADD CONSTRAINT access_type_pkey PRIMARY KEY (id);


--
-- TOC entry 2397 (class 2606 OID 16938)
-- Name: address_type address_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY address_type
    ADD CONSTRAINT address_type_pkey PRIMARY KEY (id);


--
-- TOC entry 2359 (class 2606 OID 16896)
-- Name: addressees addressees_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY addressees
    ADD CONSTRAINT addressees_pkey PRIMARY KEY (code);


--
-- TOC entry 2361 (class 2606 OID 16898)
-- Name: attached attached_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY attached
    ADD CONSTRAINT attached_pkey PRIMARY KEY (code);


--
-- TOC entry 2399 (class 2606 OID 16940)
-- Name: city city_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY city
    ADD CONSTRAINT city_pkey PRIMARY KEY (id);


--
-- TOC entry 2363 (class 2606 OID 16900)
-- Name: controls controls_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY controls
    ADD CONSTRAINT controls_pkey PRIMARY KEY (code);


--
-- TOC entry 2367 (class 2606 OID 16902)
-- Name: controlstages controlstages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY controlstages
    ADD CONSTRAINT controlstages_pkey PRIMARY KEY (code);


--
-- TOC entry 2369 (class 2606 OID 16904)
-- Name: department department_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY department
    ADD CONSTRAINT department_pkey PRIMARY KEY (id);


--
-- TOC entry 2371 (class 2606 OID 25205)
-- Name: document document_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY document
    ADD CONSTRAINT document_pk PRIMARY KEY (id);


--
-- TOC entry 2403 (class 2606 OID 16946)
-- Name: email_type email_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY email_type
    ADD CONSTRAINT email_type_pkey PRIMARY KEY (id);


--
-- TOC entry 2373 (class 2606 OID 16908)
-- Name: enterprise enterprise_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY enterprise
    ADD CONSTRAINT enterprise_pkey PRIMARY KEY (id);


--
-- TOC entry 2375 (class 2606 OID 16910)
-- Name: executors executors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY executors
    ADD CONSTRAINT executors_pkey PRIMARY KEY (code);


--
-- TOC entry 2377 (class 2606 OID 16912)
-- Name: folders folders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY folders
    ADD CONSTRAINT folders_pkey PRIMARY KEY (code);


--
-- TOC entry 2379 (class 2606 OID 16914)
-- Name: freenumbers freenumbers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY freenumbers
    ADD CONSTRAINT freenumbers_pkey PRIMARY KEY (code);


--
-- TOC entry 2393 (class 2606 OID 16916)
-- Name: role id; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY role
    ADD CONSTRAINT id PRIMARY KEY (id);


--
-- TOC entry 2365 (class 2606 OID 33585)
-- Name: incoming_document incoming_document_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY incoming_document
    ADD CONSTRAINT incoming_document_pkey PRIMARY KEY (id);


--
-- TOC entry 2405 (class 2606 OID 16948)
-- Name: interpassport_type interpassport_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY interpassport_type
    ADD CONSTRAINT interpassport_type_pkey PRIMARY KEY (id);


--
-- TOC entry 2407 (class 2606 OID 16950)
-- Name: medal_type medal_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY medal_type
    ADD CONSTRAINT medal_type_pkey PRIMARY KEY (id);


--
-- TOC entry 2411 (class 2606 OID 16954)
-- Name: military_rank military_rank_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY military_rank
    ADD CONSTRAINT military_rank_pkey PRIMARY KEY (id);


--
-- TOC entry 2381 (class 2606 OID 16924)
-- Name: object_kii object_kii_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY object_kii
    ADD CONSTRAINT object_kii_pk PRIMARY KEY (id);


--
-- TOC entry 2383 (class 2606 OID 16926)
-- Name: operators operators_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY operators
    ADD CONSTRAINT operators_pkey PRIMARY KEY (code);


--
-- TOC entry 2385 (class 2606 OID 16928)
-- Name: out_attached out_attached_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY out_attached
    ADD CONSTRAINT out_attached_pkey PRIMARY KEY (code);


--
-- TOC entry 2387 (class 2606 OID 16930)
-- Name: out_copies out_copies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY out_copies
    ADD CONSTRAINT out_copies_pkey PRIMARY KEY (code);


--
-- TOC entry 2389 (class 2606 OID 16932)
-- Name: outgoings outgoings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY outgoings
    ADD CONSTRAINT outgoings_pkey PRIMARY KEY (code);


--
-- TOC entry 2413 (class 2606 OID 16956)
-- Name: person person_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY person
    ADD CONSTRAINT person_pkey PRIMARY KEY (id);


--
-- TOC entry 2415 (class 2606 OID 16958)
-- Name: phone_number phone_number_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY phone_number
    ADD CONSTRAINT phone_number_pkey PRIMARY KEY (id);


--
-- TOC entry 2419 (class 2606 OID 16960)
-- Name: phone_number_type phone_number_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY phone_number_type
    ADD CONSTRAINT phone_number_type_pkey PRIMARY KEY (id);


--
-- TOC entry 2417 (class 2606 OID 33579)
-- Name: phone_number phone_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY phone_number
    ADD CONSTRAINT phone_number_unique UNIQUE (id_person, id_phone_number_type);


--
-- TOC entry 2409 (class 2606 OID 16952)
-- Name: position position_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "position"
    ADD CONSTRAINT position_pkey PRIMARY KEY (id);


--
-- TOC entry 2391 (class 2606 OID 16934)
-- Name: product product_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY product
    ADD CONSTRAINT product_pkey PRIMARY KEY (id);


--
-- TOC entry 2440 (class 2606 OID 33398)
-- Name: scientific_research_design_work scientific_research_design_work_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY scientific_research_design_work
    ADD CONSTRAINT scientific_research_design_work_pkey PRIMARY KEY (id);


--
-- TOC entry 2422 (class 2606 OID 33464)
-- Name: technique technique_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY technique
    ADD CONSTRAINT technique_pkey PRIMARY KEY (id);


--
-- TOC entry 2401 (class 2606 OID 16944)
-- Name: email temail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY email
    ADD CONSTRAINT temail_pkey PRIMARY KEY (id);


--
-- TOC entry 2424 (class 2606 OID 16964)
-- Name: unit unit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit
    ADD CONSTRAINT unit_pkey PRIMARY KEY (id);


--
-- TOC entry 2426 (class 2606 OID 16966)
-- Name: user user_id; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_id PRIMARY KEY (id);


--
-- TOC entry 2420 (class 1259 OID 33457)
-- Name: fki_id_departments; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_id_departments ON technique USING btree (id_department);


--
-- TOC entry 2459 (class 2620 OID 16978)
-- Name: attached a_d; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER a_d AFTER DELETE ON attached FOR EACH ROW EXECUTE PROCEDURE attached_ad();


--
-- TOC entry 2460 (class 2620 OID 16979)
-- Name: controls a_d; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER a_d AFTER DELETE ON controls FOR EACH ROW EXECUTE PROCEDURE controls_ad();


--
-- TOC entry 2462 (class 2620 OID 16980)
-- Name: incoming_document a_d; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER a_d AFTER DELETE ON incoming_document FOR EACH ROW EXECUTE PROCEDURE incomings_ad();


--
-- TOC entry 2465 (class 2620 OID 16981)
-- Name: outgoings a_d; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER a_d AFTER DELETE ON outgoings FOR EACH ROW EXECUTE PROCEDURE outgoings_ad();


--
-- TOC entry 2464 (class 2620 OID 16982)
-- Name: out_attached a_d; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER a_d AFTER DELETE ON out_attached FOR EACH ROW EXECUTE PROCEDURE out_attached_ad();


--
-- TOC entry 2461 (class 2620 OID 16983)
-- Name: controls a_iud; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER a_iud AFTER INSERT OR DELETE OR UPDATE ON controls FOR EACH ROW EXECUTE PROCEDURE controls_n();


--
-- TOC entry 2463 (class 2620 OID 16984)
-- Name: incoming_document a_iud; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER a_iud AFTER INSERT OR DELETE OR UPDATE ON incoming_document FOR EACH ROW EXECUTE PROCEDURE incomings_n();


--
-- TOC entry 2466 (class 2620 OID 16985)
-- Name: outgoings a_iud; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER a_iud AFTER INSERT OR DELETE OR UPDATE ON outgoings FOR EACH ROW EXECUTE PROCEDURE outgoings_n();


SET search_path = access, pg_catalog;

--
-- TOC entry 2452 (class 2606 OID 17022)
-- Name: access_right access_right_fkey; Type: FK CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY access_right
    ADD CONSTRAINT access_right_fkey FOREIGN KEY (id_role) REFERENCES role(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2456 (class 2606 OID 17069)
-- Name: group_role group_role_id_group_fkey; Type: FK CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY group_role
    ADD CONSTRAINT group_role_id_group_fkey FOREIGN KEY (id_group) REFERENCES "group"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2455 (class 2606 OID 17064)
-- Name: group_role group_role_id_role_fkey; Type: FK CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY group_role
    ADD CONSTRAINT group_role_id_role_fkey FOREIGN KEY (id_role) REFERENCES role(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2458 (class 2606 OID 17087)
-- Name: user_group user_group_id_group_fkey; Type: FK CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY user_group
    ADD CONSTRAINT user_group_id_group_fkey FOREIGN KEY (id_group) REFERENCES "group"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2457 (class 2606 OID 17082)
-- Name: user_group user_group_id_user_fkey; Type: FK CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY user_group
    ADD CONSTRAINT user_group_id_user_fkey FOREIGN KEY (id_user) REFERENCES public."user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2454 (class 2606 OID 17035)
-- Name: user_role user_role_id_role_fkey; Type: FK CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY user_role
    ADD CONSTRAINT user_role_id_role_fkey FOREIGN KEY (id_role) REFERENCES role(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2453 (class 2606 OID 17040)
-- Name: user_role user_role_id_user_fkey; Type: FK CONSTRAINT; Schema: access; Owner: postgres
--

ALTER TABLE ONLY user_role
    ADD CONSTRAINT user_role_id_user_fkey FOREIGN KEY (id_user) REFERENCES public."user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


SET search_path = public, pg_catalog;

--
-- TOC entry 2448 (class 2606 OID 33420)
-- Name: unit access_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit
    ADD CONSTRAINT access_type_fkey FOREIGN KEY (id_access_type) REFERENCES access_type(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2443 (class 2606 OID 33489)
-- Name: person access_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY person
    ADD CONSTRAINT access_type_fkey FOREIGN KEY (id_access_type) REFERENCES access_type(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2441 (class 2606 OID 17097)
-- Name: antibrutforce antibrutforce_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY antibrutforce
    ADD CONSTRAINT antibrutforce_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2451 (class 2606 OID 33440)
-- Name: unit department_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit
    ADD CONSTRAINT department_fkey FOREIGN KEY (id_department) REFERENCES department(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2450 (class 2606 OID 33430)
-- Name: unit military_rank_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit
    ADD CONSTRAINT military_rank_fkey FOREIGN KEY (id_military_rank) REFERENCES military_rank(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2444 (class 2606 OID 33494)
-- Name: person military_rank_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY person
    ADD CONSTRAINT military_rank_fkey FOREIGN KEY (id_military_rank) REFERENCES military_rank(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2442 (class 2606 OID 16996)
-- Name: object_kii object_kii_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY object_kii
    ADD CONSTRAINT object_kii_fk FOREIGN KEY (id_department) REFERENCES department(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2446 (class 2606 OID 33520)
-- Name: phone_number phone_number_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY phone_number
    ADD CONSTRAINT phone_number_type_fkey FOREIGN KEY (id_phone_number_type) REFERENCES phone_number_type(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2449 (class 2606 OID 33425)
-- Name: unit position_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit
    ADD CONSTRAINT position_fkey FOREIGN KEY (id_position) REFERENCES "position"(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2447 (class 2606 OID 33465)
-- Name: technique technique_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY technique
    ADD CONSTRAINT technique_fkey FOREIGN KEY (id_department) REFERENCES department(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2445 (class 2606 OID 33504)
-- Name: person unit_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY person
    ADD CONSTRAINT unit_fkey FOREIGN KEY (id_unit) REFERENCES unit(id) ON UPDATE SET NULL ON DELETE SET NULL;


--
-- TOC entry 2698 (class 0 OID 0)
-- Dependencies: 228
-- Name: access_type; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE access_type TO PUBLIC;


--
-- TOC entry 2699 (class 0 OID 0)
-- Dependencies: 230
-- Name: address_type; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE address_type TO PUBLIC;


--
-- TOC entry 2702 (class 0 OID 0)
-- Dependencies: 232
-- Name: city; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE city TO PUBLIC;


--
-- TOC entry 2707 (class 0 OID 0)
-- Dependencies: 235
-- Name: email; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE email TO PUBLIC;


--
-- TOC entry 2708 (class 0 OID 0)
-- Dependencies: 237
-- Name: email_type; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE email_type TO PUBLIC;


--
-- TOC entry 2714 (class 0 OID 0)
-- Dependencies: 241
-- Name: interpassport_type; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE interpassport_type TO PUBLIC;


--
-- TOC entry 2715 (class 0 OID 0)
-- Dependencies: 243
-- Name: medal_type; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE medal_type TO PUBLIC;


--
-- TOC entry 2716 (class 0 OID 0)
-- Dependencies: 247
-- Name: military_rank; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE military_rank TO PUBLIC;


--
-- TOC entry 2722 (class 0 OID 0)
-- Dependencies: 249
-- Name: person; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE person TO PUBLIC;


--
-- TOC entry 2723 (class 0 OID 0)
-- Dependencies: 251
-- Name: phone_number; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE phone_number TO PUBLIC;


--
-- TOC entry 2724 (class 0 OID 0)
-- Dependencies: 245
-- Name: position; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE "position" TO PUBLIC;


-- Completed on 2018-10-08 09:24:51

--
-- PostgreSQL database dump complete
--


# fc8215b264fe3fcb95fb57cc84cbcf84
REST API To Send Email

>> REQUIREMENT
-- Set GMAIL Security Account : LESS SECURE APP ON
-- Create table with this statement
-- Table: public.mail_sent

-- DROP TABLE public.mail_sent;

CREATE TABLE public.mail_sent
(
    idx integer NOT NULL DEFAULT nextval('mail_sent_idx_seq'::regclass),
    _from character varying(200) COLLATE pg_catalog."default" NOT NULL,
    _to character varying(200) COLLATE pg_catalog."default" NOT NULL,
    _subject character varying(200) COLLATE pg_catalog."default" NOT NULL,
    _content text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT mail_sent_pkey PRIMARY KEY (idx, _from, _to, _subject, _content)
)

TABLESPACE pg_default;

ALTER TABLE public.mail_sent
OWNER to postgres;


>> RUN APPLICATION
$ php -S local.testing:8008 -t api

>> RUN WORKER
$ php worker.php

>> API ENDPOINT : http://local.testing:8008/post

>> This API using GET method because using Github OAuth, access API from your favourite browser.
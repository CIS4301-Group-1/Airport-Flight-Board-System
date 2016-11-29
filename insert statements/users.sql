--------------------------------------------------------
--  File created - Monday-November-28-2016   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table USERS
--------------------------------------------------------

  CREATE TABLE "USERS" 
   (	"USERID" NUMBER(8,0), 
	"USERNAME" VARCHAR2(128 BYTE), 
	"PASSWORD" VARCHAR2(128 BYTE), 
	"ACCESSLEVEL" NUMBER(3,0)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS NOLOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT);
REM INSERTING into USERS
SET DEFINE OFF;
Insert into USERS (USERID,USERNAME,PASSWORD,ACCESSLEVEL) values (0,'admin','root',0);
Insert into USERS (USERID,USERNAME,PASSWORD,ACCESSLEVEL) values (1,'pilot','iflyplanes',1);
Insert into USERS (USERID,USERNAME,PASSWORD,ACCESSLEVEL) values (2,'passenger1','firstclass',2);

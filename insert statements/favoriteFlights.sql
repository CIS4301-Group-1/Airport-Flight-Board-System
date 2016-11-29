--------------------------------------------------------
--  File created - Monday-November-28-2016   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table FAVORITEFLIGHTS
--------------------------------------------------------

  CREATE TABLE "FAVORITEFLIGHTS" 
   (	"FAVID" NUMBER(8,0), 
	"USERID" NUMBER(8,0), 
	"FLIGHTID" NUMBER(8,0)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS NOLOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT);
REM INSERTING into FAVORITEFLIGHTS
SET DEFINE OFF;
Insert into FAVORITEFLIGHTS (FAVID,USERID,FLIGHTID) values (2,2,2561);
Insert into FAVORITEFLIGHTS (FAVID,USERID,FLIGHTID) values (3,2,4869);

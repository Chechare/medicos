CREATE TABLE doctor
(
drID varchar(3), 
dfname varchar(50) NOT NULL,
dlname varchar(50) NOT NULL,
specialty varchar(20) NOT NULL,
app_lenght date NOT NULL, 
CONSTRAINT pk_drID PRIMARY KEY (DrId),
CONSTRAINT pk_drFormat CHECK(drID BETWEEN 'D00' AND 'D99')
);

CREATE TABLE Patient
(
pId varchar(4),
pfname varchar(50) NOT NULL,
plname varchar(50) NOT NULL,
phone number(10),
email varchar(254),
CONSTRAINT pk_pID PRIMARY KEY (pId),
CONSTRAINT pk_pFormat CHECK(pID BETWEEN 'P000' AND 'P999'),
CONSTRAINT datos_P CHECK(phone IS NOT NULL OR email IS NOT NULL)
);

CREATE TABLE admin
(
username varchar(10),
password varchar(20) NOT NULL,
CONSTRAINT pk_usernameID PRIMARY KEY (username)
);

CREATE TABLE schedule(
day varchar(10),
drID varchar(3),
startHour date,
endHour date,
CONSTRAINT pk_scheduleID PRIMARY KEY (day,drId),
CONSTRAINT fk_scheduleDr FOREIGN KEY (drId)
REFERENCES Doctor(drId)
);

CREATE TABLE appointment
(
pID varchar(4),
drId varchar(3),
app_date DATE,
description varchar(140),
approved CHAR(1),
CONSTRAINT pk_appointmentId PRIMARY KEY (pId,drId,app_date),
CONSTRAINT fk_appointmentPatient FOREIGN KEY (PId)
REFERENCES Patient(PId),
CONSTRAINT fk_appointmentDr FOREIGN KEY (DrId)
REFERENCES Doctor(DrId)
);

CREATE VIEW patient_data AS SELECT pid,pfname,plname,phone,email FROM Patient;

CREATE VIEW app_data AS
SELECT
drid,pid,dfname,dlname,pfname,plname,description,
to_char(app_date, 'yyyy-mm-dd HH24:MI:SS')AS app_start, 
to_char(app_date + NUMTODSINTERVAL(to_number(to_char(app_lenght, 'HH24')), 'hour') + NUMTODSINTERVAL(to_number(to_char(app_lenght, 'MI')), 'minute'), 'yyyy-mm-dd HH24:MI:SS') as app_end,
to_char(app_lenght, 'HH24:MI') AS app_lenght, approved AS status
FROM doctor NATURAL JOIN patient NATURAL JOIN appointment;

CREATE VIEW hour_data AS
SELECT day,drid,to_char(starthour,'HH24:MI') AS starthour,to_char(endhour,'HH24:MI') AS endhour
FROM schedule;

CREATE OR REPLACE TRIGGER horario
BEFORE INSERT ON appointment
FOR EACH ROW
	DECLARE
		INICIO DATE;
		FIN DATE;
		NOW DATE;
		day char (15);
	BEGIN
		day:= to_char(:new.app_date,'DAY');
		NOW:= to_date(to_char(:new.app_date,'HH24:MI'),'HH24:MI');
		IF day='MONDAY' THEN 
			SELECT to_date(to_char(STARTHOUR,'HH24:MI'),'HH24:MI') INTO INICIO FROM schedule s WHERE s.day='lunes' AND drid=:new.drid;
			SELECT to_date(to_char(ENDHOUR,'HH24:MI'),'HH24:MI') INTO FIN FROM schedule s WHERE s.day='lunes' AND drid=:new.drid;
		ELSIF day='TUESDAY' THEN 
			SELECT to_date(to_char(STARTHOUR,'HH24:MI'),'HH24:MI') INTO INICIO FROM schedule s WHERE s.day='martes' AND drid=:new.drid;
			SELECT to_date(to_char(ENDHOUR,'HH24:MI'),'HH24:MI') INTO FIN FROM schedule s WHERE s.day='martes' AND drid=:new.drid;			
		ELSIF day='WEDNESDAY' THEN 
			SELECT to_date(to_char(STARTHOUR,'HH24:MI'),'HH24:MI') INTO INICIO FROM schedule s WHERE s.day='miercoles' AND drid=:new.drid;
			SELECT to_date(to_char(ENDHOUR,'HH24:MI'),'HH24:MI') INTO FIN FROM schedule s WHERE s.day='miercoles' AND drid=:new.drid;
		ELSIF day='THURSDAY' THEN 
			SELECT to_date(to_char(STARTHOUR,'HH24:MI'),'HH24:MI') INTO INICIO FROM schedule s WHERE s.day='jueves' AND drid=:new.drid;
			SELECT to_date(to_char(ENDHOUR,'HH24:MI'),'HH24:MI') INTO FIN FROM schedule s WHERE s.day='jueves' AND drid=:new.drid;			
		ELSIF day='FRIDAY' THEN 
			SELECT to_date(to_char(STARTHOUR,'HH24:MI'),'HH24:MI') INTO INICIO FROM schedule s WHERE s.day='viernes' AND drid=:new.drid;
			SELECT to_date(to_char(ENDHOUR,'HH24:MI'),'HH24:MI') INTO FIN FROM schedule s WHERE s.day='viernes' AND drid=:new.drid;			
		ELSIF day='SATURDAY' THEN 
			SELECT to_date(to_char(STARTHOUR,'HH24:MI'),'HH24:MI') INTO INICIO FROM schedule s WHERE s.day='sabado' AND drid=:new.drid;
			SELECT to_date(to_char(ENDHOUR,'HH24:MI'),'HH24:MI') INTO FIN FROM schedule s WHERE s.day='sabado' AND drid=:new.drid;			
		ELSIF day='SUNDAY' THEN 
			SELECT to_date(to_char(STARTHOUR,'HH24:MI'),'HH24:MI') INTO INICIO FROM schedule s WHERE s.day='domingo' AND drid=:new.drid;
			SELECT to_date(to_char(ENDHOUR,'HH24:MI'),'HH24:MI') INTO FIN FROM schedule s WHERE s.day='domingo' AND drid=:new.drid;			
		END IF;

		IF NOW<INICIO OR NOW>FIN THEN			
			raise_application_error(-20000, 'Fuera de horario');
		END IF;
	END;
/


CREATE SEQUENCE patientID_seq
minvalue 1
maxvalue 999
increment by 1;

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

CREATE VIEW patient_data AS SELECT pfname,plname nombre,phone,email FROM Patient;

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
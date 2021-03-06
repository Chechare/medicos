-------DOCTOR---------

INSERT INTO DOCTOR 
VALUES ('D01','Gabriel','Perez Osuna','Neurocirujano',to_date('1:00','HH24:MI'));

INSERT INTO DOCTOR 
VALUES ('D02','Martin','Rosas Marquez','Pediatra',to_date('00:45','HH24:MI'));

INSERT INTO DOCTOR 
VALUES ('D03','Paola','Hernandez Bojorquez','Ornitolarringologa',to_date('00:30','HH24:MI'));

-------PATIENTS---------

INSERT INTO PATIENT
VALUES ('P001','Andrea','Lopez Pineda','33123456','andrea_moxi@gmail.com');

INSERT INTO PATIENT
VALUES ('P002','Martin','Martinez Martinez','33234561','martin3@gmail.com');

INSERT INTO PATIENT
VALUES ('P003','Maria de la Concepcion','Pureza de la Hoya','33345612','maryconchita@gmail.com');

INSERT INTO PATIENT
VALUES ('P004','Esteban Julio Ricardo','Montoya de la Rosa Ramirez','33234561','esteban34@gmail.com');

-------ADMINS---------

INSERT INTO ADMIN
VALUES('secre1','contra1');

INSERT INTO ADMIN
VALUES('petra','abc123');

-------SCHEDULES---------

INSERT INTO SCHEDULE VALUES('domingo','D01',to_date('10:00','HH24:MI'),to_date('17:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('lunes','D01',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('martes','D01',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('miercoles','D01',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('jueves','D01',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('viernes','D01',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('sabado','D01',to_date('10:00','HH24:MI'),to_date('20:00','HH24:MI'));

INSERT INTO SCHEDULE VALUES('domingo','D02',to_date('10:00','HH24:MI'),to_date('17:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('lunes','D02',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('martes','D02',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('miercoles','D02',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('jueves','D02',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('viernes','D02',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('sabado','D02',to_date('10:00','HH24:MI'),to_date('20:00','HH24:MI'));

INSERT INTO SCHEDULE VALUES('domingo','D03',to_date('10:00','HH24:MI'),to_date('17:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('lunes','D03',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('martes','D03',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('miercoles','D03',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('jueves','D03',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('viernes','D03',to_date('7:00','HH24:MI'),to_date('20:00','HH24:MI'));
INSERT INTO SCHEDULE VALUES('sabado','D03',to_date('10:00','HH24:MI'),to_date('20:00','HH24:MI'));

-------APPOINTMENTS---------

INSERT INTO APPOINTMENT
VALUES('P003','D01',to_date('2014-7-7 16:30','YYYY-MM-DD HH24:MI:'),'tengo dolor de cabeza y no se que hacer al respecto','2');

INSERT INTO APPOINTMENT
VALUES('P002','D03',to_date('2014-5-5 16:30','YYYY-MM-DD HH24:MI:'),'a mi hija le duele la panza y tiene diarrea','0');

INSERT INTO APPOINTMENT
VALUES('P004','D02',to_date('2014-6-6 16:30','YYYY-MM-DD HH24:MI:'),'tengo calentura y vomito desde hace 2 dias','1');
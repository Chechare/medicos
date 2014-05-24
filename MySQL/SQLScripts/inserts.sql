/*-------DOCTOR---------*/

INSERT INTO DOCTOR 
VALUES ('D01','Gabriel','Perez Osuna','Neurocirujano',TIME('1:00'));

INSERT INTO DOCTOR 
VALUES ('D02','Martin','Rosas Marquez','Pediatra',TIME('00:45'));

INSERT INTO DOCTOR 
VALUES ('D03','Paola','Hernandez Bojorquez','Ornitolarringologa',TIME('00:30'));

/*-------PATIENTS---------*/

INSERT INTO PATIENT
VALUES ('P001','Andrea','Lopez Pineda','33123456','andrea_moxi@gmail.com');

INSERT INTO PATIENT
VALUES ('P002','Martin','Martinez Martinez','33234561','martin3@gmail.com');

INSERT INTO PATIENT
VALUES ('P003','Maria de la Concepcion','Pureza de la Hoya','33345612','maryconchita@gmail.com');

INSERT INTO PATIENT
VALUES ('P004','Esteban Julio Ricardo','Montoya de la Rosa Ramirez','33234561','esteban34@gmail.com');

/*-------SCHEDULES---------*/

INSERT INTO SCHEDULE VALUES('domingo','D01',TIME('10:00'),TIME('17:00'));
INSERT INTO SCHEDULE VALUES('lunes','D01',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('martes','D01',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('miercoles','D01',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('jueves','D01',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('viernes','D01',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('sabado','D01',TIME('10:00'),TIME('20:00'));

INSERT INTO SCHEDULE VALUES('domingo','D02',TIME('10:00'),TIME('17:00'));
INSERT INTO SCHEDULE VALUES('lunes','D02',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('martes','D02',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('miercoles','D02',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('jueves','D02',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('viernes','D02',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('sabado','D02',TIME('10:00'),TIME('20:00'));

INSERT INTO SCHEDULE VALUES('domingo','D03',TIME('10:00'),TIME('17:00'));
INSERT INTO SCHEDULE VALUES('lunes','D03',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('martes','D03',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('miercoles','D03',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('jueves','D03',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('viernes','D03',TIME('7:00'),TIME('20:00'));
INSERT INTO SCHEDULE VALUES('sabado','D03',TIME('10:00'),TIME('20:00'));

/*-------APPOINTMENTS---------*/

INSERT INTO APPOINTMENT
VALUES('P003','D01',TIME('2014-7-7 16:30'),'tengo dolor de cabeza y no se que hacer al respecto','C');

INSERT INTO APPOINTMENT
VALUES('P002','D03',TIME('2014-5-5 16:30'),'a mi hija le duele la panza y tiene diarrea','P');

INSERT INTO APPOINTMENT
VALUES('P004','D02',TIME('2014-6-6 16:30'),'tengo calentura y vomito desde hace 2 dias','A');

/*------Admin------*/
INSERT INTO ADMIN
VALUES(6,"Chechare","123456");

INSERT INTO ADMIN
VALUES(2,"YoabP","qwerty");
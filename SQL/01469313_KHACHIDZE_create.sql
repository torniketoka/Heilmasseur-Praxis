CREATE TABLE Arzt
(
ArztID INTEGER NOT NULL,
aNachname  VARCHAR(50),
aVorname VARCHAR(30),
aFachgebiet VARCHAR(30) DEFAULT 'NEUROLOGE',
CONSTRAINT arzt_pk PRIMARY KEY (ArztID)
);


CREATE TABLE Patient
(
PatientID INTEGER NOT NULL,
pNachname VARCHAR(50),
pVorname  VARCHAR(30),
pPLZ NUMBER(4,0),
pOrt VARCHAR(30),
pStrasse VARCHAR(80),
Gebdat DATE,
ArztID INTEGER NOT NULL,
Diagnosse VARCHAR(30),
AusstellungsDatum DATE,
CONSTRAINT patient_arzt_fk FOREIGN KEY (ArztID) REFERENCES Arzt (ArztID) ON DELETE CASCADE,
CONSTRAINT patient_pk PRIMARY KEY (PatientID)
);


CREATE TABLE Heilmasseur 
(
HeilmasseurID INTEGER NOT NULL,
hNachname VARCHAR(50),
hVorname  VARCHAR(50),
Alt NUMBER(2),
CHECK (Alt>=18),
Tnummer VARCHAR(15) UNIQUE,
leitetHeilmasseurID INTEGER NOT NULL,
CONSTRAINT leitetHeilmasseurid_fk FOREIGN KEY (leitetHeilmasseurID) REFERENCES Heilmasseur(HeilmasseurID) ON DELETE CASCADE, 
CONSTRAINT heilmasseur_pk PRIMARY KEY (HeilmasseurID)
);


CREATE TABLE Praxisgemeinschaft
(
PgID INTEGER NOT NULL,
pgname VARCHAR(30),
CONSTRAINT praxisgemeinschaft_pk PRIMARY KEY (PgID)
);


CREATE TABLE Behandlung
(
PatientID INTEGER NOT NULL,
HeilmasseurID INTEGER NOT NULL,
PgID INTEGER NOT NULL,
BhDatum DATE,
BArt VARCHAR(30),
BPreis FLOAT,
CONSTRAINT behandelt_patient_fk FOREIGN KEY (PatientID) REFERENCES Patient (PatientID) ON DELETE CASCADE,
CONSTRAINT behandelt_heilmasseur_fk FOREIGN KEY (HeilmasseurID) REFERENCES Heilmasseur (HeilmasseurID) ON DELETE CASCADE,
CONSTRAINT behandelt_pg_fk FOREIGN KEY (PgID) REFERENCES Praxisgemeinschaft (PgID) ON DELETE CASCADE,
CONSTRAINT behandelt_pk PRIMARY KEY (PatientID,HeilmasseurID)
);


CREATE TABLE Praxisraum
(
PgID INTEGER NOT NULL,
Raumnummer INTEGER NOT NULL,
prName VARCHAR(30),
CONSTRAINT praxisraum_pk PRIMARY KEY (PgID,Raumnummer)
);


CREATE TABLE Rechnung
(
Rechnungsnummer INTEGER NOT NULL,
Rechnungsdatum DATE,
Summe FLOAT NOT NULL,
PatientID INTEGER NOT NULL,
Versicherungsart VARCHAR(30),
CONSTRAINT Pat_rechnung_fk FOREIGN KEY (PatientID) REFERENCES Patient (PatientID) ON DELETE CASCADE,
CONSTRAINT rechnung_pk PRIMARY KEY (Rechnungsnummer)
);


CREATE TABLE GKV
(
Rechnungsnummer INTEGER NOT NULL,
Tnummer VARCHAR(15),
Website VARCHAR(30),
Fax VARCHAR(30),
CONSTRAINT gkv_rechnung_fk FOREIGN KEY (Rechnungsnummer) REFERENCES Rechnung (Rechnungsnummer) ON DELETE CASCADE,
CONSTRAINT gkv_pk PRIMARY KEY (Rechnungsnummer)
);


CREATE TABLE Privat
(
Rechnungsnummer INTEGER NOT NULL,
Begrundung VARCHAR(30),
Betrag FLOAT NOT NULL,
CONSTRAINT privat_rechnung_fk FOREIGN KEY (Rechnungsnummer) REFERENCES Rechnung (Rechnungsnummer) ON DELETE CASCADE,
CONSTRAINT privat_pk PRIMARY KEY (Rechnungsnummer)
);




CREATE SEQUENCE seq_hmid
START WITH 1
INCREMENT BY 1;

  
CREATE OR REPLACE TRIGGER seq_hmid
BEFORE INSERT
ON Heilmasseur
FOR EACH ROW
BEGIN
:new.HeilmasseurID := seq_hmid.nextval;
END;
/


CREATE SEQUENCE seq_arzid
START WITH 1
INCREMENT BY 1;

  
CREATE OR REPLACE TRIGGER seq_arzid
BEFORE INSERT
ON Arzt
FOR EACH ROW
BEGIN
:new.ArztID := seq_arzid.nextval;
END;
/


CREATE SEQUENCE seq_patid
START WITH 1
INCREMENT BY 1;

  
CREATE OR REPLACE TRIGGER seq_patid
BEFORE INSERT
ON Patient
FOR EACH ROW
BEGIN
:new.PatientID := seq_patid.nextval;
END;
/


CREATE SEQUENCE seq_rechnum
START WITH 1
INCREMENT BY 1;

  
CREATE OR REPLACE TRIGGER seq_rechnum
BEFORE INSERT
ON Rechnung
FOR EACH ROW
BEGIN
:new.Rechnungsnummer := seq_rechnum.nextval;
END;
/

CREATE SEQUENCE seq_prx
START WITH 1
INCREMENT BY 1;

  
CREATE OR REPLACE TRIGGER seq_prx
BEFORE INSERT
ON Praxisgemeinschaft
FOR EACH ROW
BEGIN
:new.PgID := seq_prx.nextval;
END;
/


/*Zeigt anzahl der Patienten, die mehr als 30 Jahre sind*/
CREATE VIEW c_alt (countalt) AS
SELECT COUNT(Alt)
FROM Heilmasseur 
WHERE Alt > 30;


/*Zeigt summe der rechnung, die in gleichen tag von patienten bezahlt ist*/
CREATE VIEW rh_summ AS
SELECT Rechnungsdatum, SUM(Summe) S_summe
FROM Rechnung
GROUP BY Rechnungsdatum
HAVING SUM(Summe)>200;

/*Zeigt Patient name und PatientID .. von welche Arzt verordnet ist */
CREATE VIEW schow_pa AS 
SELECT pNachname, PatientID, aFachgebiet
FROM Patient
INNER JOIN Arzt
ON Patient.ArztID = Arzt.ArztID;






-- -----------------------------------------------------
-- Schema Biblioteca
-- -----------------------------------------------------
DROP DATABASE IF EXISTS Biblioteca;
CREATE DATABASE Biblioteca DEFAULT CHARACTER SET utf8;
USE Biblioteca;

-- -----------------------------------------------------
-- Table Generi
-- -----------------------------------------------------
CREATE TABLE Generi (
  idGenere INT NOT NULL,
  Descrizione VARCHAR(45) NOT NULL,
  PRIMARY KEY (idGenere)
);


-- -----------------------------------------------------
-- Table Tipologie
-- -----------------------------------------------------
CREATE TABLE Tipologie (
  idTipologia INT NOT NULL,
  Descrizione VARCHAR(45) NOT NULL,
  PRIMARY KEY (idTipologia)
);


-- -----------------------------------------------------
-- Table Editori
-- -----------------------------------------------------
CREATE TABLE Editori (
  idEditore INT NOT NULL,
  Nome VARCHAR(45) NOT NULL,
  Descrizione VARCHAR(200) NULL,
  PRIMARY KEY (idEditore),

  FULLTEXT(Nome)
);


-- -----------------------------------------------------
-- Table Collane
-- -----------------------------------------------------
CREATE TABLE Collane (
  idCollana INT NOT NULL,
  Nome VARCHAR(80) NOT NULL,
  PRIMARY KEY (idCollana),

  FULLTEXT(Nome)
);


-- -----------------------------------------------------
-- Table Lingue
-- -----------------------------------------------------
CREATE TABLE Lingue (
  idLingua INT NOT NULL,
  Descrizione VARCHAR(20) NOT NULL,
  Abbreviazione VARCHAR(3) NOT NULL,
  PRIMARY KEY (idLingua)
);


-- -----------------------------------------------------
-- Table Libri
-- -----------------------------------------------------
CREATE TABLE Libri (
  ISBN CHAR(13) NOT NULL,
  Titolo VARCHAR(80) NOT NULL,
  Descrizione VARCHAR(200) NULL,
  AnnoPubblicazione INT NULL,
  DataAggiunta DATE NOT NULL,
  idGenere INT NOT NULL,
  idTipo INT NOT NULL,
  idEditore INT NOT NULL,
  idCollana INT NULL,
  idLingua INT NOT NULL,
  PRIMARY KEY (ISBN),
  FOREIGN KEY (idGenere) REFERENCES Generi(idGenere),
  FOREIGN KEY (idTipo) REFERENCES Tipologie(idTipologia),
  FOREIGN KEY (idEditore) REFERENCES Editori(idEditore),
  FOREIGN KEY (idCollana) REFERENCES Collane(idCollana),
  FOREIGN KEY (idLingua) REFERENCES Lingue(idLingua),

  FULLTEXT(Titolo)
);


-- -----------------------------------------------------
-- Table Nazionalita
-- -----------------------------------------------------
CREATE TABLE Nazionalita (
  idNazionalita INT NOT NULL,
  Descrizione VARCHAR(45) NOT NULL,
  PRIMARY KEY (idNazionalita)
);


-- -----------------------------------------------------
-- Table Citta
-- -----------------------------------------------------
CREATE TABLE Citta (
  idCitta INT NOT NULL AUTO_INCREMENT,
  Nome VARCHAR(45) NOT NULL,
  Provincia CHAR(2) NOT NULL,
  PRIMARY KEY (idCitta)
);


-- -----------------------------------------------------
-- Table Autori
-- -----------------------------------------------------
CREATE TABLE Autori (
  idAutore INT NOT NULL,
  NomeAutore VARCHAR(45) NOT NULL,
  CognomeAutore VARCHAR(45) NOT NULL,
  DataNascita DATE NOT NULL,
  DataMorte DATE NULL,
  Descrizione VARCHAR(200) NULL,
  NomeArte VARCHAR(45) NULL,
  idNazionalita INT NOT NULL,
  idCittaNascita INT NOT NULL,
  idCittaMorte INT NULL,
  PRIMARY KEY (idAutore),
  FOREIGN KEY (idNazionalita) REFERENCES Nazionalita(idNazionalita),
  FOREIGN KEY (idCittaNascita) REFERENCES Citta(idCitta),
  FOREIGN KEY (idCittaMorte) REFERENCES Citta(idCitta),

  FULLTEXT(NomeAutore),
  FULLTEXT(CognomeAutore),
  FULLTEXT(NomeArte)
);


-- -----------------------------------------------------
-- Table Ruolo_Scrittura
-- -----------------------------------------------------
CREATE TABLE Ruolo_Scrittura (
  idRuolo INT NOT NULL,
  Descrizione VARCHAR(45) NOT NULL,
  PRIMARY KEY (idRuolo)
);


-- -----------------------------------------------------
-- Table Autori_Libri
-- -----------------------------------------------------
CREATE TABLE Autori_Libri (
  idAutore INT NOT NULL,
  ISBNLibro CHAR(13) NOT NULL,
  DataContribuzione DATE NULL,
  idRuoloScrittura INT NOT NULL,
  PRIMARY KEY (idAutore, ISBNLibro),
  FOREIGN KEY (idAutore) REFERENCES Autori(idAutore),
  FOREIGN KEY (ISBNLibro) REFERENCES Libri(ISBN),
  FOREIGN KEY (idRuoloScrittura) REFERENCES Ruolo_Scrittura(idRuolo)
);


-- -----------------------------------------------------
-- Table Enti
-- -----------------------------------------------------
CREATE TABLE Enti (
  idEnte INT NOT NULL,
  NomeEnte VARCHAR(45) NOT NULL,
  PRIMARY KEY (idEnte)
);


-- -----------------------------------------------------
-- Table Biblioteche
-- -----------------------------------------------------
CREATE TABLE Biblioteche (
  idBiblioteca INT NOT NULL,
  Email VARCHAR(45) NOT NULL,
  TelefonoFisso VARCHAR(15) NULL,
  Principale TINYINT NOT NULL,
  ViaPzz VARCHAR(45) NOT NULL,
  NumeroCivico SMALLINT NULL,
  Citta INT NOT NULL,
  SitoWeb VARCHAR(45) NULL,
  NomeBiblioteca VARCHAR(45) NOT NULL,
  EnteAppartenente INT NOT NULL,
  PRIMARY KEY (idBiblioteca),
  FOREIGN KEY (EnteAppartenente) REFERENCES Enti(idEnte),
  FOREIGN KEY (Citta) REFERENCES Citta(idCitta)
);


-- -----------------------------------------------------
-- Table Edifici
-- -----------------------------------------------------
CREATE TABLE Edifici (
  idEdificio INT NOT NULL,
  Descrizione VARCHAR(45) NULL,
  idBiblioteca INT NOT NULL,
  PRIMARY KEY (idEdificio),
  FOREIGN KEY (idBiblioteca) REFERENCES Biblioteche(idBiblioteca)
);


-- -----------------------------------------------------
-- Table Piani
-- -----------------------------------------------------
CREATE TABLE Piani (
  idPiano INT NOT NULL,
  Numero INT NOT NULL,
  idEdificio INT NOT NULL,
  PRIMARY KEY (idPiano),
  FOREIGN KEY (idEdificio) REFERENCES Edifici(idEdificio)
);


-- -----------------------------------------------------
-- Table Sezioni
-- -----------------------------------------------------
CREATE TABLE Sezioni (
  idSezione INT NOT NULL AUTO_INCREMENT,
  Descrizione VARCHAR(45) NULL,
  idPiano INT NOT NULL,
  PRIMARY KEY (idSezione),
  FOREIGN KEY (idPiano) REFERENCES Piani(idPiano)
);


-- -----------------------------------------------------
-- Table Armadi
-- -----------------------------------------------------
CREATE TABLE Armadi (
  idArmadio INT NOT NULL AUTO_INCREMENT,
  Descrizione VARCHAR(45) NOT NULL,
  idSezione INT NOT NULL,
  PRIMARY KEY (idArmadio),
  FOREIGN KEY (idSezione) REFERENCES Sezioni(idSezione)
);


-- -----------------------------------------------------
-- Table Ripiani
-- -----------------------------------------------------
CREATE TABLE Ripiani (
  idRipiano INT NOT NULL AUTO_INCREMENT,
  idArmadio INT NOT NULL,
  NumeroRipiano VARCHAR(4) NOT NULL,
  PRIMARY KEY (idRipiano),
  FOREIGN KEY (idArmadio) REFERENCES Armadi(idArmadio)
);


-- -----------------------------------------------------
-- Table Concessioni
-- -----------------------------------------------------
CREATE TABLE Concessioni (
  idConcessioni INT NOT NULL,
  DataPrestito DATE NOT NULL,
  DataConsegna DATE NULL,
  DataScadenza DATE NOT NULL,
  idBiblioteca INT NOT NULL,
  PRIMARY KEY (idConcessioni),
  FOREIGN KEY (idBiblioteca) REFERENCES Biblioteche(idBiblioteca)
);


-- -----------------------------------------------------
-- Table Copie
-- -----------------------------------------------------
CREATE TABLE Copie (
  idCopia INT NOT NULL AUTO_INCREMENT,
  Prestato TINYINT NOT NULL,
  ISBN CHAR(13) NOT NULL,
  idRipiano INT NOT NULL,
  ProprietaDi INT NULL,
  PRIMARY KEY (idCopia),
  FOREIGN KEY (ISBN) REFERENCES Libri(ISBN),
  FOREIGN KEY (idRipiano) REFERENCES Ripiani(idRipiano),
  FOREIGN KEY (ProprietaDi) REFERENCES Concessioni(idConcessioni)
);


-- -----------------------------------------------------
-- Table Utenti
-- -----------------------------------------------------
CREATE TABLE Utenti (
  CodFiscale CHAR(16) NOT NULL,
  Nome VARCHAR(45) NOT NULL,
  Cognome VARCHAR(45) NOT NULL,
  Email VARCHAR(45) NOT NULL,
  ViaPzz VARCHAR(45) NOT NULL,
  NumeroCivico SMALLINT NOT NULL,
  TelefonoCellulare VARCHAR(15) NULL,
  TelefonoFisso VARCHAR(15) NULL,
  Validato TINYINT NOT NULL,
  CodiceValidazione VARCHAR(45) NULL,
  DataValidazione DATE NULL,
  Sesso CHAR(1) NOT NULL,
  Password CHAR(32) NOT NULL,
  Citta INT NOT NULL,
  DataNascita DATE NOT NULL,
  Permessi TINYINT NOT NULL DEFAULT 3,
  PRIMARY KEY (CodFiscale),
  FOREIGN KEY (Citta) REFERENCES Citta(idCitta)
);


-- -----------------------------------------------------
-- Table Prestiti
-- -----------------------------------------------------
CREATE TABLE Prestiti (
  idPrestito INT NOT NULL AUTO_INCREMENT,
  DataConsegna DATETIME NOT NULL,
  DataRiconsegna DATETIME NULL,
  idCopia INT NOT NULL,
  codFiscaleUtente CHAR(16) NOT NULL,
  bibConsegna CHAR(16) NOT NULL,
  bibRiconsegna CHAR(16) NULL,
  PRIMARY KEY (idPrestito),
  FOREIGN KEY (idCopia) REFERENCES Copie(idCopia),
  FOREIGN KEY (codFiscaleUtente) REFERENCES Utenti(CodFiscale)
    ON DELETE CASCADE,
  FOREIGN KEY (bibConsegna) REFERENCES Utenti(CodFiscale)
    ON DELETE CASCADE,
  FOREIGN KEY (bibRiconsegna) REFERENCES Utenti(CodFiscale)
    ON DELETE CASCADE
);


-- -----------------------------------------------------
-- Table Lista_Interessi
-- -----------------------------------------------------
CREATE TABLE Lista_Interessi (
  codFiscaleUtente CHAR(16) NOT NULL,
  ISBNLibro CHAR(13) NOT NULL,
  Commento VARCHAR(45) NULL,
  DataInserimento DATE NOT NULL,
  PRIMARY KEY (codFiscaleUtente, ISBNLibro),
  FOREIGN KEY (codFiscaleUtente) REFERENCES Utenti(CodFiscale)
    ON DELETE CASCADE,
  FOREIGN KEY (ISBNLibro) REFERENCES Libri(ISBN)
);
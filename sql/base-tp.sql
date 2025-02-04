-- Primary key = PK
-- Foreign key = FK
-- -Espece(id(PK),NomEspece,PoidsMinVente,PoidsMax,PrixParKg,PerteParJour,NbJoursAvantDeMourir)
-- -Animal(id(PK),idEspece(FK),PoidsInitial,NomAnimal)
-- -Nourriture(id(PK),pourcentageGain,idEspece(FK),NomNourriture)
-- -HistoriqueAchatNourriture(id(PK),dateAchat,quantite,idNourriture(FK),prixUnitaire)
-- -HistoriqueAchatAnimal(id(PK),idAnimal(FK),dateAchat,montant)
-- -HistoriqueVente(id(PK),idAnimal(FK),dateVente,montant)
-- -HistoriqueAlimentation(id(PK),idAnimal(FK),dateAlimentation,quantite,idNourriture(FK))
-- -TypeTransaction(id(PK),nomType)
-- -TransactionCaisse(id(PK),dateTransaction,typeId(FK),montant)
-- -AnimalDecede(id(PK),dateDeces,idAnimal(FK))


create database elevage;
use elevage;


-- Table Espece
CREATE TABLE elevage_Espece (
    id INT PRIMARY KEY AUTO_INCREMENT,
    NomEspece VARCHAR(255) NOT NULL,
    PoidsMinVente DECIMAL(10, 2),
    PoidsMax DECIMAL(10, 2),
    PrixParKg DECIMAL(10, 2),
    PerteParJour DECIMAL(10, 2),
    quantite int,
    prixUnitaire int,
    NbJoursAvantDeMourir INT,
    cheminImage VARCHAR(100) default 'No_image_available.png'
);

-- Table Animal
CREATE TABLE elevage_Animal (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idEspece INT,
    PoidsInitial DECIMAL(10, 2),
    PoidsActuel DECIMAL(10, 2),
    NomAnimal VARCHAR(255),
    autoVente int,
    FOREIGN KEY (idEspece) REFERENCES elevage_Espece(id)
);

-- Table Nourriture
CREATE TABLE elevage_Nourriture (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pourcentageGain DECIMAL(5, 2),
    idEspece INT,
    NomNourriture VARCHAR(255),
    prixUnitaire int,
    FOREIGN KEY (idEspece) REFERENCES elevage_Espece(id)
);

-- Table HistoriqueAchatNourriture
CREATE TABLE elevage_HistoriqueAchatNourriture (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dateAchat DATE,
    quantite DECIMAL(10, 2),
    idNourriture INT,
    prixUnitaire DECIMAL(10, 2),
    FOREIGN KEY (idNourriture) REFERENCES elevage_Nourriture(id)
);

-- Table HistoriqueAchatAnimal
CREATE TABLE elevage_HistoriqueAchatAnimal (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT,
    dateAchat DATE,
    montant DECIMAL(10, 2),
    FOREIGN KEY (idAnimal) REFERENCES elevage_Animal(id)
);

-- Table HistoriqueVente
CREATE TABLE elevage_HistoriqueVente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT,
    dateVente DATE,
    montant DECIMAL(10, 2),
    FOREIGN KEY (idAnimal) REFERENCES elevage_Animal(id)
);

-- Table HistoriqueAlimentation
CREATE TABLE elevage_HistoriqueAlimentation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT,
    dateAlimentation DATE,
    quantite DECIMAL(10, 2),
    idNourriture INT,
    FOREIGN KEY (idAnimal) REFERENCES elevage_Animal(id),
    FOREIGN KEY (idNourriture) REFERENCES elevage_Nourriture(id)
);

-- Table TypeTransaction
CREATE TABLE elevage_TypeTransaction (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomType VARCHAR(255) NOT NULL
);

-- Table TransactionCaisse
CREATE TABLE elevage_TransactionCaisse (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dateTransaction DATE,
    typeId INT,
    montant DECIMAL(10, 2),
    montantActuel DECIMAL(10, 2) default 0,
    FOREIGN KEY (typeId) REFERENCES elevage_TypeTransaction(id)
);

-- Table AnimalDecede
CREATE TABLE elevage_AnimalDecede (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dateDeces DATE,
    idAnimal INT,
    FOREIGN KEY (idAnimal) REFERENCES elevage_Animal(id)
);

-- Table HistoriquePoids
CREATE TABLE elevage_HistoriquePoids(
    id INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal int,
    poids DECIMAL(10,2),
    dateStockage DATE,
    FOREIGN KEY (idAnimal) REFERENCES elevage_Animal(id)
);

-- Table EspeceSupprime
CREATE TABLE elevage_EspeceSupprime(
    id INT PRIMARY KEY AUTO_INCREMENT,
    idEspece int,
    FOREIGN KEY (idEspece) REFERENCES elevage_Espece(id)
);

--Table NourritureSupprime
CREATE TABLE elevage_NourritureSupprime(
    id INT PRIMARY KEY AUTO_INCREMENT,
    idNourriture int,
    FOREIGN KEY (idNourriture) REFERENCES elevage_Nourriture(id)
);


DELIMITER $$

CREATE TRIGGER updateApresNourrir
AFTER INSERT ON elevage_HistoriquePoids
FOR EACH ROW
BEGIN
    UPDATE elevage_Animal
    SET PoidsActuel = NEW.poids
    WHERE id = NEW.idAnimal;
END $$

DELIMITER ;
-- Table Espece
INSERT INTO elevage_Espece (NomEspece, PoidsMinVente, PoidsMax, PrixParKg, PerteParJour, quantite, prixUnitaire, NbJoursAvantDeMourir)
VALUES
('Poulet', 1.50, 3.00, 5.00, 0.10, 100, 2, 30),
('Canard', 2.00, 4.00, 6.50, 0.15, 80, 3, 25),
('Cochon', 50.00, 150.00, 4.00, 0.50, 50, 10, 60),
('Boeuf', 200.00, 500.00, 8.00, 1.00, 30, 20, 90);

-- Table Animal
INSERT INTO elevage_Animal (idEspece, PoidsInitial, PoidsActuel, NomAnimal, autoVente)
VALUES
(1, 1.60, 1.70, 'Poulet1', 0),
(1, 1.55, 1.65, 'Poulet2', 1),
(2, 2.10, 2.20, 'Canard1', 0),
(2, 2.05, 2.15, 'Canard2', 1),
(3, 60.00, 65.00, 'Cochon1', 0),
(3, 55.00, 60.00, 'Cochon2', 1),
(4, 250.00, 260.00, 'Boeuf1', 0),
(4, 240.00, 250.00, 'Boeuf2', 1);


-- Table Nourriture
INSERT INTO elevage_Nourriture (pourcentageGain, idEspece, NomNourriture, prixUnitaire)
VALUES
(0.20, 1, 'Grains de maïs', 1),
(0.25, 1, 'Grains de blé', 2),
(0.30, 2, 'Grains de riz', 3),
(0.35, 2, 'Grains de soja', 4),
(0.40, 3, 'Mélange pour cochons', 5),
(0.45, 3, 'Aliments concentrés', 6),
(0.50, 4, 'Foin', 7),
(0.55, 4, 'Aliments pour bovins', 8);

--- Table TypeTransaction
INSERT INTO elevage_TypeTransaction (nomType)
VALUES
('Achat Animal'),
('Vente Animal'),
('Achat Nourriture'),
('Vente Nourriture'),
('Depot capitale');

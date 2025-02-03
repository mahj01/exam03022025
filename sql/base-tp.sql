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
    NbJoursAvantDeMourir INT
);

-- Table Animal
CREATE TABLE elevage_Animal (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idEspece INT,
    PoidsInitial DECIMAL(10, 2),
    PoidsActuel DECIMAL(10, 2),
    NomAnimal VARCHAR(255),
    FOREIGN KEY (idEspece) REFERENCES elevage_Espece(id)
);

-- Table Nourriture
CREATE TABLE elevage_Nourriture (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pourcentageGain DECIMAL(5, 2),
    idEspece INT,
    NomNourriture VARCHAR(255),
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


CREATE TRIGGER updateApresNourrir
AFTER INSERT
ON elevage_HistoriquePoids
FOR EACH ROW
BEGIN
    UPDATE elevage_Animal
    SET PoidsActuel = NEW.poids
    WHERE id = NEW.idAnimal;
END;

INSERT INTO elevage_Espece (NomEspece, PoidsMinVente, PoidsMax, PrixParKg, PerteParJour, NbJoursAvantDeMourir) VALUES
('Boeuf', 300.00, 500.00, 10.50, 0.50, 30),
('Poulet', 1.50, 3.00, 5.00, 0.10, 10),
('Porc', 100.00, 200.00, 8.00, 0.30, 20);

INSERT INTO elevage_Animal (idEspece, PoidsInitial, NomAnimal) VALUES
(1, 320.00, 'Bessie'),
(2, 1.80, 'Poulet1'),
(3, 120.00, 'Porc1'),
(1, 350.00, 'Bella'),
(2, 2.00, 'Poulet2');

INSERT INTO elevage_Nourriture (pourcentageGain, idEspece, NomNourriture) VALUES
(5.00, 1, 'Foin'),
(3.00, 2, 'Grains'),
(4.00, 3, 'Mais'),
(6.00, 1, 'Aliment concentre');

INSERT INTO elevage_HistoriqueAchatNourriture (dateAchat, quantite, idNourriture, prixUnitaire) VALUES
('2023-10-01', 100.00, 1, 2.50),
('2023-10-02', 50.00, 2, 1.00),
('2023-10-03', 200.00, 3, 1.20),
('2023-10-04', 150.00, 4, 3.00);

INSERT INTO elevage_HistoriqueAchatAnimal (idAnimal, dateAchat, montant) VALUES
(1, '2023-09-25', 500.00),
(2, '2023-09-26', 10.00),
(3, '2023-09-27', 200.00),
(4, '2023-09-28', 550.00),
(5, '2023-09-29', 12.00);

INSERT INTO elevage_HistoriqueVente (idAnimal, dateVente, montant) VALUES
(1, '2023-10-10', 800.00),
(2, '2023-10-11', 15.00),
(3, '2023-10-12', 300.00);

INSERT INTO elevage_HistoriqueAlimentation (idAnimal, dateAlimentation, quantite, idNourriture) VALUES
(1, '2023-10-01', 10.00, 1),
(2, '2023-10-02', 2.00, 2),
(3, '2023-10-03', 5.00, 3),
(4, '2023-10-04', 8.00, 4),
(5, '2023-10-05', 1.50, 2);

INSERT INTO elevage_TypeTransaction (nomType) VALUES
('Achat Nourriture'),
('Achat Animal'),
('Vente Animal'),
('Autre');

INSERT INTO elevage_TransactionCaisse (dateTransaction, typeId, montant) VALUES
('2023-10-01', 1, 250.00),
('2023-10-02', 2, 500.00),
('2023-10-03', 3, 800.00),
('2023-10-04', 4, 100.00);

INSERT INTO elevage_AnimalDecede (dateDeces, idAnimal) VALUES
('2023-10-05', 5);
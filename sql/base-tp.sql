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
('Vache', 400.00, 800.00, 3.50, 0.10, 20, 2000, 365),
('Mouton', 45.00, 100.00, 5.00, 0.05, 30, 1500, 180),
('Poulet', 1.00, 5.00, 10.00, 0.02, 100, 30, 60);

-- Table Animal
INSERT INTO elevage_Animal (idEspece, PoidsInitial, PoidsActuel, NomAnimal)
VALUES
(1, 450.00, 460.00, 'Vache1'),
(2, 50.00, 55.00, 'Mouton1'),
(3, 2.00, 2.50, 'Poulet1');

-- Table Nourriture
INSERT INTO elevage_Nourriture (pourcentageGain, idEspece, NomNourriture, prixUnitaire)
VALUES
(20.00, 1, 'Herbe', 50),
(15.00, 2, 'Foins', 30),
(25.00, 3, 'Graines', 10);

-- Table HistoriqueAchatNourriture
INSERT INTO elevage_HistoriqueAchatNourriture (dateAchat, quantite, idNourriture, prixUnitaire)
VALUES
('2025-02-01', 100.00, 1, 50),
('2025-02-02', 50.00, 2, 30),
('2025-02-03', 200.00, 3, 10);

-- Table HistoriqueAchatAnimal
INSERT INTO elevage_HistoriqueAchatAnimal (idAnimal, dateAchat, montant)
VALUES
(1, '2025-01-15', 3000.00),
(2, '2025-01-20', 1500.00),
(3, '2025-02-05', 60.00);

-- Table HistoriqueVente
INSERT INTO elevage_HistoriqueVente (idAnimal, dateVente, montant)
VALUES
(1, '2025-03-01', 3500.00),
(2, '2025-03-10', 1700.00),
(3, '2025-02-10', 80.00);

-- Table HistoriqueAlimentation
INSERT INTO elevage_HistoriqueAlimentation (idAnimal, dateAlimentation, quantite, idNourriture)
VALUES
(1, '2025-02-01', 10.00, 1),
(2, '2025-02-02', 5.00, 2),
(3, '2025-02-03', 3.00, 3);

-- Table TypeTransaction
INSERT INTO elevage_TypeTransaction (nomType)
VALUES
('Achat Animal'),
('Vente Animal'),
('Achat Nourriture'),
('Vente Nourriture');

-- Table TransactionCaisse
INSERT INTO elevage_TransactionCaisse (dateTransaction, typeId, montant)
VALUES
('2025-01-10', 1, 3000.00),
('2025-01-20', 2, 3500.00),
('2025-02-01', 3, 500.00),
('2025-02-05', 4, 80.00);

-- Table AnimalDecede
INSERT INTO elevage_AnimalDecede (dateDeces, idAnimal)
VALUES
('2025-03-05', 2),
('2025-03-15', 3);

-- Table HistoriquePoids
INSERT INTO elevage_HistoriquePoids (idAnimal, poids, dateStockage)
VALUES
(1, 460.00, '2025-02-01'),
(2, 55.00, '2025-02-02'),
(3, 2.50, '2025-02-03');

-- Table EspeceSupprime
INSERT INTO elevage_EspeceSupprime (idEspece)
VALUES
(3); -- Supposons que l'espèce Poulet ait été supprimée

-- Table NourritureSupprime
INSERT INTO elevage_NourritureSupprime (idNourriture)
VALUES
(3); -- Supposons que la nourriture Graines ait été supprimée

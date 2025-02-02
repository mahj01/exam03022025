-- Création de la table etudiant
CREATE TABLE etudiant (
    numero_etudiant INT PRIMARY KEY,
    nom VARCHAR(255),
    date_naissance DATE
);

-- Création de la table matiere
CREATE TABLE matiere (
    code_matiere VARCHAR(255) PRIMARY KEY,
    nom_matiere VARCHAR(255),
    coefficient Decimal(10,2)
);

-- Création de la table note
CREATE TABLE note (
    numero_etudiant INT,
    code_matiere VARCHAR(255),
    note Decimal(10,2),
    FOREIGN KEY (numero_etudiant) REFERENCES etudiant(numero_etudiant),
    FOREIGN KEY (code_matiere) REFERENCES matiere(code_matiere)
);

-- Insertion des données dans la table etudiant
INSERT INTO etudiant (numero_etudiant, nom, date_naissance) VALUES
(1, 'Jean Dupont', '2000-01-05'),
(2, 'Marie Martin', '2001-03-12'),
(3, 'Pierre Durand', '1999-07-20'),
(4, 'Sophie Lefevre', '2000-09-15'),
(5, 'Thomas Dubois', '2001-11-25'),
(6, 'Emma Moreau', '1998-04-08'),
(7, 'Lucas Girard', '2000-06-17'),
(8, 'Camille Laurent', '2001-08-30'),
(9, 'Léa Roussel', '1999-02-14'),
(10, 'Nicolas Bonnet', '2000-10-10');

-- Insertion des données dans la table matiere
INSERT INTO matiere (code_matiere, nom_matiere, coefficient) VALUES
('MAT101', 'Mathématiques', 2.0),
('PHY201', 'Physique', 1.5),
('CHM301', 'Chimie', 1.0),
('BIO401', 'Biologie', 1.0);

-- Insertion des données dans la table note
-- Génération de 20 notes aléatoires pour les 10 étudiants et les 4 matières
-- Les notes sont comprises entre 0 et 20
INSERT INTO note (numero_etudiant, code_matiere, note) 
SELECT 
    FLOOR(RAND() * 10) + 1 AS numero_etudiant,
    code_matiere,
    ROUND(RAND() * 20, 2) AS note
FROM
    (SELECT 'MAT101' AS code_matiere
     UNION ALL SELECT 'PHY201'
     UNION ALL SELECT 'CHM301'
     UNION ALL SELECT 'BIO401') matieres
CROSS JOIN
    (SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
     UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) etudiants;

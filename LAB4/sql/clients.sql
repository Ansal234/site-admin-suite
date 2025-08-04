--AUTHOR: ANSAL MUHAMMED
--ASSIGNMENT 4 : LAB 4
--STUDENT ID: 100881383
--INFT2100

--DROP SEQUENCE IF EXISTS clients_id;
--CREATE SEQUENCE clients_id START 1000;

--DROP TABLE IF EXISTS clients;
CREATE TABLE IF NOT EXISTS clients
(
    ClientId SERIAL PRIMARY KEY,
    PhoneNumber VARCHAR(20) NOT NULL,
    Extension VARCHAR(10),
    EmailAddress VARCHAR(255) NOT NULL,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    EnrollDate TIMESTAMP,
    UsersId INT NOT NULL,
    LogoPath VARCHAR(255),
    FOREIGN KEY (UsersId) REFERENCES users_table (Id)
);
INSERT INTO clients (PhoneNumber, Extension, EmailAddress, FirstName, LastName, EnrollDate, LogoPath, UsersId)
VALUES
    ('123-456-7890', '123', 'client1@example.com', 'Remo', 'Dcruz', '2023-09-29','./images/image1.jpeg',1),
    ('987-654-3210', NULL, 'client2@example.com', 'Jane', 'Smith', '2023-09-29','./images/image2.avif',2),
    ('555-123-4567', '789', 'client3@example.com', 'Robert', 'Johnson', '2023-09-29','./images/image3.jpg',3);

SELECT * FROM clients;
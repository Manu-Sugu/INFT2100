-- Manu Sugunakumar
-- 28 October 2023
-- INFT2100 

DROP SEQUENCE IF EXISTS clients_id_seq CASCADE;
CREATE SEQUENCE clients_id_seq START 5000;

DROP TABLE IF EXISTS clients CASCADE;
CREATE TABLE clients(
    id INT PRIMARY KEY DEFAULT nextval('clients_id_seq'),
    email_address VARCHAR(255) UNIQUE,
    first_name VARCHAR(128),
    last_name VARCHAR(128),
    enrol_date TIMESTAMP,
    phone_ext int,
    phone_number VARCHAR(15),
    sales_person_id INT NOT NULL,
    FOREIGN KEY (sales_person_id) REFERENCES users(id),
    logo VARCHAR(255),
);

INSERT INTO clients(email_address, first_name, last_name, enrol_date, phone_ext, phone_number, sales_person_id, logo) VALUES (
    'brook@gmail.com', 'Brook', 'Betty', '2023-10-28 00:02:00', '1234', '1234567890', 1003, 'salesperson'
);

INSERT INTO clients(email_address, first_name, last_name, enrol_date, phone_ext, phone_number, sales_person_id, logo) VALUES (
    'brock@gmail.com', 'Brock', 'Cook', '2023-10-28 00:02:00', '1234', '1234567890', 1003, 'salesperson'
);

INSERT INTO clients(email_address, first_name, last_name, enrol_date, phone_ext, phone_number, sales_person_id, logo) VALUES (
    'truck@gmail.com', 'Truck', 'Car', '2023-10-28 00:02:00', '1234', '1234567890', 1003, 'salesperson'
);

SELECT * FROM clients;
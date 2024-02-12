-- Manu Sugunakumar
-- 28 October 2023
-- INFT2100 
-- This sql files allows you to run all the sql files in order because clients references users there needs to be an order

CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- Drops Sequences in order
DROP SEQUENCE IF EXISTS users_id_seq CASCADE;
DROP SEQUENCE IF EXISTS clients_id_seq CASCADE;
DROP SEQUENCE IF EXISTS calls_id_seq CASCADE;

-- Creates sequence for unique ids
CREATE SEQUENCE users_id_seq START 1000;
CREATE SEQUENCE clients_id_seq START 5000;
CREATE SEQUENCE calls_id_seq START 10000;

-- Drop tables in order
DROP TABLE IF EXISTS calls CASCADE;
DROP TABLE IF EXISTS clients CASCADE;
DROP TABLE IF EXISTS users;

-- Users table creation
CREATE TABLE users(
    id INT PRIMARY KEY DEFAULT nextval('users_id_seq'),
    email_address VARCHAR(255) UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(128),
    last_name VARCHAR(128),
    last_access TIMESTAMP,
    enrol_date TIMESTAMP,
    phone_ext VARCHAR(128),
    type VARCHAR(2),
    logo VARCHAR(255),
    is_active VARCHAR(8)
);

-- Clients table creation
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
    logo VARCHAR(255)
);

CREATE TABLE calls(
    id INT PRIMARY KEY DEFAULT nextval('calls_id_seq'),
    time_of_call TIMESTAMP,
    notes VARCHAR(1024),
    client_id INT,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    logo VARCHAR(255)
);

-- Inserts for users table
INSERT INTO users (email_address, password, first_name, last_name, last_access, enrol_date, phone_ext, type, logo, is_active) VALUES (
    'manu.sugunakumar@dcmail.ca', crypt('password', gen_salt('bf')), 'Manu', 'Sugunakumar', '2023-09-20 00:16:00', '2022-09-20 00:00:00', '1234', 's', 'salesperson', 'active'
);

INSERT INTO users (email_address, password, first_name, last_name, last_access, enrol_date, phone_ext, type, logo, is_active) VALUES (
    'jdoe@dcmail.ca', crypt('password', gen_salt('bf')), 'John', 'Doe', '2023-09-20 00:17:00', '2022-09-20 00:01:00', '1234', 's', 'salesperson', 'active'
);

INSERT INTO users (email_address, password, first_name, last_name, last_access, enrol_date, phone_ext, type, logo, is_active) VALUES (
    'admin@dcmail.ca', crypt('password', gen_salt('bf')), 'Admin', 'User', '2023-09-20 00:18:00', '2022-09-20 00:02:00', '1234', 's', 'salesperson', 'active'
);

INSERT INTO users (email_address, password, first_name, last_name, last_access, enrol_date, phone_ext, type, logo, is_active) VALUES (
    'john.smith@dcmail.ca', crypt('password', gen_salt('bf')), 'John', 'Smith', '2023-10-28 00:18:00', '2023-10-28 00:02:00', '1234', 'a', 'salesperson', 'active'
);

INSERT INTO users (email_address, password, first_name, last_name, last_access, enrol_date, phone_ext, type, logo, is_active) VALUES (
    'jessie.meowth@dcmail.ca', crypt('password', gen_salt('bf')), 'Jessie', 'Meowth', '2023-10-28 00:18:00', '2023-10-28 00:02:00', '1234', 'a', 'salesperson', 'active'
);

INSERT INTO users (email_address, password, first_name, last_name, last_access, enrol_date, phone_ext, type, logo, is_active) VALUES (
    'freddy.chica@dcmail.ca', crypt('password', gen_salt('bf')), 'Freddy', 'Chica', '2023-10-28 00:18:00', '2023-10-28 00:02:00', '1234', 'a', 'salesperson', 'active'
);

-- Inserts for clients table
INSERT INTO clients(email_address, first_name, last_name, enrol_date, phone_ext, phone_number, sales_person_id, logo) VALUES (
    'brook@gmail.com', 'Brook', 'Betty', '2023-10-28 00:02:00', '1234', '1234567890', 1003, 'salesperson'
);

INSERT INTO clients(email_address, first_name, last_name, enrol_date, phone_ext, phone_number, sales_person_id, logo) VALUES (
    'brock@gmail.com', 'Brock', 'Cook', '2023-10-28 00:02:00', '1234', '1234567890', 1003, 'salesperson'
);

INSERT INTO clients(email_address, first_name, last_name, enrol_date, phone_ext, phone_number, sales_person_id, logo) VALUES (
    'truck@gmail.com', 'Truck', 'Car', '2023-10-28 00:02:00', '1234', '1234567890', 1003, 'salesperson'
);

-- Inserts for calls table
INSERT INTO calls(time_of_call, notes, client_id, logo)
VALUES
(
    '2023-10-30 10:00:00',
    'Talked about her back problems. Prescribed appropriate muscle relaxing cream.',
    5000,
    'salesperson'
);
INSERT INTO calls(time_of_call, notes, client_id, logo)
VALUES
(
    '2023-10-30 12:00:00',
    'Talked about bringing jim in to remove his cast. Apointment scheduled.',
    5001,
    'salesperson'
);
INSERT INTO calls(time_of_call, notes, client_id, logo)
VALUES
(
    '2023-10-30 14:00:00',
    'Talked about his long drives leading to problems with sleeping. Reccomended him some medicine and a therapist.',
    5002,
    'salesperson'
);

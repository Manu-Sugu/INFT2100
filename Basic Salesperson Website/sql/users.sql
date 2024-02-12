-- Manu Sugunakumar
-- 20 September 2023
-- INFT2100 

CREATE EXTENSION IF NOT EXISTS pgcrypto;

DROP SEQUENCE IF EXISTS users_id_seq CASCADE;
CREATE SEQUENCE users_id_seq START 1000;

DROP TABLE IF EXISTS users;
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


SELECT * FROM users;
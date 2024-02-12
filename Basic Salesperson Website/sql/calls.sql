-- Manu Sugunakumar
-- 28 October 2023
-- INFT2100 

DROP SEQUENCE IF EXISTS calls_id_seq CASCADE;
CREATE SEQUENCE calls_id_seq START 5000;

DROP TABLE IF EXISTS calls CASCADE;
CREATE TABLE calls(
    id INT PRIMARY KEY DEFAULT nextval('calls_id_seq'),
    time_of_call TIMESTAMP,
    notes VARCHAR(1024),
    client_id INT,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    logo VARCHAR(255)
);

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

SELECT * FROM calls;
<?php
    /**
     * Manu Sugunakumar
     * September 20 2023
     * INFT2100
     * Database page
     */
    $conn = db_connect();

    /**
     * This function connects to the database
     */

    function db_connect(){
        return pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
        // return pg_connect("host=127.0.0.1 dbname=sugunakumarm_db user=sugunakumarm password=100748877");
    }
    
    /**
     * This function finds a user based on the given email within the database
     */
    $user_select_stmt = pg_prepare($conn, "user_select", "SELECT * FROM users WHERE email_address = $1");
    function user_select ($email){
        // variables
        $conn = db_connect();
        $user = 0;
        // prepare statement to find a user from the database
        // gets result from database
        $result = pg_execute($conn, 'user_select', array($email));
        // checking if the result returns anything to fetch the results otherwise return false
        if(pg_num_rows($result) == 1)
        {
            $user = pg_fetch_assoc($result, 0);
        }
        return $user;
    }

    /**
     * This function authenticates a user when inputed the email and password and updates the user last access
     */
    function user_authenticate($email, $plain_password){
        $conn = db_connect();
        $user = user_select($email);
        if(password_verify($plain_password, $user["password"]))
        {
            // gets the current time
            $now = date("Y-m-d G:i:s");
            $sql = "SELECT last_access FROM users WHERE email_address = '".$email."'";
            $then = pg_fetch_result(pg_query($conn, $sql), 0, 'last_access');
            // set the message session to a succesful login message
            setMessage("You successfully logged in. You were previously logged in on ". $then .".");
            // prepares a pg statement
            $user_update_login_time_stmt = pg_prepare($conn, "user_update_login_time", "UPDATE users SET last_access = '".$now."' WHERE email_address = $1");
            // executes the statement
            pg_execute($conn, 'user_update_login_time', array($email));
            // return the user if successful 
            return $user;
        }
        else
        {
            // return false if failed
            return false;
        }
    }

    /**
     * This function inserts a salesperson into the database
     */
    function insert_salesperson($email, $first_password, $first_name, $last_name, $phone_num, $user_type, $file_name)
    {
        $conn = db_connect();
        // Prepared Statement for insert users
        $insert_salesperson = pg_prepare($conn, 'insert_salesperson', "INSERT INTO users(email_address, password, first_name, last_name, enrol_date, phone_ext, type, logo) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)");
        // gets the current time
        $now = date("Y-m-d G:i:s");
        $sales_person = pg_execute($conn, 'insert_salesperson', array($email, password_hash($first_password, PASSWORD_BCRYPT), $first_name, $last_name, $now, $phone_num, $user_type, $file_name));
        return $sales_person;
    }
    
    /**
     * This function inserts a client into the database
     */
    function insert_client($email, $first_name, $last_name, $extension, $phone_num, $userid, $file_name)
    {
        $conn = db_connect();
        // Prepared Statement to insert client
        $insert_client = pg_prepare($conn, 'insert_client', "INSERT INTO clients(email_address, first_name, last_name, enrol_date, phone_ext, phone_number, sales_person_id, logo) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)");
        // gets the current time
        $now = date("Y-m-d G:i:s");
        $client = pg_execute($conn, 'insert_client', array($email, $first_name, $last_name, $now, $extension, $phone_num, $userid, $file_name));
        return $client;
    }

    /**
     * This function inserts a call into the database
     */
    function insert_call($client_id, $time_of_call, $notes, $file_name)
    {
        $conn = db_connect();
        // Prepared statement to insert call
        $insert_call = pg_prepare($conn, 'insert_call', "INSERT INTO calls(time_of_call, notes, client_id, logo) VALUES ($1, $2, $3, $4)");
        $call = pg_execute($conn, 'insert_call', array($time_of_call, $notes, $client_id, $file_name));
        return $call;
    }

    /**
     * This function selects all users of a type
     */
    function user_type_select($type)
    {
        $conn = db_connect();
        // Prepared statement gets all the users with the user type sent
        $user_type_select = pg_prepare($conn, 'user_type_select', "SELECT * FROM users WHERE type=$1");
        $result = pg_execute($conn, 'user_type_select', array($type));
        // Returns the users in an array
        return pg_fetch_all($result);
    }

    /**
     * This function selects all the clients within the database
     */
    function clients_select()
    {
        $conn = db_connect();
        // Prepared statement gets all the clients
        $client_select = pg_prepare($conn, 'client_select', "SELECT * FROM clients");
        $result = pg_execute($conn, 'client_select', array());
        // Returns the users in an array
        return pg_fetch_all($result);
    }

    /**
     * This function selects all the clients
     */
    function client_select_all($table_name, $limit, $offset)
    {
        $conn = db_connect();

        // Prepared statement gets all the clients
        $client_select_all = pg_prepare($conn, 'client_select_all', "SELECT id, email_address, first_name, phone_number, phone_ext, logo FROM $table_name LIMIT $1 OFFSET $2");
        $result = pg_execute($conn, 'client_select_all', array($limit, $offset));
        // Returns the users in an array
        return pg_fetch_all($result);
    }

    /**
     * This function counts the number of clients selected
     */
    function client_count($table_name)
    {
        $conn = db_connect();
        // SELECT COUNT(*) FROM
        // prepared statement to count all the clients
        $client_count = pg_prepare($conn, 'client_count', "SELECT COUNT(*) FROM ".$table_name);
        $result = pg_execute($conn, 'client_count', array());
        // return the count
        // Check if the query was successful
        if ($result) {
            // Fetch the result as an associative array
            $count_data = pg_fetch_assoc($result);
            
            // Return the count value
            return $count_data['count'];
        }
    }

    /**
     * This function selects all the salespeople
     */
    function salespeople_select_all($table_name, $limit, $offset)
    {
        $conn = db_connect();

        // Prepared statement gets all the clients
        $client_select_all = pg_prepare($conn, 'salespeople_select_all', "SELECT id, email_address, first_name, phone_ext, logo, is_active FROM $table_name WHERE type = 'a' LIMIT $1 OFFSET $2");
        $result = pg_execute($conn, 'salespeople_select_all', array($limit, $offset));
        // Returns the users in an array
        return pg_fetch_all($result);
    }

    /**
     * This function counts the number of salespeopl selected
     */
    function salespeople_count($table_name)
    {
        $conn = db_connect();
        // SELECT COUNT(*) FROM
        // prepared statement to count all the clients
        $client_count = pg_prepare($conn, 'salespeople_count', "SELECT COUNT(*) FROM $table_name WHERE type = 'a'");
        $result = pg_execute($conn, 'salespeople_count', array());
        // return the count
        // Check if the query was successful
        if ($result) {
            // Fetch the result as an associative array
            $count_data = pg_fetch_assoc($result);
            
            // Return the count value
            return $count_data['count'];
        }
    }

    /**
     * This function selects all the call records
     */
    function call_select_all($table_name, $limit, $offset)
    {
        $conn = db_connect();

        // Prepared statement gets all the clients
        $client_select_all = pg_prepare($conn, 'call_select_all', "SELECT id, client_id, time_of_call, notes, logo FROM $table_name LIMIT $1 OFFSET $2");
        $result = pg_execute($conn, 'call_select_all', array($limit, $offset));
        // Returns the users in an array
        return pg_fetch_all($result);
    }
    
    /**
     * This function counts the number of call records
     */
    function call_count($table_name)
    {
        $conn = db_connect();
        // SELECT COUNT(*) FROM
        // prepared statement to count all the clients
        $client_count = pg_prepare($conn, 'call_count', "SELECT COUNT(*) FROM ".$table_name);
        $result = pg_execute($conn, 'call_count', array());
        // return the count
        // Check if the query was successful
        if ($result) {
            // Fetch the result as an associative array
            $count_data = pg_fetch_assoc($result);
            
            // Return the count value
            return $count_data['count'];
        }
    }

    /**
     * This function changes the password that is given
     */
    function change_password($email, $plain_password)
    {
        // database connection
        $conn = db_connect();
        // pg prepare statement
        $change_password = pg_prepare($conn, 'change_password', "UPDATE users SET password = '".password_hash($plain_password, PASSWORD_BCRYPT)."' WHERE email_address = $1");
        // excute the statement
        $result = pg_execute($conn, 'change_password', array($email));
        // return the result
        return $result;
    }

    /**
     * This function changes the status of the salesperson and the usertype
     */
    function is_active($result, $id)
    {
        // database connection
        $conn = db_connect();
        $is_active_pg = pg_prepare($conn, 'is_active', "UPDATE users SET is_active = '$result' WHERE id = $1");
        $result = pg_execute($conn, 'is_active', array($id));
        return $result;
    }
?>
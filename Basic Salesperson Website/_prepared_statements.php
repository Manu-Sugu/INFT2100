<?php

    // require "./includes/constants.php";

    // function dump($arg){
    //     echo "<pre>";
    //     print_r($arg);
    //     echo "</pre>";
    // }

    // function db_connect(){
    //     return pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
    // }
    // $conn = db_connect();

    // $user_select_stmt = pg_prepare($conn, "user_select", "SELECT * FROM users WHERE email_address = $1");
    // $user_select_all_stmt = pg_prepare($conn, "user_select_all", "SELECT * FROM users");

    // $result = pg_execute($conn, "user_select", array("jdoe@dcmail.ca"));
    // // $result = pg_execute($conn, "user_select_all", array());

    // if(pg_num_rows($result) == 1)
    // {
    //     $user = pg_fetch_assoc($result, 0);
    //     dump($user);
        
    //     // authenticate a user
    //     $is_user = password_verify("another_password", $user["password"]);

    //     echo "Is user authenticated: " . $is_user . "<br/>";
    // }

?>
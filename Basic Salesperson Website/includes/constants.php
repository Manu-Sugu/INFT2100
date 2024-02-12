<?php
    /**
     * Manu Sugunakumar
     * September 20 2023
     * INFT2100
     * Constants page
     */
    /******* COOKIES *******/
    define("COOKIE_LIFESPAN", "2592000"); // NOTE: 60x60x24x30
    // Week worth of cookies

    /******* USER TYPES ********/
    define("ADMIN", 's');
    define("AGENT", 'a');
    define("CLIENT", 'c');
    define("PENDING", 'p');
    define("DISABLED", 'd');

    /******* DATABASE CONSTANTS ********/
    define("DB_HOST", "127.0.0.1");
    define("DATABASE", "sugunakumarm_db");
    define("DB_ADMIN", "sugunakumarm");
    define("DB_PORT", "5432");
    define("DB_PASSWORD", "100748877");

    
    define("RECORDS", 5);

    define("LIMIT", 10);
    define("OFFSET", 0);
?>
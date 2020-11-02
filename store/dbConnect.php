<?php

    // database connection
    $connect = new mysqli("localhost", "root", "", "storedb");

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }
    return $connect;

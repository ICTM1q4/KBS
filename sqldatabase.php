<?php

function MakeConnection() {
    $host = "localhost";
    $databasename = "webcustomers";
    $user = "root";
    $pass = "";
    $port = 3306;

    mysqli_report(MYSQLI_REPORT_STRICT);

    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);
    if(!$connection){
        die("Unable to connect to database: " . mysqli_error($connection));
    }
    return $connection;
}

function CustomerLogin() {
    $statement = mysqli_prepare($connection, "SELECT username, password FROM webcustomer WHERE username=?");

    mysqli_stmt_bind_param($statement, );

    mysqli_stmt_execute($statement)
}

function CustomerRegister() {

}

function CloseConnection($connection) {
    mysqli_close($connection);
}

?>
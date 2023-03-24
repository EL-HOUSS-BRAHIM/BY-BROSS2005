<?php
class Dph {
    protected function connect() {
        try {
            $username = "epiz_33448930";
            $password = "o6GeRAIhsHTZ";
            $dph = new PDO('mysql:host=sql203.epizy.com;dbname=epiz_33448930_ooplogin', $username, $password);
            //$username = "root";
            //$password = "";
            //$dph = new PDO('mysql:host=localhost;dbname=ooplogin', $username1, $password1);
            return $dph;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}


/*
CREATE TABLE users (
    users_id int(11) AUTO_INCREMENT PRIMARY KEY not null,
    users_uid TINYTEXT not null,
    users_pwd LONGTEXT not null,
    users_email TINYTEXT not null
);

*/
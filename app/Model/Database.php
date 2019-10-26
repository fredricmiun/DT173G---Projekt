<?php 

/* Skapa en connection till databasen med pdo */
class Database {
    private $server;
    private $username;
    private $password;
    private $charset;

    // Använd protected så andra klasser kan använda metoden
    protected function connect() {
        // localhost
        $this->server       =   "127.0.0.1";
        $this->username     =   "root";
        // $this->server       =   "studentmysql.miun.se";
        // $this->username     =   "frfr1800";
        // $this->password     =   "em2skfv6";
        $this->charset      =   "utf8mb4";

        try {
            $dsn    =   "mysql:host=".$this->server.";charset=".$this->charset;
            $pdo    =   new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: ".$e->getMessage();
        }
    }
}
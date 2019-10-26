<?php

// Klass för att logga in användaren
class Login extends Database {

    public function login_user($username, $password) {

        $stmt = $this->connect()->prepare("SELECT *
        FROM dt173g_projekt.users
        WHERE email = ?
        OR username = ?");
        
        $stmt->execute([$username, $username]);

        /* Kontrollerae ifall vi får ett resultat */
        if($stmt->rowCount()){
            /* Finns det så går vi vidare */
            while($row = $stmt->fetch()){
                /* Kontrollera så att den textsträng som användaren anger matchar det lösenordet som finns, detta genom att använda funktionen password_verify */
                $passwordCheck = password_verify($password, $row['password']);
                /* Kontroll */
                if($passwordCheck == false ) {
                    return false;
                } 
                /* Om värdet är sant logga in användaren */
                else if ($passwordCheck == true) {
                    /* Logga in användaren och ge session id som användarens användar-id */
                    session_start();
                    $_SESSION['id'] = $row['user_id'];
                    $_SESSION['name'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    return true;
                }
            }
        }
    }

    // Logga ut metod
    public function logoutUser() {
        session_start();
        session_unset();
        session_destroy();
        $actual_link = $_SERVER['REQUEST_URI'];
        header("Refresh:0");
    }
}
<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    require         "../../../private/app/Model/$class.php";
});

// Hämta metod
$method = $_SERVER['REQUEST_METHOD'];
header("Content-type:application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
// Gör det möjligt att hämta data so mskickas
$input = json_decode(file_get_contents('php://input'),true);

    // Definiera värdet i variabler

    $username = $input['username'];
    $email = $input['email'];
    $password = $input['password'];
    $password_confirm = $input['password_confirm'];

    switch ($method) {
        case "POST":
        // Ifall något av fälten är tomma, avbryt uppdatering. Ge felmeddelande.
        if(!isset($username)) {
            header("Location: ".host."");
        } else {
        
            if(empty($username) || empty($email) || empty($password) || empty($password_confirm)){
                $data['response'] = "error";
                $data['content'] = "Fyll i alla fält";
            } else {
                $check = new Join();
                /* Kontrollera användarnamn */ 
                if($check->check_user($username)) {
                    $data['response'] = "error";
                    $data['content'] = "Användarnamn upptaget";
                } 
                /* Användarnamn behöver vara minst tre tecken */
                else if (strlen($username)<3) {
                    $data['response'] = "error";
                    $data['content'] = "Användarnamn behöver vara minst tre tecken";
                }
                /* EJ längre än 32 tecken */
                else if (strlen($username)>32) {
                    $data['response'] = "error";
                    $data['content'] = "Användarnamn får inte vara längre än 32 tecken";
                }
                /* Får bara innehålla bokstäver eller siffror */
                else if (!ctype_alnum($username)) {
                    $data['response'] = "error";
                    $data['content'] = "Användarnamn får bara innehålla bokstäver och siffror";
                }  
                /* Kontrollera mailadress i databasen */ 
                else if ($check->check_email($email)) {
                    $data['response'] = "error";
                    $data['content'] = "E-mail är upptagen";
                }
                /* Kolla så att mailen inte är ofantligt lång. 128 är standard maxlängd för emails. */
                else if (strlen($email)>128) {
                    $data['response'] = "error";
                    $data['content'] = "E-mail måste vara kortare än 128 tecken";
                }
                /* kontrollera med phps egen metod för om mailen är giltig */
                else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $data['response'] = "error";
                    $data['content'] = "E-mail okänd";
                } 
                /* minst 8 tecken för lösenordet */ 
                else if (strlen($password)<8) {
                    $data['response'] = "error";
                    $data['content'] = "Lösenordet måste vara minst 8 tecken";
                } 
                /* Kontrollera så att lösenorden matchar */ 
                else if ($password != $password_confirm) {
                    $data['response'] = "error";
                    $data['content'] = "Lösenordet matchar inte";
                } 
                /* Om allt ser bra ut så registrerar vi användaren */
                else {
                    if($check->register_user(generate_key(), $username, $email, $password)) {
                        $data['response'] = "success";
                    }
                }
            }
        }
        break;
    }
    
    echo json_encode($data);


/* 

Delen skapar en random key rand(10000000,99999999); som kontrollerar nyckeln mot databasen.
Finns den inte så fortsätter vi med den genererade nyckeln. 
Om den finns så generar vi helt enkelt en ny, så fortsätter det till dess att vi får en nyckel som inte är tagen.

Detta ökar säkerheten istället för att köra auto_increment på id som också är sessions-nyckeln för användaren.

Därav generate_key() ovanför när vi skickar data till klassen -> databasen

*/


function check_key($string) {
    $init_key = new Join;  
    $init_key->check_key($string);
    $get_keys = $init_key->retrieve_arr();
    
    foreach($get_keys as $i => $keys) {
        if($keys['user_id'] == $string) {
           $keyExists = true;
            break;
        } else {
            $keyExists = false;
        }
    }

    return $keyExists;
}

function generate_key() {
    $prel_key = rand(10000000,99999999);
    $check_key = check_key($prel_key);

    while ($check_key == true) {
        $prel_key = rand(10000000,99999999);
        $check_key = check_key($prel_key);
    } 
    
    return $prel_key;
}
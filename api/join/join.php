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
                /* Check if username is taken */ 
                if($check->check_user($username)) {
                    $data['response'] = "error";
                    $data['content'] = "Användarnamn upptaget";
                } 
                else if (strlen($username)<3) {
                    $data['response'] = "error";
                    $data['content'] = "Användarnamn behöver vara minst tre tecken";
                }
                else if (strlen($username)>32) {
                    $data['response'] = "error";
                    $data['content'] = "Användarnamn får inte vara längre än 32 tecken";
                }
                /* Only allow letters and digits for username */
                else if (!ctype_alnum($username)) {
                    $data['response'] = "error";
                    $data['content'] = "Användarnamn får bara innehålla bokstäver och siffror";
                }  
                /* Check if email is taken */ 
                else if ($check->check_email($email)) {
                    $data['response'] = "error";
                    $data['content'] = "E-mail är upptagen";
                }
                /* Check if email isn't too long */
                else if (strlen($email)>128) {
                    $data['response'] = "error";
                    $data['content'] = "E-mail måste vara kortare än 128 tecken";
                }
                /* Check if mail is really valid */
                else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $data['response'] = "error";
                    $data['content'] = "E-mail okänd";
                } 
                /* Check if password is strong enough */ 
                else if (strlen($password)<8) {
                    $data['response'] = "error";
                    $data['content'] = "Lösenordet måste vara minst 8 tecken";
                } 
                /* Check if passwords match*/ 
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
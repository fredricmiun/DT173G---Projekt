<?php
spl_autoload_register(function($class) {
    require         "../../../private/app/Model/$class.php";
});
header("Content-type:application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");

$username = $_POST['username'];
$password = $_POST['password'];

if(!isset($username)) {
    header("Location: ".host."");
} else {
    /* Nytt inloggningsobjekt */
    $check = new Login();
    /* Om fälten är tomma meddela detta */
    if(empty($username) || empty($password)){
        $data['response'] = "error";
        $data['content'] = "Fälten får inte vara tomma";
    } else {
        /* Användarnamn får bara innehålla bokstäver och siffror */
        if(ctype_alnum($username)) {
            /* Kolla så att användarnamn och lösenord matchar */ 
            if($check->login_user($username, $password)) {
                $data['response'] = "success";
                $data['content'] = "Välkommen till Fredrics CV!";
            } else {
                $data['response'] = "error";
                $data['content'] = "Fel lösenord eller mail";
            }
        } else {
            $data['response'] = "error";
            $data['content'] = "Användarnamn kan bara vara bokstäver eller siffror";
        }
    }

    echo json_encode($data);
   
}
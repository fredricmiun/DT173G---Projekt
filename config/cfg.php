<?php

/* Nödvändigheter för att starta session, ob_start() används för att förhindra problematik i session */
ob_start();
session_start();

/* Definierar en host som konstant, andra möjligt användbara variabler */
define("host", "http://localhost:3000");      /* Local Host */
// define("host", "http://studenter.miun.se/~frfr1800/DT173G/proj/");          /* Live Host */
$site_title = "DT173G - Projekt";                                           /* Site Title */
$site_name = "Projekt";                                                     /* Site Meta */


/* En autoloader för klasshantering */
spl_autoload_register(function($class) {
    require         "../private/app/Model/$class.php";
});
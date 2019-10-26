<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    require         "../../../private/app/Model/$class.php";
});

// Hämta metod
$method = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Content-type:application/json;charset=utf-8");
// Gör det möjligt att hämta data som skickas
$input = json_decode(file_get_contents('php://input'),true);

require         "../../../private/functions/icon.php";
require         "../../../private/app/Controller/CvController.php";
require         "../../../private/app/View/CvView.php";

switch ($method) {
    case "GET":
        // Här läggs nödvändig information in.
        // Empty() bestämmer om data ska synas eller inte.
        // span med onClick bestämmer om besökaren får redigera, då inloggning behöver finnas för att kunna redigera innehållet. 
        // Är personen inte inloggad så kommer denne få en inloggnings lightbox istället

        // I View-filen CvView.php finns funktioner som hanterar data som den matas med och returnerar sedan XML-innehåll.
        // Detta gör så att denna fil ser lite mer "städad" ut, och vi kan då också skriva funktioner med ett ändamål och denna kan då återanvändas om olik data hämtas från databasen.
        ?>
<aside class="cv-misc">
    <div class="cv-section">
        <h3>ADRESS <span onClick="loadEdit('adress')"
                <?php if(!isset($_SESSION['id'])) { echo "data-featherlight='#login'"; } else { echo "data-featherlight='#edit-box'"; } ?>><?php icon_edit(16, "#161616") ?></span>
        </h3>
        <ul>
            <?php 
            if(!empty($street))     echo "<li>" . $street . "</li>";
            if(!empty($zip))        echo "<li>" . $zip . " " . $city . "</li>";
            if(!empty($country))    echo "<li>" . $country . "</li>";
            ?>
        </ul>
    </div>
    <div class="cv-section">
        <h3>KONTAKTA <span onClick="loadEdit('kontakta')"
                <?php if(!isset($_SESSION['id'])) { echo "data-featherlight='#login'"; } else { echo "data-featherlight='#edit-box'"; } ?>><?php icon_edit(16, "#161616") ?></span>
        </h3>
        <ul class="u1">
            <?php 
            if(!empty($phone))      echo "<li>" . $phone . "</li>";
            if(!empty($email))      echo "<li>" . $email . "</li>";
            if(!empty($website))    echo "<li>" . $website . "</li>";
            ?>
        </ul>
    </div>
    <div class="cv-section">
        <h3>FÄRDIGHETER <span onClick="loadEdit('skills')"
                <?php if(!isset($_SESSION['id'])) { echo "data-featherlight='#login'"; } else { echo "data-featherlight='#edit-box'"; } ?>><?php icon_edit(16, "#161616") ?></span>
        </h3>
        <?php 
        if(!empty($retrieve_skills))    display_skills($retrieve_skills, "Datateknik"); /* Funktioner som returnerar xml baserat på informationen som matas */
        ?>
    </div>
    <div class="cv-section">
        <h3>UTBILDNING <span onClick="loadEdit('edu')"
                <?php if(!isset($_SESSION['id'])) { echo "data-featherlight='#login'"; } else { echo "data-featherlight='#edit-box'"; } ?>><?php icon_edit(16, "#161616") ?></span>
        </h3>
        <?php 
        if(!empty($retrieve_edu)) display_edu_kur($retrieve_edu) 
        ?>
    </div>
    <div class="cv-section">
        <h3>KURIOSA / PRISER <span onClick="loadEdit('kur')"
                <?php if(!isset($_SESSION['id'])) { echo "data-featherlight='#login'"; } else { echo "data-featherlight='#edit-box'"; } ?>><?php icon_edit(16, "#161616") ?></span>
        </h3>
        <?php 
        if(!empty($retrieve_kur)) display_edu_kur($retrieve_kur) 
        ?>
    </div>
</aside>
<main class="cv-main">
    <div class="cv-initials">
        <?php 
        /* Hämta första bokstaven i förnamn/efternamn */ 
        /*  En del Webbservers verkar inte ha stöd för mbstring, 500 servererror skapas så fort denna är med, så använder substr istället för mb_ */
        ?>

        <span><?php echo substr($fname, 0, 1) . "<br>" . substr($lname, 0, 1) ?></span>
    </div>
    <div class="cv-intro">
        <h2><?= $fname . " " . $lname ?></h2>
        <p><?= $wtitle ?></p>
        <div class="divider"></div>
    </div>
    <div class="cv-content-box">
        <h3>PERSONLIGT <span onClick="loadEdit('personligt')"
                <?php if(!isset($_SESSION['id'])) { echo "data-featherlight='#login'"; } else { echo "data-featherlight='#edit-box'"; } ?>><?php icon_edit(16, "#161616") ?></span>
        </h3>
        <p><?= $pb ?></p>
    </div>
    <div class="cv-content-box">
        <h3>ERFARENHET <span onClick="loadEdit('exp')"
                <?php if(!isset($_SESSION['id'])) { echo "data-featherlight='#login'"; } else { echo "data-featherlight='#edit-box'"; } ?>><?php icon_edit(16, "#161616") ?></span>
        </h3>
        <?php if(!empty($retrieve_exp)) display_exp($retrieve_exp) ?>
    </div>
    <div class="cv-content-box">
        <h3>WEBBPLATSER <span onClick="loadEdit('web')"
                <?php if(!isset($_SESSION['id'])) { echo "data-featherlight='#login'"; } else { echo "data-featherlight='#edit-box'"; } ?>><?php icon_edit(16, "#161616") ?></span>
        </h3>
        <?php 
        if(!empty($retrieve_web)) display_web($retrieve_web) 
        ?>
    </div>
</main>
<?php
    break;
}
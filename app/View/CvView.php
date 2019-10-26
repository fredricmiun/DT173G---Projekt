<?php

if(isset($cv_personal)) {
    $retrieve_cv = $cv_personal->retrieve_arr();
    foreach($retrieve_cv as $i => $items) {
        // Namn + Worktitle
        $fname      =   $items['first_name'];   /* First Name */
        $lname      =   $items['last_name'];    /* Last Name */
        $wtitle     =   $items['work_title'];   /* Work Title */
        $pb         =   $items['pb'];   /* Work Title */

        // Adress
        $street     =   $items['street'];       /* Street */
        $zip        =   $items['zip_code'];     /* Zip */
        $city       =   $items['city'];         /* City */
        $country    =   $items['country'];      /* Country */

        // Kontakt
        $email      =   $items['email'];        /* Email */
        $phone      =   $items['phone'];        /* Street */
        $website    =   $items['website'];      /* Work Title */
    }
}

// Funktioner för att behandla data i arrays

function display_skills($x, $h4) {
echo "<ul class='u1'>";
echo "<h4 class='list-header'>$h4</h4>";
foreach($x as $i => $y) 
{
?>
<li><?= $y['experience'] ?></li>
<?php
}
echo "</ul>";
}

function display_edu_kur($x) {
foreach($x as $i => $y) 
{
echo "<ul>";
?>
<li class="list-header"><?= $y['place'] ?></li>
<li><?= $y['description'] ?></li>
<li>
    <?php 
if(!empty($y['end'])) {
    echo $y['start'] . " - " . $y['end'];
} else {
    echo $y['start'];
}
?>
</li>
<?php
echo "</ul>";
}
}

function display_exp($x) {
    foreach($x as $i => $y) 
    {
    echo "<ul>";
    ?>
<li class="list-header"><?= $y['place'] ?></li>
<li><?= $y['role'] ?></li>
<li class="work-desc"><?= $y['description'] ?></li>
<li>
    <?php 
    if(!empty($y['end'])) {
        echo $y['start'] . " - " . $y['end'];
    } else {
        echo $y['start'];
    }
    ?>
</li>
<?php
    echo "</ul>";
    }
    }

    function display_web($x) {
        foreach($x as $i => $y) 
        {
        echo "<ul>";
        ?>
<li class="list-header"><?= $y['name'] ?></li>
<li><a href="https://<?= $y['url'] ?>"><?= $y['url'] ?></a></li>
<li class="work-desc"><?= $y['description'] ?></li>
</li>
<?php
        echo "</ul>";
        }
        }
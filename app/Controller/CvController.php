<?php

if(isset($method)) {
    if($method == "GET" || $method == "POST") {
        // Personligt + Adress + Kontakt
        $cv_personal = new Cv;
        $cv_personal->cv_personal();

        // Färdigheter
        
        $cv_skills = new Cv;
        if($cv_skills->cv_skills()) {
            $retrieve_skills = $cv_skills->retrieve_arr();
        }
        
        // Education + Kuriosa
        $cv_edu = new Cv;
        if($cv_edu->cv_edu_kuriosa("edu")) {
            $retrieve_edu = $cv_edu->retrieve_arr();
        }

        $cv_kur = new Cv;
        if($cv_kur->cv_edu_kuriosa("kur")) {
            $retrieve_kur = $cv_kur->retrieve_arr();
        }

        $cv_web = new Cv;
        if($cv_web->cv_web()) {
            $retrieve_web = $cv_web->retrieve_arr();
        }

        // Experience
        $cv_exp = new Cv;
        if($cv_exp->cv_experience()) {
            $retrieve_exp = $cv_exp->retrieve_arr();
        }

    }
}
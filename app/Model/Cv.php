<?php

class Cv extends Database {
    protected $arr = [];

    /* 
    
    Retrieve
    
    */

    // Hämta allt från cv_personal
    // Skicka till array
    // Informationen behandlas i efterhand
    public function cv_personal() {
        $stmt = $this->connect()->query("SELECT * 
        FROM dt173g_projekt.cv_personal");
        if($stmt->rowCount()){
            while($row = $stmt->fetch()){
                array_push($this->arr, $row);
            }
        }
    }

    // Allt från tabellen cv_skills
    public function cv_skills() {
        $stmt = $this->connect()->query("SELECT * 
        FROM dt173g_projekt.cv_skills");
        if($stmt->rowCount()){
            while($row = $stmt->fetch()){
                array_push($this->arr, $row);
            }
            return true;
        }
    }

    // Allt från tabellen cv_edu_kuriosa
    public function cv_edu_kuriosa($x) {
        $stmt = $this->connect()->prepare("SELECT * 
        FROM dt173g_projekt.cv_edu_kuriosa
        WHERE type = ?
        ORDER BY start DESC");
        $stmt->execute([$x]);
        if($stmt->rowCount()){
            while($row = $stmt->fetch()){
                array_push($this->arr, $row);
            }
            return true;
        }
    }

    
    // Allt från tabellen cv_experience
    public function cv_experience() {
        $stmt = $this->connect()->query("SELECT * 
        FROM dt173g_projekt.cv_experience
        ORDER BY start DESC");
        if($stmt->rowCount()){
            while($row = $stmt->fetch()){
                array_push($this->arr, $row);
            }
            return true;
        }
    }

    // Allt från tabellen cv_web
    public function cv_web() {
        $stmt = $this->connect()->query("SELECT * 
        FROM dt173g_projekt.cv_web");
        if($stmt->rowCount()){
            while($row = $stmt->fetch()){
                array_push($this->arr, $row);
            }
            return true;
        }
    }
    
    /* 
    
    Update

    */

    // Här uppdaterar vi allt innehåll baserat på värden som skickas som argument.
    // Dessa placeras i placeholders  som sedan körs.
    
    public function update_address($street, $zip, $city, $country) {
        $stmt = $this->connect()->prepare("UPDATE dt173g_projekt.cv_personal
        SET `street`=?,`zip_code`=?,`city`=?,`country`=?");
        $stmt->execute([$street, $zip, $city, $country]);
    }

    public function update_contact($phone, $email, $website) {
        $stmt = $this->connect()->prepare("UPDATE dt173g_projekt.cv_personal
        SET `phone`=?,`email`=?,`website`=?");
        $stmt->execute([$phone, $email, $website]);
    }

    public function update_personal($fname, $lname, $title, $description) {
        $stmt = $this->connect()->prepare("UPDATE dt173g_projekt.cv_personal
        SET `first_name`=?,`last_name`=?,`work_title`=?,`pb`=?");
        $stmt->execute([$fname, $lname, $title, $description]);
    }

    public function update_edu_kur($id, $place, $desc, $start, $end) {
        $stmt = $this->connect()->prepare("UPDATE dt173g_projekt.cv_edu_kuriosa
        SET `place`=?,`description`=?,`start`=?,`end`=?
        WHERE id = ?");
        $stmt->execute([$place, $desc, $start, $end, $id]);
    }

    public function update_web($id, $name, $url, $description) {
        $stmt = $this->connect()->prepare("UPDATE dt173g_projekt.cv_web
        SET `name`=?,`url`=?,`description`=?
        WHERE id = ?");
        $stmt->execute([$name, $url, $description, $id]);
    }

    public function update_experience($id, $place, $role, $desc, $start, $end) {
        $stmt = $this->connect()->prepare("UPDATE dt173g_projekt.cv_experience
        SET `place`=?,`role`=?,`description`=?,`start`=?,`end`=?
        WHERE id = ?");
        $stmt->execute([$place, $role, $desc, $start, $end, $id]);
    }

    public function update_skills($id, $skill) {
        $stmt = $this->connect()->prepare("UPDATE dt173g_projekt.cv_skills
        SET `experience`=?
        WHERE id = ?");
        $stmt->execute([$skill, $id]);
    }

    /* 

    Insert
    
    */

    // Samma variant som ovan, istället för uppdatera så kör vi insert istället

    public function insert_edu_kur($place, $desc, $start, $end, $type) {
        $stmt = $this->connect()->prepare("INSERT INTO dt173g_projekt.cv_edu_kuriosa(`place`, `description`, `start`, `end`, `type`) 
        VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$place, $desc, $start, $end, $type]);
    }

    public function insert_experience($place, $role, $desc, $start, $end) {
        $stmt = $this->connect()->prepare("INSERT INTO dt173g_projekt.cv_experience(`place`, `role`, `description`, `start`, `end`) 
        VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$place, $role, $desc, $start, $end]);
    }

    public function insert_skill($skills) {
        $stmt = $this->connect()->prepare("INSERT INTO dt173g_projekt.cv_skills(`experience`) 
        VALUES (?)");
        $stmt->execute([$skills]);
    }

    public function insert_web($place, $role, $desc) {
        $stmt = $this->connect()->prepare("INSERT INTO dt173g_projekt.cv_web(`name`, `url`, `description`) 
        VALUES (?, ?, ?)");
        $stmt->execute([$place, $role, $desc]);
    }


    /* 

    Delete

    */

    
    public function delete_edu_kur($id) {
        $stmt = $this->connect()->prepare("DELETE FROM dt173g_projekt.cv_edu_kuriosa WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function delete_experience($id) {
        $stmt = $this->connect()->prepare("DELETE FROM dt173g_projekt.cv_experience WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function delete_skill($id) {
        $stmt = $this->connect()->prepare("DELETE FROM dt173g_projekt.cv_skills WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function delete_web($id) {
        $stmt = $this->connect()->prepare("DELETE FROM dt173g_projekt.cv_web WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function retrieve_arr(){
        return $this->arr;
    }

}
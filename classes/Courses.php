<?php 
//* Skapad av Emil palm, empa1600


// Klass för kurser

class Courses {

    //*Databasanslutning

    public function __construct($db) {
        $this->db = $db->connect();
    }

    //* Klassfunktioner för SQL mot databasen

    // Skriv ut alla kurser
    public function readCourses() {
        $sql = "SELECT * FROM courses"; //SQL fråga

        $result = $this->db->query($sql); //Resultat

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Skriv ut en kurs med id
    public function readCourse($id) {
        $sql= "SELECT * FROM courses WHERE id=$id";

        $result = $this->db->query($sql);

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    //Skapa en ny kurs
    public function create() {
        //SQL fråga
        $sql = "INSERT INTO courses(courseid, coursename, progression, courseplan) VALUES ('$this->courseid', '$this->coursename', '$this->progression', $this->courseplan')";
        $result = $this->db->query($sql); //Resultat
        return $result;
    }

    // Uppdatera kurs
    public function update(int $id) {       
        $sql = "UPDATE courses SET courseid='$this->courseid', coursename='$this->coursename', progression='$this->progression', courseplan='$this->courseplan' WHERE id=$id";
        $result = $this->db->query($sql);
        return $result;  
    }

    // Radera kurs
    public function deleteCourse(int $id) {
        $sql = "DELETE FROM courses WHERE id=$id"; 
        $result = $this->db->query($sql); 
        return $result;
    }

}





?>
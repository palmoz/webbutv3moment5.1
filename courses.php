<?php 

//* Skapad av Emil palm, empa1600

require 'config/Database.php';
require 'classes/Courses.php';


//* Headers för tillgänglighet från andra domän:

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


// Om id valt:
if(isset($_GET['id'])) {            
    $id = $_GET['id']; 
}

//* instans av databas
$db = new Database();
//*Instans av kurser
$courses = new Courses($db); 
//* Metod till switch 
$method = $_SERVER['REQUEST_METHOD']; 


switch($method) {

    //* Läsa in kurser
    case 'GET':
        if(isset($id)) {
            $result = $courses->readCourse($id);
        } else {
            $result = $courses->readCourses();
        }
            // Om den finns
        if(sizeof($result) > 0) {
            http_response_code(200); // Kod ok
        } else {
            http_response_code(404); // Not found 
            $result = array("Message" => "hittade inga kurser"); 
        }
        break;


        //* skapa ny kurs
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $courses->courseid = $data->courseid;
        $courses->coursename = $data->coursename;
        $courses->progression = $data->progression;
        $courses->courseplan = $data->courseplan; 

        if($courses->create()) {
            http_response_code(201);
            $result = array("Message" => "Kurs tillagd");
        } else {
            http_response_code(503);            
            $result = array("Message" => "Kursen kunde ej skapas");
        }
        break;

        //*Uppdatera en kurs
    case 'PUT':
        if(!isset($id)) {    
            http_response_code(510);
            $result = array("message" => "Saknar id");
        } else {       
                $data = json_decode(file_get_contents("php://input"));           
                $courses->courseid = $data->courseid;
                $courses->coursename = $data->coursename;
                $courses->progression = $data->progression;
                $courses->courseplan = $data->courseplan; 

            if($courses->update($id)) {
                    http_response_code(200); // Ok kod      
                    $result = array("Message" => "Kurs uppdaterad");
            } else {
                    http_response_code(503);  // kod service unavailable
                    $result = array("Message" => "Kunde ej uppdatera kurs"); 
            }
        }
        break;

        //* Radera en kurs

        case 'DELETE':
            if(!isset($id)) {
                http_response_code(510);    // Kod not extended
                $result = array("Message" => "inget id");
            } else {
                if($courses->deleteCourse($id)) {
                    http_response_code(200);    // Kod ok
                    $result = array("Message" => "Kurs raderad");
                } else {
                    http_response_code(503);    // Kod service unavailable
                    $result = array("Message" => "Kunde ej radera kurs");
                }
            }
        break;



}
//* Resultat i json format:
echo json_encode($result);   


//* Döda databas:
$db->close();       





?>
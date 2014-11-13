<?php
error_reporting(E_ALL);
include 'functions.php';
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
 
// liefert alle Events
$app->get('/events', 'getEvents');

// fügt einen Event hinzu
$app->post('/events', 'addEvent');

// löschrt einen Event mit bestimmter id
$app->delete('/events/:id', 'deleteEvent');

// liefert alle Teilnehmer eines Events
$app->get('/events/:id/participants', 'getParticipantsForEvent');

// fügt einen Teilnehmer zu einem Event hinzu
$app->post('/events/:id/participants', 'addParticipantToEvent');

// löschrt einen Teilnehmer mit bestimmter id eines Events
$app->delete('/events/:e_id/participants/:p_id', 'deleteParticipantFromEvent');

 
$app->run();

function getConnection() {
    $dbhost="localhost";
    $dbuser="sers";
    $dbpass="sers69";
    $dbname="sers";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->exec("set names utf8");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function getEvents() {
	$sql = "select sers_events.eventId, name, picture, description, place, requirements, date_start, date_end, time_start, time_end, registration_until, price, slotsSkydive, slotsPax, postDate, (sers_events.slotsSkydive - (SELECT COUNT(*) FROM sers_participants WHERE sers_participants.eventId = sers_events.eventId AND sers_participants.pax = 0)) AS freeSlotsSkydive, (sers_events.slotsPax - (SELECT COUNT(*) FROM sers_participants WHERE sers_participants.eventId = sers_events.eventId AND sers_participants.pax = 1)) AS freeSlotsPax, (SELECT freeSlotsSkydive + freeSlotsPax) AS freeSlots, IF((SELECT DATEDIFF(CURDATE(),sers_events.registration_until)) > 0, 0, (SELECT -1*DATEDIFF(CURDATE(),sers_events.registration_until))) as remainingDays FROM sers_events ORDER BY postDate";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $events = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($events);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function addEvent() {
	$request = \Slim\Slim::getInstance()->request();
	$resultat = implode(",", $request->post());
    $event = json_decode($resultat);
	//echo $event->name;
    $sql = "INSERT INTO sers_events (name, picture, description, place, requirements, date_start, date_end, time_start, time_end, registration_until, price, slotsSkydive, slotsPax, postDate) VALUES (:name, :picture, :description, :place, :requirements, :date_start, :date_end, :time_start, :time_end, :registration_until, :price, :slotsSkydive, :slotsPax, :postDate)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("name", $event->name);
        $stmt->bindParam("picture", $event->picture);		
        $stmt->bindParam("description", $event->description);
        $stmt->bindParam("place", $event->place);
        $stmt->bindParam("requirements", $event->requirements);
        $stmt->bindParam("date_start", $event->date_start);
        $stmt->bindParam("date_end", $event->date_end);
        $stmt->bindParam("time_start", $event->time_start);
        $stmt->bindParam("time_end", $event->time_end);
        $stmt->bindParam("registration_until", $event->registration_until);
        $stmt->bindParam("price", $event->price);
        $stmt->bindParam("slotsSkydive", $event->slotsSkydive);
        $stmt->bindParam("slotsPax", $event->slotsPax);
        $stmt->bindParam("postDate", $event->postDate);
        $stmt->execute();
        $event->id = $db->lastInsertId();
        $db = null;
        echo json_encode($event);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }	
}
function deleteEvent($id) {
	echo "delete event $id";
	}
function getParticipantsForEvent($id) {
	$sql = "select * FROM sers_participants WHERE eventId='$id'";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $events = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($events);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
	
	}
function addParticipantToEvent($id) {
	//echo "add participant to event $id";
    try {
        $request = \Slim\Slim::getInstance()->request();
        
        $body = $request->getBody();
        $event = json_decode($body); 
        $sql = "INSERT INTO sers_participants (eventId, firstName, lastName, email, phone, pax, deleteCode) VALUES (:eventId, :firstName, :lastName, :email, :phone, :pax, :deleteCode)";
    
        $pax = 0;

        if ($event->pax) {
            $pax = 1;
        }

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("eventId", $event->eventId);
        $stmt->bindParam("firstName", $event->firstName);		
        $stmt->bindParam("lastName", $event->lastName);
        $stmt->bindParam("email", $event->email);
        $stmt->bindParam("phone", $event->phone);
        $stmt->bindParam("pax", $pax);
		
		$deleteCode = generateDeleteCode($event->email);
        $stmt->bindParam("deleteCode", $deleteCode);
        
		$stmt->execute();
        $event->id = $db->lastInsertId();
		
		//MaiL versenden
		sendConfirmationMail($event->email, $deleteCode);
		
        $db = null;
        echo json_encode($event);
    } catch(Exception $e) {
        echo $e;
    }
}


function deleteParticipantFromEvent($e_id,$p_id) {
	echo "delete participant $e_id from event $p_id";
	}

?>
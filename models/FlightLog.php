<?php
require_once '../config/db.php';

// define FlightLog class for managing flight logs
class FlightLog {
    private $conn;

    public function __construct() {
        global $conn; // use global connection object
        $this->conn = $conn;
    }

    // retrieve all flight logs from database
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM flight_logs");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // search flight log by its id
    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM flight_logs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // create new flight log entry
    public function create($tailNumber, $flightID, $takeoff, $landing, $duration, $userId) {
        $stmt = $this->conn->prepare("INSERT INTO flight_logs (tailNumber, flightID, takeoff, landing, duration, user_id) VALUES (:tailNumber, :flightID, :takeoff, :landing, :duration, :userId)");
        $stmt->bindParam(':tailNumber', $tailNumber);
        $stmt->bindParam(':flightID', $flightID);
        $stmt->bindParam(':takeoff', $takeoff);
        $stmt->bindParam(':landing', $landing);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    // update existing flight log
    public function update($id, $tailNumber, $flightID, $takeoff, $landing, $duration) {
        $stmt = $this->conn->prepare("UPDATE flight_logs SET tailNumber = :tailNumber, flightID = :flightID, takeoff = :takeoff, landing = :landing, duration = :duration WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':tailNumber', $tailNumber);
        $stmt->bindParam(':flightID', $flightID);
        $stmt->bindParam(':takeoff', $takeoff);
        $stmt->bindParam(':landing', $landing);
        $stmt->bindParam(':duration', $duration);
        return $stmt->execute();
    }

    // delete flight log by id
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM flight_logs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // search flight logs using flight id
    public function searchByFlightID($flightID) {
        $stmt = $this->conn->prepare("SELECT * FROM flight_logs WHERE flightID = :flightID");
        $stmt->bindParam(':flightID', $flightID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<?php
require_once '../models/FlightLog.php';
require_once 'UserController.php'; // for user authentication

// create flightLogcontroller class
class FlightLogController {
    private $flightLog;

    public function __construct() {
        $this->flightLog = new FlightLog();

        // authenticate user before accessing flight logs
        $userController = new UserController();
        $userController->isAuthenticated();
    }

    // interact with flightLog model
    public function getAllFlightLogs() {
        return $this->flightLog->getAll();
    }

    public function getFlightLogById($id) {
        return $this->flightLog->findById($id);
    }

    public function createFlightLog($tailNumber, $flightID, $takeoff, $landing, $duration, $userId) {
        return $this->flightLog->create($tailNumber, $flightID, $takeoff, $landing, $duration, $userId);
    }

    public function updateFlightLog($id, $tailNumber, $flightID, $takeoff, $landing, $duration) {
        return $this->flightLog->update($id, $tailNumber, $flightID, $takeoff, $landing, $duration);
    }

    public function deleteFlightLog($id) {
        return $this->flightLog->delete($id);
    }

    public function searchFlightLogByFlightID($flightID) {
        return $this->flightLog->searchByFlightID($flightID);
    }
}

// controller & handle ajax requests
$flightLogController = new FlightLogController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['action']) {
        case 'save':
            // handle create/update flight log based on id presence
            $id = !empty($_POST['id']) ? $_POST['id'] : null;
            if ($id === null) {
                // create new flight log if id is not provided
                $result = $flightLogController->createFlightLog(
                    $_POST['tailNumber'], 
                    $_POST['flightID'], 
                    $_POST['takeoff'], 
                    $_POST['landing'], 
                    $_POST['duration'], 
                    $_SESSION['user_id']
                );
                echo $result ? "Flight log created successfully!" : "Failed to create flight log.";
            } else {
                // update existing flight log if id is provided
                $result = $flightLogController->updateFlightLog(
                    $id,
                    $_POST['tailNumber'],
                    $_POST['flightID'],
                    $_POST['takeoff'],
                    $_POST['landing'],
                    $_POST['duration']
                );
                echo $result ? "Flight log updated successfully!" : "Failed to update flight log.";
            }
            break;
        case 'delete':
            // delete flight log if request
            if (!empty($_POST['id'])) {
                $result = $flightLogController->deleteFlightLog($_POST['id']);
                echo $result ? "Flight log deleted successfully!" : "Failed to delete flight log.";
            }
            break;
        case 'get':
            // fetching single flight log by id
            if (!empty($_POST['id'])) {
                $flightLog = $flightLogController->getFlightLogById($_POST['id']);
                echo json_encode($flightLog);
            }
            break;
        case 'fetch':
            // fetching all flight logs
            $flightLogs = $flightLogController->getAllFlightLogs();
            $output = '';
            foreach ($flightLogs as $log) {
                $output .= "<tr data-id='{$log['id']}'>
                            <td>{$log['tailNumber']}</td>
                            <td>{$log['flightID']}</td>
                            <td>{$log['takeoff']}</td>
                            <td>{$log['landing']}</td>
                            <td>{$log['duration']}</td>
                            <td>
                                <button class='editBtn' data-id='{$log['id']}'>Edit</button>
                                <button class='deleteBtn' data-id='{$log['id']}'>Delete</button>
                            </td>
                        </tr>";
            }
            echo $output;
            break;
        case 'search':
            // search for flight logs
            if (!empty($_POST['flightID'])) {
                $flightLogs = $flightLogController->searchFlightLogByFlightID($_POST['flightID']);
                $output = '';
                foreach ($flightLogs as $log) {
                    $output .= "<tr data-id='{$log['id']}'>
                                <td>{$log['tailNumber']}</td>
                                <td>{$log['flightID']}</td>
                                <td>{$log['takeoff']}</td>
                                <td>{$log['landing']}</td>
                                <td>{$log['duration']}</td>
                                <td>
                                    <button class='editBtn' data-id='{$log['id']}'>Edit</button>
                                    <button class='deleteBtn' data-id='{$log['id']}'>Delete</button>
                                </td>
                            </tr>";
                }
                echo $output;
            } else {
                echo "Please provide a Flight ID to search.";
            }
            break;
        default:
            echo "Invalid action.";
    }
}
?>

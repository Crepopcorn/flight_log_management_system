<?php
require_once '../controllers/FlightLogController.php';
require_once '../controllers/UserController.php';

// start session if not yet started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// initialize controllers & fetch all flight logs
$flightLogController = new FlightLogController();
$flightLogs = $flightLogController->getAllFlightLogs();

// handle user account deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_account'])) {
    $userController = new UserController();
    $userController->deleteAccount($_SESSION['user_id']);
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!-- HTML for manage flight logs page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- information's & link's styles and scripts -->
    <meta charset="UTF-8">
    <title>Manage Flight Logs</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/scripts.js"></script>
    <!-- form & table layout -->
    <style>
        /* form layout */
        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form-group {
            width: 48%;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        /* search Form */
        #searchFlightLogForm {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            justify-content: center;
        }

        #searchFlightID {
            width: 70%;
            padding: 8px;
            margin-right: 10px;
        }

        .icon-button {
            width: 40px;
            height: 40px;
            border: none;
            cursor: pointer;
            background-color: transparent;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        #searchFlightLogBtn {
            background-image: url('../assets/icon.png');
        }

        #returnBackBtn {
            background-image: url('../assets/back.png');
            margin-right: 10px;
        }

        /* icon buttons */
        .icon-button:hover {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 5px;
        }

        /* remove default button styles*/
        .icon-button:focus {
            outline: none;
        }

        /* sortable table headers */
        th.sortable {
            cursor: pointer;
            user-select: none;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            padding: 10px;
            font-size: 18px;
            position: relative;
        }

        th.sortable .sort-indicator {
            position: absolute;
            bottom: 5px;
            right: 5px;
            font-size: 0.8em;
            font-weight: bold;
            color: #666;
        }

        th.sortable.asc .sort-indicator::after {
            content: '▼';
        }

        th.sortable.desc .sort-indicator::after {
            content: '▲';
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 16px;
        }

        th {
            font-size: 18px;
            text-align: center;
        }

        /* ensure table content fits within the container */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* "*required" remark*/
        .required-remark {
            position: absolute;
            top: 210px;
            right: 20px;
            color: red;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- container for flight log management page -->
    <div class="container" style="position: relative;">
        <h1>Flight Log Management System</h1>

        <!-- search Form for flight Logs by flight id -->
        <form id="searchFlightLogForm">
            <!-- return back button -->
            <button type="button" id="returnBackBtn" class="icon-button"></button>
            
            <!-- search input & button -->
            <input type="text" name="searchFlightID" id="searchFlightID" placeholder="Enter Flight ID to search" required>
            <button type="button" id="searchFlightLogBtn" class="icon-button"></button>
        </form>

        <!-- separator -->
        <hr style="margin: 30px 0; border: none; border-top: 2px solid #ddd;">

        <!-- *requried remark -->
        <div class="required-remark">* Required</div>

        <!-- flight log form -->
        <form id="flightLogForm">
            <input type="hidden" name="id" id="logId">

            <div class="form-row">
                <div class="form-group">
                    <label for="tailNumber">Tail Number <span style="color: red;">*</span></label>
                    <input type="text" name="tailNumber" id="tailNumber" placeholder="Tail Number" required>
                </div>
                <div class="form-group">
                    <label for="flightID">Flight ID <span style="color: red;">*</span></label>
                    <input type="text" name="flightID" id="flightID" placeholder="Flight ID" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="takeoff">Takeoff <span style="color: red;">*</span></label>
                    <input type="datetime-local" name="takeoff" id="takeoff" required>
                </div>
                <div class="form-group">
                    <label for="landing">Landing <span style="color: red;">*</span></label>
                    <input type="datetime-local" name="landing" id="landing" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="duration">Duration <span style="color: red;">*</span></label>
                    <input type="text" name="duration" id="duration" placeholder="Duration (HH:MM:SS)" required>
                </div>
                <div class="form-group">
                </div>
            </div>

            <!-- buttons for saving & clearing flight log form -->
            <button type="submit" id="saveLog">Save Flight Log</button>
            <button type="button" id="clearForm">Clear Form</button>
        </form>

        <!-- flight logs table -->
        <table id="flightLogsTable">
            <thead>
                <tr>
                    <th class="sortable" data-column="tailNumber" data-order="asc">Tail Number<span class="sort-indicator"></span></th>
                    <th class="sortable" data-column="flightID" data-order="asc">Flight ID<span class="sort-indicator"></span></th>
                    <th class="sortable" data-column="takeoff" data-order="asc">Takeoff<span class="sort-indicator"></span></th>
                    <th class="sortable" data-column="landing" data-order="asc">Landing<span class="sort-indicator"></span></th>
                    <th class="sortable" data-column="duration" data-order="asc">Duration<span class="sort-indicator"></span></th>
                    <th style="font-size: 18px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- generate table rows for each flight log -->
                <?php foreach ($flightLogs as $log): ?>
                <tr data-id="<?php echo $log['id']; ?>">
                    <td><?php echo htmlspecialchars($log['tailNumber']); ?></td>
                    <td><?php echo htmlspecialchars($log['flightID']); ?></td>
                    <td><?php echo htmlspecialchars($log['takeoff']); ?></td>
                    <td><?php echo htmlspecialchars($log['landing']); ?></td>
                    <td><?php echo htmlspecialchars($log['duration']); ?></td>
                    <td>
                        <button class="editBtn" data-id="<?php echo $log['id']; ?>">Edit</button>
                        <button class="deleteBtn" data-id="<?php echo $log['id']; ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- logout button -->
        <form method="GET" action="../controllers/UserController.php">
            <input type="hidden" name="action" value="logout">
            <button type="submit" class="logout-button">Logout</button>
        </form>

        <!-- delete account button -->
        <form method="POST" style="margin-top: 20px;">
            <input type="hidden" name="delete_account" value="true">
            <button type="submit" class="logout-button">Delete My Account</button>
        </form>
    </div>

    <!-- jquery script used for managing flight log function -->
    <script>
        $(document).ready(function() {
            // clear form function
            $('#clearForm').click(function() {
                $('#logId').val('');
                $('#flightLogForm')[0].reset();
            });

            // submit form for create/update flight log
            $('#flightLogForm').off('submit').on('submit', function(event) {
                event.preventDefault(); // Prevent form from submitting normally

                $.ajax({
                    url: '../controllers/FlightLogController.php',
                    type: 'POST',
                    data: $(this).serialize() + '&action=save',
                    success: function(response) {
                        alert(response);
                        loadFlightLogs(); // Reload flight logs table
                        $('#clearForm').click(); // Clear the form after submission
                    }
                });
            });

            // edit button function
            $(document).off('click', '.editBtn').on('click', '.editBtn', function() {
                const logId = $(this).data('id');

                $.ajax({
                    url: '../controllers/FlightLogController.php',
                    type: 'POST',
                    data: { action: 'get', id: logId },
                    success: function(response) {
                        const log = JSON.parse(response);
                        $('#logId').val(log.id);
                        $('#tailNumber').val(log.tailNumber);
                        $('#flightID').val(log.flightID);
                        $('#takeoff').val(log.takeoff.replace(' ', 'T'));
                        $('#landing').val(log.landing.replace(' ', 'T'));
                        $('#duration').val(log.duration);
                    }
                });
            });

            // delete button function
            $(document).off('click', '.deleteBtn').on('click', '.deleteBtn', function() {
                const logId = $(this).data('id');

                if (confirm('Are you sure you want to delete this flight log?')) {
                    $.ajax({
                        url: '../controllers/FlightLogController.php',
                        type: 'POST',
                        data: { action: 'delete', id: logId },
                        success: function(response) {
                            alert(response);
                            loadFlightLogs(); // reload flight logs table
                        }
                    });
                }
            });

            // search button function
            $('#searchFlightLogBtn').click(function() {
                const flightID = $('#searchFlightID').val();

                if (flightID.trim() !== "") {
                    $.ajax({
                        url: '../controllers/FlightLogController.php',
                        type: 'POST',
                        data: { action: 'search', flightID: flightID },
                        success: function(response) {
                            $('#flightLogsTable tbody').html(response); // load search results
                        }
                    });
                } else {
                    alert("Please enter a Flight ID to search."); // error handling for empty search input
                }
            });

            // detect empty input & load all flight logs
            $('#searchFlightID').on('input', function() {
                if ($(this).val().trim() === "") {
                    loadFlightLogs();
                }
            });

            // return back button function
            $('#returnBackBtn').click(function() {
                $('#searchFlightID').val(''); // Clear search input
                $('#flightLogForm')[0].reset(); // Clear flight log form inputs
                loadFlightLogs(); // Reload all flight logs
            });

            // sorting function on table
            $('th.sortable').click(function() {
                const column = $(this).data('column');
                const order = $(this).data('order') === 'asc' ? 'desc' : 'asc';
                $(this).data('order', order);
                
                $('th.sortable').not(this).removeClass('asc desc').find('.sort-indicator').removeClass('asc desc');

                $(this).removeClass('asc desc').addClass(order);  // Update arrow indicator
                sortTable(column, order);
            });

            function sortTable(column, order) {
                const rows = $('#flightLogsTable tbody tr').get();
                rows.sort(function(a, b) {
                    const A = $(a).children('td').eq($('th[data-column="' + column + '"]').index()).text().toUpperCase();
                    const B = $(b).children('td').eq($('th[data-column="' + column + '"]').index()).text().toUpperCase();

                    if (column === "tailNumber") {
                        const numA = parseFloat(A.replace(/\D/g, '')) || 0;
                        const numB = parseFloat(B.replace(/\D/g, '')) || 0;
                        if (numA < numB) return order === 'asc' ? -1 : 1;
                        if (numA > numB) return order === 'asc' ? 1 : -1;
                    } else {
                        if (A < B) return order === 'asc' ? -1 : 1;
                        if (A > B) return order === 'asc' ? 1 : -1;
                    }
                    return 0;
                });
                $.each(rows, function(index, row) {
                    $('#flightLogsTable tbody').append(row);
                });
            }

            // load flight Logs into table
            function loadFlightLogs() {
                $.ajax({
                    url: '../controllers/FlightLogController.php',
                    type: 'POST',
                    data: { action: 'fetch' },
                    success: function(response) {
                        $('#flightLogsTable tbody').html(response);
                    }
                });
            }

            loadFlightLogs(); // initial load of flight logs
        });
    </script>
</body>
</html>

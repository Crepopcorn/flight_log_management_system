
// stores text for output/interactions
let texts = [" ", " ", " "];

// variables used for storing user input data
let logId = "";
let flightID = "";
let tailNumber = "";
let takeoff = "";
let landing = "";
let duration = "";

// clear form inputs for flight logs
function clearForm() {
    logId = '';
    $('#flightLogForm')[0].reset();
}

// ajax submission for creating or updating flight logs
function submitFlightLogForm(event) {
    event.preventDefault(); // prevent form from submitting normally
    $.ajax({
        url: '../controllers/FlightLogController.php',
        type: 'POST',
        data: $('#flightLogForm').serialize() + '&action=save',
        success: function(response) {
            alert(response);
            loadFlightLogs(); // reload flight logs table
            clearForm(); // clear form after submission
        }
    });
}

// load flight logs from the server using ajax
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

// edit button clicks for flight logs
function handleEditButtonClick(logId) {
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
}

// delete button clicks for flight logs
function handleDeleteButtonClick(logId) {
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
}

// search for flight logs by flight id
function searchFlightLogsByFlightID() {
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
}

// attach event handlers to elements after dom is ready
$(document).ready(function() {
    $('#clearForm').click(clearForm);
    $('#flightLogForm').submit(submitFlightLogForm);
    $(document).on('click', '.editBtn', function() {
        handleEditButtonClick($(this).data('id'));
    });
    $(document).on('click', '.deleteBtn', function() {
        handleDeleteButtonClick($(this).data('id'));
    });
    $('#searchFlightLogBtn').click(searchFlightLogsByFlightID);
    loadFlightLogs(); // initial load of flight logs
});

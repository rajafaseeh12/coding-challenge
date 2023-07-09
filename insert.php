<?php
 require_once 'database.php';
$jsonData = file_get_contents('jsonData.json');
$bookings = json_decode($jsonData, true);

$statement = $conn->prepare("INSERT INTO bookings (participation_id, employee_name, employee_mail, event_id, event_name, participation_fee, event_date) VALUES (?, ?, ?, ?, ?, ?, ?)");

foreach ($bookings as $booking) {
    $statement->bind_param('sssssss', $booking['participation_id'], $booking['employee_name'], $booking['employee_mail'], $booking['event_id'], $booking['event_name'], $booking['participation_fee'], $booking['event_date']);
    $statement->execute();
}

$statement->close();
?>
<?php
session_start();
require_once '../db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_id = $_POST['contact_id'] ;
    $interaction_type = $_POST['interaction_type'] ;
    $notes = $_POST['notes'] ?? '';
    $follow_up_date = $_POST['follow_up_date'];
    $status = $_POST['status'] ;
    $user_id = $_SESSION['user_id'] ;

    if (!$contact_id || !$user_id || !$interaction_type || !$status) {
        die("All required fields must be filled out.");
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO interactions (contact_id, user_id, interaction_type, notes, follow_up_date, status) 
            VALUES (:contact_id, :user_id, :interaction_type, :notes, :follow_up_date, :status)
        ");

        
        $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':interaction_type', $interaction_type, PDO::PARAM_STR);
        $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
        $stmt->bindParam(':follow_up_date', $follow_up_date, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);


        if ($stmt->execute()) {
            echo "Interaction saved successfully!";
            header("location:contact_interactions.php");
        } else {
            echo "Error saving interaction.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>

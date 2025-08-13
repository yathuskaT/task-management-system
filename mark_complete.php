<?php
require 'db_config.php';

// Check if both 'id' and 'status' are present in the URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $current_status = $_GET['status'];

    // --- TEMPORARY DEBUGGING CODE ---
    echo "ID: " . $id . "<br>";
    echo "Current Status: " . $current_status . "<br>";
    
    $new_status = ($current_status === 'completed') ? 'pending' : 'completed';

    try {
        $sql = "UPDATE task SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$new_status, $id]);
    } catch (PDOException $e) {
        // If there's a database error, this will show it.
        echo "Database Error: " . $e->getMessage();
    }
} else {
    echo "ID or status not set.";
}

// Redirect back to index.php
header("Location: index.php");
exit;
?>
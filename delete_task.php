<?php
require 'db_config.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM task WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error deleting task: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
    exit;
}
?>
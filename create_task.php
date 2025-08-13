<?php
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic form validation
    if (empty($_POST['title'])) {
        echo "Title is required!";
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];

        try {
            $sql = "INSERT INTO task (title, description, deadline, status) VALUES (?, ?, ?, 'pending')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $description, $deadline]);

            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Create a New Task</h1>

<form method="post" action="create_task.php">
    <div class="mb-3">
        <label for="title" class="form-label"> Task Title</label>
        <input type="text" class="form-control" id="title" name="title" required>   
    </div>

    <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>

    <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline">
    </div>

            <button type="submit" class="btn btn-success">Save Task</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>       
</body>
</html>
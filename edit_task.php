<?php
// Include the database connection file
require 'db_config.php';

$task = null;
$error = '';

// Check if an ID was passed in the URL (e.g., edit_task.php?id=12)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // Use a prepared statement to get the single task with the given ID
        $sql = "SELECT * FROM task WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        // Fetch the task data. fetch() is used because we only expect one result.
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        // If no task was found with that ID, set an error message
        if (!$task) {
            $error = "Task not found!";
        }

    } catch (PDOException $e) {
        $error = "Error fetching task: " . $e->getMessage();
    }
} else {
    // If no ID was provided in the URL, set an error message
    $error = "No task ID specified.";
}

// Check if the form was submitted with updated data
if ($_SERVER["REQUEST_METHOD"] == "POST") 
    // This is where we will write the code to handle the update.
    


// Check if the form was submitted with updated data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID from the URL and the updated data from the form.
    $id = $_GET['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    
    // Basic validation
    if (empty($title)) {
        $error = "Title is required!";
    } else {
        try {
            // Prepared statement to UPDATE the task
            $sql = "UPDATE task SET title = ?, description = ?, deadline = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            
            // Execute the statement with the new data
            $stmt->execute([$title, $description, $deadline, $id]);
            
            // Redirect back to the main page after a successful update
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Error updating task: " . $e->getMessage();
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Task</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php elseif ($task): ?>
            <form method="post" action="edit_task.php?id=<?= htmlspecialchars($task['id']) ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" value="<?= htmlspecialchars($task['deadline']) ?>">
                </div>

                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
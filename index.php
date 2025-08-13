<?php
require 'db_config.php';

$tasks = [];
try {
    $stmt = $pdo->query("SELECT * FROM task ORDER BY deadline ASC");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching tasks: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-dark text-white p-3 d-flex justify-content-between align-items-center"> 
        <h1>My Task Manager</h1>
        <form class="d-flex" action="index.php" method="get">
            <input class="form-control me-2" type="search" placeholder="Search tasks.." aria-label="Search" name="search">
            <button class="btn btn-outline-light" type="submit">Search</button>
</form>

<a href="create_task.php" class="btn btn-success">+ New Task</a>
</header>
    
<br><br><br>

<div class="container mt-5">
       <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Complete</th>
                    <th>Task Title</th>
                    <th>Description</th>
                    <th>Due</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task): ?>
                <td>
        <input type="checkbox"
               onchange="window.location.href='mark_complete.php?id=<?= htmlspecialchars($task['id']) ?>&status=<?= $task['status'] === 'completed' ? 'pending' : 'completed' ?>'"
               <?= $task['status'] === 'completed' ? 'checked' : '' ?>>
              </td>
             <td><?= htmlspecialchars($task['title']) ?></td>
             <td><?= htmlspecialchars($task['description']) ?></td>
             <td><?= htmlspecialchars($task['deadline']) ?></td>

                    <td> 
                        <a href="edit_task.php?id=<?= htmlspecialchars($task['id']) ?>" class="btn btn-sm btn-info text-white">Edit</a>
                        <a href="delete_task.php?id=<?= htmlspecialchars($task['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
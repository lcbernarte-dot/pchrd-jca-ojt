<?php

require_once "../config/database.php";

$db = (new Database())->connect();

session_start();

$id = (int)$_GET['id'];

$stmt = $db->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$row = $stmt->get_result()->fetch_assoc();

$isOwner = $_SESSION['user_id'] == $row ['user_id'];
$isAdmin = $_SESSION['role'] == "Administrator"; 

if (!$isOwner && !$isAdmin) {
    die("Access Denied.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Task</title>

<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

    <div class="task-header">

        <h1>Edit Task</h1>

        <a href="../task_details.php?id=<?= $row['id']; ?>" class="back-btn">
            Back
        </a>

    </div>

    <div class="card">

        <form action="task_actions.php" method="POST">

            <input
                type="hidden"
                name="action"
                value="update">

            <input
                type="hidden"
                name="id"
                value="<?= $row['id']; ?>">

            <input
                type="text"
                name="task"
                value="<?= htmlspecialchars($row['task']); ?>"
                required>

            <input
                type="text"
                name="description"
                value="<?= htmlspecialchars($row['description']); ?>"
                required>

            <select name="status">

                <option value="Pending"
                <?= $row['status']=="Pending"?"selected":"" ?>>
                    Pending
                </option>

                <option value="Completed"
                <?= $row['status']=="Completed"?"selected":"" ?>>
                    Completed
                </option>

            </select>

            <button type="submit">
                Update Task
            </button>

        </form>

    </div>

</div>

</body>
</html>
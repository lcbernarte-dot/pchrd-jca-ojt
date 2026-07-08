<?php

require_once "../config/database.php";

$db = (new Database())->connect();

session_start();

$id = (int)$_GET['id'];

$stmt = $db->prepare("
    SELECT
        sub_tasks.*,
        tasks.user_id
    FROM sub_tasks
    INNER JOIN tasks
        ON sub_tasks.task_id = tasks.id
    WHERE sub_tasks.id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    die("Sub Task not found.");
}

$isOwner = $_SESSION['user_id'] == $row['user_id'];
$isAdmin = $_SESSION['role'] == "Administrator";

if (!$isOwner && !$isAdmin) {
    die("Access Denied.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Sub Task</title>

<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

    <div class="task-header">

        <h1>Edit Sub Task</h1>

        <a
            href="../task_details.php?id=<?= $row['task_id']; ?>"
            class="back-btn">

            Back

        </a>

    </div>

    <div class="card">

        <form action="subtask_actions.php" method="POST">

            <input type="hidden"
                   name="action"
                   value="update">

            <input type="hidden"
                   name="id"
                   value="<?= $row['id']; ?>">

            <input type="hidden"
                   name="task_id"
                   value="<?= $row['task_id']; ?>">

            <input
                type="text"
                name="sub_task"
                value="<?= htmlspecialchars($row['sub_task']); ?>"
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
                Update
            </button>

        </form>

    </div>

</div>

</body>
</html>
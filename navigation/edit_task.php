<?php

require_once "../config/database.php";

$db = (new Database())->connect();

$id = $_GET['id'];

$result = $db->query(
    "SELECT * FROM tasks WHERE id = $id"
);

$row = $result->fetch_assoc();

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
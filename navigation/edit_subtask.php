<?php

require_once "../config/database.php";

$db = (new Database())->connect();

$id = $_GET['id'];

$result = $db->query(
    "SELECT * FROM sub_tasks WHERE id = $id"
);

$row = $result->fetch_assoc();

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
<?php

require_once "config/database.php";

$db = (new Database())->connect();

$id = $_GET['id'];

$stmt = $db->prepare(
    "SELECT * FROM users WHERE id=?"
);

$stmt->bind_param("i",$id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
if(!$user){
    die("User not found.");
}

$taskStmt = $db->prepare(
    "SELECT * FROM tasks WHERE user_id = ?"
);

$taskStmt->bind_param("i", $id);
$taskStmt->execute();
$tasks = $taskStmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="card">

        <h2>User Details</h2>

            <p><strong>ID:</strong> <?= $user['id']; ?></p>
            <p><strong>First Name:</strong> <?= $user['first_name']; ?></p>
            <p><strong>Last Name:</strong> <?= $user['last_name']; ?></p>
            <p><strong>Email:</strong> <?= $user['email']; ?></p>
            <p><strong>Role:</strong> <?= $user['role']; ?></p>

        <a href="index.php" class="view-btn"> Back </a>

    </div>

    <div class="card">

        <h2>User Tasks</h2>

    <?php if($tasks->num_rows > 0): ?>

<?php while($task = $tasks->fetch_assoc()): ?>

    <div class="item-row">

        <h3>
            <a href="task_details.php?id=<?= $task['id']; ?>">
                <?= $task['task']; ?>
            </a>
        </h3>

        <p><?= $task['description']; ?></p>

        <p>
            Status:
            <strong><?= $task['status']; ?></strong>
        </p>

    </div>

    <?php

    $subStmt = $db->prepare(
        "SELECT * FROM sub_tasks WHERE task_id = ?"
    );

    $subStmt->bind_param(
        "i",
        $task['id']
    );

    $subStmt->execute();
    $subtasks = $subStmt->get_result();

    ?>

    <h4>Sub Tasks</h4>

    <?php if($subtasks->num_rows > 0): ?>

        <?php while($sub = $subtasks->fetch_assoc()): ?>

            <p>
                • <?= $sub['sub_task']; ?>
                (<?= $sub['status']; ?>)
            </p>

        <?php endwhile; ?>

    <?php else: ?>

        <p>No subtasks found.</p>

    <?php endif; ?>

    <?php

    $commentStmt = $db->prepare(
        "SELECT * FROM comments WHERE task_id = ?"
    );

    $commentStmt->bind_param("i", $task['id']);
    $commentStmt->execute();
    $comments = $commentStmt->get_result();

    ?>

    <h4>Comments</h4>

    <?php if($comments->num_rows > 0): ?>

        <?php while($comment = $comments->fetch_assoc()): ?>

            <p>
                💬 <?= htmlspecialchars($comment['comment']); ?>
            </p>

        <?php endwhile; ?>

    <?php else: ?>

        <p>No comments found.</p>

    <?php endif; ?>

    <hr>

<?php endwhile; ?>

<?php else: ?>

    <p>No tasks assigned.</p>

<?php endif; ?>

    </div>

</div>

</body>
</html>
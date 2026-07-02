<?php

require_once "config/database.php";

$db = (new Database())->connect();

$id = $_GET['id'];

$stmt = $db->prepare(
    "SELECT * FROM users WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
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

    <div class="card user-details-card">

        <h2>User Details</h2>

        <div class="user-details-grid">

            <div class="detail-box">
                <div class="detail-label">ID:</div>
                <div class="detail-value"><?= $user['id']; ?></div>
            </div>

            <div class="detail-box">
                <div class="detail-label">User ID:</div>
                <div class="detail-value"><?= $user['id']; ?></div>
            </div>

            <div class="detail-box">
                <div class="detail-label">First Name:</div>
                <div class="detail-value"><?= $user['first_name']; ?></div>
            </div>

            <div class="detail-box">
                <div class="detail-label">Last Name:</div>
                <div class="detail-value"><?= $user['last_name']; ?></div>
            </div>

            <div class="detail-box">
                <div class="detail-label">Email:</div>
                <div class="detail-value"><?= $user['email']; ?></div>
            </div>

            <div class="detail-box">
                <div class="detail-label">Role:</div>
                <div class="detail-value"><?= $user['role']; ?></div>
            </div>

        </div>

        <div class="user-actions">

            <a href="admin_dashboard.php" class="back-btn">
                ←
            </a>

        </div>

    </div>

    <div class="card">

        <h2>User Tasks</h2>

        <?php if($tasks->num_rows > 0): ?>

            <?php while($task = $tasks->fetch_assoc()): ?>

                <div class="task-item">

                    <div class="task-header">
                        <h3>
                            <a href="task_details.php?id=<?= $task['id']; ?>&from=admin&user_id=<?= $user['id']; ?>">
                                <?= $task['task']; ?>
                            </a> 
                        </h3>

                        <span class="task-status">
                            Status:
                            <strong>
                                <?= $task['status']; ?>
                            </strong>
                        </span>
                    </div>

                    <p class="task-description">
                        <?= $task['description']; ?>
                    </p>

                    <div class="task-datetime">
                        <span>
                            <strong>Created:</strong>
                            <?= date("M d, Y h:i A", strtotime($task['created_at'])) ?>
                        </span>

                        <span>
                            <strong>Last Updated:</strong>
                            <?= date("M d, Y h:i A", strtotime($task['updated_at'])) ?>
                        </span>
                    </div>
                     <br>

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
                                (<strong><?= $sub['status']; ?></strong>)
                            </p>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <p>No subtasks found.</p>

                    <?php endif; ?>
                    
                    <br>
                    
                    <?php
                    $commentStmt = $db->prepare(
                        "SELECT * FROM comments WHERE task_id = ?"
                    );

                    $commentStmt->bind_param(
                        "i",
                        $task['id']
                    );

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

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p>No tasks assigned.</p>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
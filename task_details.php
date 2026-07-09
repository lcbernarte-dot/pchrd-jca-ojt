<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: Sessions/login.php");
    exit;
}

require_once "config/database.php";
require_once "models/SubTasks.php";
require_once "models/Comment.php";

$db = (new Database())->connect();
$subTaskModel = new SubTasks($db);
$commentModel = new Comment($db);

$task_id = $_GET['id'];

$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$task = $stmt->get_result()->fetch_assoc();

$subtasks = $subTaskModel->getByTaskId($task_id);
$comments = $commentModel->getByTaskId($task_id);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="header">

        <h1>Task Details</h1>

            <?php if($_SESSION['role'] == 'Administrator'): ?>
                <a href="admin_dashboard.php" class="logout-btn">Back</a>
            <?php else: ?>
                <a href="user_task_manager.php" class="logout-btn">Back</a>
            <?php endif; ?>

    </div>

<div class="card">

    <div class="task-header">

        <div class="task-info">

            <h2><?= $task['task']; ?></h2>

            <p><?= $task['description']; ?></p>

            <br>

            <p><strong>Status:</strong> <?= $task['status']; ?></p>

        <div class="task-datetime">

                <span>
                    🕒 <strong>Created:</strong>
                    <?= date("F d, Y h:i A", strtotime($task['created_at'])); ?>
                </span>

                <span>
                    ✏️ <strong>Updated:</strong>
                    <?= date("F d, Y h:i A", strtotime($task['updated_at'])); ?>
                </span>

        </div>

    </div>

        <div class="task-actions">

            <?php
            $isOwner = $_SESSION['user_id'] == $task['user_id'];
            $isAdmin = $_SESSION['role'] == "Administrator";
            ?>

            <?php if($isOwner || $isAdmin): ?>

            <a href="navigation/edit_task.php?id=<?= $task['id']; ?>" class="edit-btn">
                Edit Task
            </a>

            <a href="navigation/task_actions.php?action=delete&id=<?= $task['id']; ?>" class="delete-btn">
                Delete Task
            </a>    

            <?php endif; ?>

        </div>

    </div>

</div>

    <div class="card">

        <h2>Sub Tasks</h2>

            <?php while($row = $subtasks->fetch_assoc()): ?>

        <div class="item-row">

            <span>
                <?= $row['sub_task']; ?>
                (<?= $row['status']; ?>)
            </span>

        <div>

            <?php if($isOwner || $isAdmin): ?>

                <a
                    href="navigation/edit_subtask.php?id=<?= $row['id']; ?>"
                    class="edit-btn">
                    Edit
                </a>

                <a
                    href="navigation/subtask_actions.php?action=delete&id=<?= $row['id']; ?>"
                    class="delete-btn"
                    onclick="return confirm('Delete Subtask?')">
                    Delete
                </a>

            <?php endif; ?>

            </div>

        </div>

            <?php endwhile; ?>

        <hr><br>
        
            <?php if($isOwner || $isAdmin): ?>

        <form class="task-form" action="navigation/subtask_actions.php" method="POST">

            <input
                type="hidden"
                name="action"
                value="create"
            >

            <input
                type="hidden"
                name="task_id"
                value="<?= $task['id']; ?>"
            >

            <input
                type="text"
                name="sub_task"
                placeholder="Sub Task"
                required
            >

            <select name="status">

                <option value="Pending">
                    Pending
                </option>

                <option value="Completed">
                    Completed
                </option>

            </select>

            <button type="submit">
                Add Sub Task
            </button>

        </form>
            <?php endif; ?>

    </div>

    <div class="card">

        <h2>Comments</h2>

            <?php
            $groupedComments = [];

            while($row = $comments->fetch_assoc()){
                $name = $row['first_name'] . ' ' . $row['last_name'];

                $groupedComments[$name][] = $row;
            }
            ?>

            <?php foreach($groupedComments as $name => $userComments): ?>

            <div class="comment-box">

                <div class="comment-top">

                    <div class="comment-name">
                        <strong><?= htmlspecialchars($name); ?></strong>
                    </div>

                </div>

                <div class="comment-body">

            <?php foreach($userComments as $comment): ?>

            <?php
            $canManageComment =
                ($_SESSION['user_id'] == $comment['user_id']) || $isAdmin;
            ?>

            <div class="comment-item">

                <div class="comment-text">
                    • <?= htmlspecialchars($comment['comment']); ?>
                </div>

                <?php if($canManageComment): ?>

                <div class="comment-actions">

                    <a href="navigation/edit_comment.php?id=<?= $comment['id']; ?>"
                    class="edit-btn">
                        Edit
                    </a>

                    <a href="navigation/comment_actions.php?action=delete&id=<?= $comment['id']; ?>&task_id=<?= $task['id']; ?>"
                    class="delete-btn">
                        Delete
                    </a>

                </div>

                <?php endif; ?>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

            <?php endforeach; ?>

        <hr><br>

        <form class="comment-form" action="navigation/comment_actions.php" method="POST">

            <input
                type="hidden"
                name="action"
                value="create"
            >

            <input
                type="hidden"
                name="task_id"
                value="<?= $task['id']; ?>"
            >

            <input
                type="text"
                name="comment"
                placeholder="Write Comment"
                required
            >

            <button type="submit">
                Add Comment
            </button>

        </form>

    </div>

</div>

</body>
</html>
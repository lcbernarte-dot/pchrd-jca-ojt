
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

        <p>
            <strong>Status:</strong>
            <?= $task['status']; ?>
        </p>

    </div>

    <div class="task-actions">

        <a
            href="navigation/edit_task.php?id=<?= $task['id']; ?>"
            class="edit-btn"
        >
            Edit Task
        </a>

        <a
            href="navigation/task_actions.php?action=delete&id=<?= $task['id']; ?>"
            class="delete-btn"
            onclick="return confirm('Delete Task?')"
        >
            Delete Task
        </a>

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

                <a
                    href="navigation/edit_subtask.php?id=<?= $row['id']; ?>"
                    class="edit-btn"
                >
                    Edit
                </a>

                <a
                    href="navigation/subtask_actions.php?action=delete&id=<?= $row['id']; ?>"
                    class="delete-btn"
                    onclick="return confirm('Delete Subtask?')"
                >
                    Delete
                </a>

            </div>

        </div>

        <?php endwhile; ?>

        <hr><br>

        <form action="navigation/subtask_actions.php" method="POST">

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

    </div>

    <div class="card">

        <h2>Comments</h2>

        <?php while($row = $comments->fetch_assoc()): ?>

        <div class="item-row">

            <span><?= $row['comment']; ?></span>

            <div>

                <a
                    href="navigation/edit_comment.php?id=<?= $row['id']; ?>"
                    class="edit-btn"
                >
                    Edit
                </a>

                <a
                    href="navigation/comment_actions.php?action=delete&id=<?= $row['id']; ?>&task_id=<?= $task['id']; ?>"
                    class="delete-btn"
                    onclick="return confirm('Delete Comment?')"
                >
                    Delete
                </a>

            </div>

        </div>

        <?php endwhile; ?>

        <hr><br>

        <form action="navigation/comment_actions.php" method="POST">

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
                type="hidden"
                name="user_id"
                value="<?= $_SESSION['user_id']; ?>"
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
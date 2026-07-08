<?php

require_once "../config/database.php";

$db = (new Database())->connect();

$id = $_GET['id'];

session_start();

$stmt = $db->prepare(
    "SELECT
        comments.*,
        tasks.user_id
    FROM comments
    INNER JOIN tasks
        ON comments.task_id = tasks.id
    WHERE comments.id = ?"
    );

$stmt->bind_param("i",$id);
$stmt->execute();

$row=$stmt->get_result()->fetch_assoc();

$isOwner = $_SESSION['user_id']==$row['user_id'];
$isAdmin = $_SESSION['role']=="Administrator";

if(!$isOwner && !$isAdmin){
    die("Access Denied.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Comment</title>

<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

    <div class="task-header">

        <h1>Edit Comment</h1>

        <a
            href="../task_details.php?id=<?= $row['task_id']; ?>"
            class="back-btn">

            Back

        </a>

    </div>

    <div class="card">

        <form action="comment_actions.php" method="POST">

            <input
                type="hidden"
                name="action"
                value="update">

            <input
                type="hidden"
                name="id"
                value="<?= $row['id']; ?>">

            <input
                type="hidden"
                name="task_id"
                value="<?= $row['task_id']; ?>">

            <input
                type="text"
                name="comment"
                value="<?= htmlspecialchars($row['comment']); ?>"
                required>

            <button type="submit">
                Update Comment
            </button>

        </form>

    </div>

</div>

</body>
</html>
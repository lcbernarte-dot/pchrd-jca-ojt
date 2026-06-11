<?php

require_once "../config/database.php";

$db = (new Database())->connect();

$id = $_GET['id'];

$result = $db->query(
    "SELECT * FROM comments WHERE id = $id"
);

$row = $result->fetch_assoc();

?>

<form action="comment_actions.php" method="POST">

    <input
        type="hidden"
        name="action"
        value="update"
    >

    <input
        type="hidden"
        name="id"
        value="<?= $row['id']; ?>"
    >

    <input
        type="text"
        name="comment"
        value="<?= $row['comment']; ?>"
    >

    <button type="submit">
        Update Comment
    </button>

</form>
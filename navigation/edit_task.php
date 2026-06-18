<?php

require_once "../config/database.php";

$db = (new Database())->connect();

$id = $_GET['id'];

$result = $db->query(
    "SELECT * FROM tasks WHERE id = $id"
);

$row = $result->fetch_assoc();

?>

<form action="task_actions.php" method="POST">

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
        name="task"
        value="<?= $row['task']; ?>"
    >

    <input
        type="text"
        name="description"
        value="<?= $row['description']; ?>"
    >

    <select name="status">

        <option
            <?= $row['status']=="Pending"?"selected":"" ?>
        >
            Pending
        </option>

        <option
            <?= $row['status']=="Completed"?"selected":"" ?>
        >
            Completed
        </option>

    </select>

    <button type="submit">
        Update
    </button>

</form>
<?php

require_once "../config/database.php";

$db = (new Database())->connect();

$id = $_GET['id'];

$result = $db->query(
    "SELECT * FROM sub_tasks WHERE id = $id"
);

$row = $result->fetch_assoc();

?>

<form action="subtask_actions.php" method="POST">

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
        name="sub_task"
        value="<?= $row['sub_task']; ?>"
    >

    <select name="status">

        <option
            value="Pending"
            <?= $row['status']=="Pending" ? "selected" : "" ?>
        >
            Pending
        </option>

        <option
            value="Completed"
            <?= $row['status']=="Completed" ? "selected" : "" ?>
        >
            Completed
        </option>

    </select>

    <button type="submit">
        Update
    </button>

</form>
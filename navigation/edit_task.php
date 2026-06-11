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

<select name="user_id" required>

    <option value="">
        Select User
    </option>

    <?php
    $users = $user->getUsers();

    while($row = $users->fetch_assoc()){
    ?>

        <option value="<?= $row['id']; ?>">
            <?= $row['first_name']; ?>
            <?= $row['last_name']; ?>
            (ID: <?= $row['id']; ?>)
        </option>

    <?php } ?>

</select>

    <button type="submit">
        Update
    </button>

</form>
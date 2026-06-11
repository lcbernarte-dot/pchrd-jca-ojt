<?php if (!isset ($taskResult)) return; ?>


<div class="card">

    <h2>Tasks Table</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Task</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while($row = $taskResult->fetch_assoc()){?>

        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['user_id']; ?></td>
            <td><?= $row['task']; ?></td>
            <td><?= $row['description']; ?></td>
            <td><?= $row['status']; ?></td>
            <td>
                <a
                    href="navigation/edit_task.php?id=<?= $row['id']; ?>"
                    class="edit-btn"    
                >
                    Edit
                </a>
                <a 
                    href="navigation/task_actions.php?action=delete&id=<? $row["id"]; ?>"
                    class="delete=btn"
                    onlick="return confirm('Delete task?')"
                >
                    Delete
                </a>
            </td>

        </tr>

        <?php } ?>

    </table>

</div>
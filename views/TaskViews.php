<?php if (!isset($taskResult)) return; ?>

<?php if($taskResult->num_rows > 0): ?>

<div class="card">

    <h2>Tasks Table</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Task</th>
            <th>Description</th>
            <th>Status</th>
            <th></th>
        </tr>

        <?php while($row = $taskResult->fetch_assoc()){ ?>

        <tr>

            <td><?= $row['id']; ?></td>
            <td><?= $row['user_id']; ?></td>
            <td><?= $row['task']; ?></td>
            <td><?= $row['description']; ?></td>
            <td><?= $row['status']; ?></td>

            <td>

                <a
                    href="task_details.php?id=<?= $row['id']; ?>"
                    class="view-btn">
                    View
                </a>

                <a
                    href="navigation/edit_task.php?id=<?= $row['id']; ?>"
                    class="edit-btn">
                    Edit
                </a>

                <a
                    href="navigation/task_actions.php?action=delete&id=<?= $row['id']; ?>"
                    class="delete-btn"
                    onclick="return confirm('Delete Task?')">
                    Delete
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<?php else: ?>

<div class="card">

    <h2>Tasks Table</h2>

    <p>No tasks found.</p>

</div>

<?php endif; ?>
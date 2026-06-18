<?php if (!isset ($subtaskResult)) return; ?>

<div class="card">

    <h2>Sub Tasks Table</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Sub Task</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while($row = $subtaskResult->fetch_assoc()): ?>

        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['sub_task']; ?></td>
            <td><?= $row['status']; ?></td>
            <td>
                <a
                    href="navigation/edit_subtask.php?id=<?= $row['id']; ?>"
                    class="edit-btn"
            >
                    Edit
                </a>

                <a
                    href="navigation/subtask_action.php?actions=delete&id=<?=  $row['id']; ?>"
                    class="delete-btn"
                    onclick="return confirm ('Delete Subtask?')"
            >
                    Delete
                </a>
            </td>
        </tr>

        <?php endwhile; ?>

    </table>

</div>
<?php if (!isset ($commentResult)) return; ?>

<div class="card">

        <h2>Comments Table</h2>

        <table>

            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Task ID</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>

            <?php
            while($row = $commentResult->fetch_assoc()){
            ?>

            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['user_id']; ?></td>
                <td><?= $row['task_id']; ?></td>
                <td><?= $row['comment']; ?></td>
                <td>
                    <a
                        href="navigation/edit_comment.php?id=<?= $row['id']; ?>"
                        class="edit-btn"
                    >
                        Edit
                    </a>
                    <a
                        href="navigation/comment_actions.php?action=delete&id=<?= $row['id']; ?>&task_id=<?= $row['task_id']; ?>"
                        class="delete-btn"
                        onclick="return confirm ('Delete Comment?')"
                    >
                        Delete
                    </a>
                </td>
            </tr>

            <?php } ?>

        </table>

    </div>
<?php if (!isset ($commentResult)) return; ?>

<div class="card">

        <h2>Comments Table</h2>

        <table>

            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Task ID</th>
                <th>Comment</th>
                <th></th>
            </tr>

            <?php while($row = $commentResult->fetch_assoc()){ ?>

            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['user_id']; ?></td>
                <td><?= $row['task_id']; ?></td>
                <td><?= $row['comment']; ?></td>
            </tr>

            <?php } ?>

        </table>
</div>
<?php if (!isset ($commentResult)) return; ?>

<div class="card">

        <h2>Comments Table</h2>

        <table>

            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Task ID</th>
                <th>Comment</th>
            </tr>

            <?php
            while($row = $commentResult->fetch_assoc()){
            ?>

            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['task_id']; ?></td>
                <td><?php echo $row['comment']; ?></td>
            </tr>

            <?php } ?>

        </table>

    </div>
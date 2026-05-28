<?php if (!isset ($subtaskResult)) return; ?>

<div class="card">

    <h2>Sub Tasks Table</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Task ID</th>
            <th>Sub Task</th>
            <th>Status</th>
        </tr>

        <?php
        while($row = $subtaskResult->fetch_assoc()){
        ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['task_id']; ?></td>
            <td><?php echo $row['sub_task']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>

        <?php } ?>

    </table>

</div>
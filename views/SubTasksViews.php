<?php if (!isset ($subtaskResult)) return; ?>

<div class="card">

    <h2>Sub Tasks Table</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Sub Task</th>
            <th>Status</th>
            <th></th>
        </tr>

        <?php while($row = $subtaskResult->fetch_assoc()): ?>

        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['sub_task']; ?></td>
            <td><?= $row['status']; ?></td>
        </tr>

        <?php endwhile; ?>

    </table>

</div>
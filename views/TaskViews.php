<div class="card">

    <h2>Tasks Table</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Task</th>
            <th>Description</th>
            <th>Status</th>
            
        </tr>

        <?php
        while($row = $taskResult->fetch_assoc()){
        ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['task']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['status']; ?></td>
            
        </tr>

        <?php } ?>

    </table>

</div>
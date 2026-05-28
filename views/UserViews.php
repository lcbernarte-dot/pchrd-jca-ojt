<?php if (!isset($userResult)) return; ?>

<div class="card">

        <h2>Users Table</h2>

    <table>

            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>

            <?php
            while($row = $userResult->fetch_assoc()){
            ?>

            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
            </tr>

            <?php } ?>

    </table>
</div>
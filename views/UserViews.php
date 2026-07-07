<?php if (!isset($userResult)) return; ?>

<div class="card">

    <h2>Users Table</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role</th>
            <th></th>
        </tr>

        <?php while($row = $userResult->fetch_assoc()): ?>

        <tr>

            <td><?= $row['id']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['first_name']; ?></td>
            <td><?= $row['last_name']; ?></td>
            <td><?= $row['role']; ?></td>

            <td>
                <a
                    href="user_details.php?id=<?= $row['id']; ?>"
                    class="view-btn"
                >
                    View
                </a>
                
                <a
                    href="navigation/user_actions.php?action=delete&id=<?= $row['id']; ?>"
                    class="delete-btn"
                    onclick="return confirm('Are you sure you want to delete this user?');"
                >
                    Delete
                </a>
            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>
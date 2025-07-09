<!DOCTYPE html>
<html>
<head>
    <title>User Form</title>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>User Form</h2>

    <?php if (!empty($success)) : ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>username:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($user->name) ?>"><br>

        <label>Email:</label><br>
        <input type="text" name="email" value="<?= htmlspecialchars($user->email) ?>"><br>
        <span class="error"><?= $this->errors['email'] ?? '' ?></span><br><br>

        <label>Password:</label><br>
        <input type="password" name="password1" value="<?= htmlspecialchars($user->email) ?>"><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="password2" value="<?= htmlspecialchars($user->email) ?>"><br>

        <input type="submit" value="Submit">

        <br><br>
        <?php
        foreach ($this->errors as $error) {
            echo "<span class=\"error\">" . $error . "</span><br><br>";
        }?>
    </form>
</body>
</html>

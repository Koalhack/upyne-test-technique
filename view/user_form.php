<?php

$errors = $this->errors;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      background-color: #121212;
      color: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: Arial, sans-serif;
    }

    .form-container {
      background-color: #1e1e1e;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
    }

    input {
      width: 100%;
      padding: 0.5rem;
      border: none;
      border-radius: 5px;
      background-color: #2c2c2c;
      color: #fff;
    }

    .error-message {
      color: #ff6b6b;
      font-size: 0.85rem;
      margin-top: 0.3rem;
    }

    .success-message {
      color: #4caf50;
      font-size: 1.2rem;
    }

    button {
      width: 100%;
      padding: 0.7rem;
      background-color: #4caf50;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 1rem;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
<div class="form-container">
  <h2>Create Account</h2>

  <?php if (!empty($success)) : ?>
    <div class="success-message" id="success"><?= $success ?></div>
  <?php endif; ?>

  <form id="createAccountForm" method="POST" action="">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" />
    <div class="error-message" id="usernameError"><?= $errors["username"] ?? '' ?></div>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" />
    <div class="error-message" id="emailError"><?= $errors["email"] ?? '' ?> <?= $errors["emailFormat"] ?? '' ?></div>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" />
    <div class="error-message" id="passwordError"><?= $errors["password"] ?? '' ?> <?= $errors["passwordLength"] ?? '' ?></div>
    </div>

    <div class="form-group">
      <label for="passwordConfirm">Confirm Password</label>
      <input type="password" id="passwordConfirm" name="passwordConfirm" />
    <div class="error-message" id="passwordConfirmError"><?= $errors["passwordConfirm"] ?? '' ?> <?= $errors["passwordCheck"] ?? '' ?></div>
    </div>

    <button type="submit">Sign Up</button>
  </form>
</div>
</body>
</html>

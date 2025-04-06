<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="school-logo.png" alt="School Logo" width="70">
        </div>
        <h1 class="school-name1">SYSTEMS PLUS COLLEGE FOUNDATION</h1>
    </header>
    <br>
    <main>
        <div class="login-container">
            <form method="post" action="validate.php">
                <h2>Login</h2>
                <label for="user">Username:</label>
                <input type="text" id="user" name="user" placeholder="Enter your username" required>
                <label for="pass">Password:</label>
                <input type="password" id="pass" name="pass" placeholder="Enter your password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </main>
</body>
</html>

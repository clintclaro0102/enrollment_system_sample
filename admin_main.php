<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title><!-- Link to your external CSS file (styles.css) -->
    <link rel="stylesheet" href="styles3.css"> 
</head>
<style>
</style>
<body>
    <header>
        <div class="logo">
            <a>
                <img src="school-logo.png" alt="School Logo" width="70">
            </a>
        </div>
        <h1 class="school-name">SYSTEMS PLUS COLLEGE FOUNDATION</h1>
        <p class="admin">Admin</p> 
        <a href="javascript:void(0);" onclick="logout()">Logout</a>
        <script>
            function logout() {
                var confirmLogout = confirm("You are logging out...");
                if (confirmLogout) {
                    window.location.href = "index.php";
                }
            }
        </script> 
    </header>
    
    <main>
        <table>
            <tr>
                <td>
                    <div class="logo-button">
                        <a href="search.php">
                            <img src="search.png" alt="Search" width="100">
                            <p class="button-label">Search</p>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="logo-button">
                        <a href="registeracc.php">
                            <img src="registeracc.png" alt="Register Account" width="100">
                            <p class="button-label">Register Account</p>
                        </a>
                    </div>
                </td>
            </tr>
        </table>
    </main>
</body>
</html>

<?php
//Cookie algorithm, the most interesting part of this challenge.
function setCookieWithUsername($username) {
    setcookie("user_cookie", md5($username), time() + 3600, "/");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    if (strtolower($username) === "admin") {
        echo "Sorry, registration for " . $_POST['username'] ." is not allowed.";
    } else {
        setCookieWithUsername($username);
        echo "Registration successful. Redirecting to flag.php...";
        header("refresh:1;url=?flag");
        exit();
    }
}

$userCookie = isset($_COOKIE['user_cookie']) ? $_COOKIE['user_cookie'] : '';

if ($userCookie === md5('admin')) {
    
    $flagContent = file_get_contents('flag.txt');
    echo "<h1>Flag Content:</h1><h3>$flagContent</h3>";

} elseif (isset($_GET['flag'])) {
    echo "<h1>Only admin can read flag.txt.</h1>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>

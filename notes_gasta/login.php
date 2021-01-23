<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/app.js"></script>
</head>
<body>



    <div class="frm">
        <form method="POST" action="authenticate.php">
            <h1 class="head1">Logging In</h1>
            <label for="">Username:</label>
            <input type="text" name="username" id="username">
            <br><br>
            <label for="">Password:</label>
            <input type="password" name="password" id="password">
            <br><br>
            <div>
                <button type="button" value="submit" id="logIn">Login</button>
                <p>
                    Not a member yet?<a href="registration.php"> Register here!</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
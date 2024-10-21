<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div id="res"></div>
    <div class="container col-sm-11 col-md-4 mt-5">
        <div class="col-md-12 mb-5">
            <h2>Attendance Management System</h2>
        </div>

        <form action="/handlers/loginHandler.php" method="post" id="login">
            <div class="mb-3">
                <label for="mail" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username" required>

            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" id="pass" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <div class="diverror topmarginlarge" id="diverror">
                <label class="errormessage" id="errormessage"></label>
            </div>
        </form>
        
    </div>

    <script src="./js/jquery.js"></script>
    <script src="./js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>
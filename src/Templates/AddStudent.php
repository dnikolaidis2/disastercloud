<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add student · Disastercloud</title>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/custom.css">
    <script src="assets/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/stylesheet.css"> 
</head>
<body class="bg-light h-100">
<header>
    <div class="navbar navbar-dark bg-dark">
        <div class="container justify-content-between">
            <a class="navbar-brand" href="/Teacher.php">
                <h1 class="my-0">Disastercloud</h1>
            </a>
            <form method="post" action="index.php" class="form-inline">
                <input type="hidden" name="action" value="logout">
                <label class="mr-sm-2 text-light"><?=$username?></label>
                <button type="submit" class="btn btn-danger my-2 my-sm-0">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</header>
<main class="h-100">
    <div class="container h-100 py-4 bg-white">
        <div class="row justify-content-center py-3">
            <div class="col-1"></div>
            <div class="col">
                <h2 >Add Student</h2>
            </div>
            <div class="col"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-1"></div>
            <div class="col">
                <form action="AddStudent.php" method="post">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" name="name" id="firstName" placeholder="John" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" name="surname" id="lastName" placeholder="Doe" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="fatherName">Father's Name</label>
                                <input type="text" class="form-control" name="fathername" id="fatherName" placeholder="Mark" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="grade">Grade</label>
                                <input type="number" step="0.01" max="10.0" min="0.0" class="form-control" name="grade" id="grade" placeholder="7.5" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="mobileNumber">Mobile number</label>
                                <input type="text" class="form-control" name="mobilenumber" id="mobileNumber" placeholder="6940035763" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="dateOfBirth">Date of birth</label>
                                <input type="date" class="form-control" name="birthday" id="dateOfBirth" required>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end mr-0">
                        <button class="btn btn-secondary mx-1" type="reset">Clear</button>
                        <button class="btn btn-primary" type="submit">Add</button>    
                    </div>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</main>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  	<style>

      body {
        background-color: #bdc3c7;
      }

      #main {
        background-color: #2c3e50;
        padding-top: 2%;
        padding-bottom: 2%;
      }

      #text-main {
        color: #bdc3c7;
      }

    </style>

  </head>
  <body>

  <?php
    $login_active = true;
    if ($_SERVER["REQUEST_METHOD"] === "GET")
    {
      if (!empty($_GET["singup"]) && ($_GET["singup"] == true))
      {
        $signup_active = true;
        $login_active = false;
      }
    }
    elseif ($_SERVER["REQUEST_METHOD"] === "POST") 
    {
      if (empty($_POST["username"])) 
      {
        echo '<p>field username is required</p>';
      } 
      else 
      {
        $username = test_input($_POST["username"]);
      }

      if (empty($_POST["password"])) 
      {
        echo '<p>field passowrd is required</p>';
      }
      else 
      {
        $password = test_input($_POST["password"]);
      }

      $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] . ';dbname='. $_ENV["MYSQL_DATABASE"] , $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"]);
      
    }
    else
    {
      echo '<p>unsuported requst method</p>';
    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  ?>

  <br>
  <div class="container" id="main">
    <div class="row justify-content-center">
      <div class="col"></div>
      <div class="col-10">
        <ul class="nav nav-tabs nav-fill justify-content-center">
          <li class="nav-item">
            <a class="nav-link <?php if ($login_active) { echo "active"; }?>" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="false">Log In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($signup_active) { echo "active"; }?>" id="signup-tab" data-toggle="tab" href="#singup" role="tab" aria-controls="signup" aria-selected="true">Sign Up</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade <?php if ($login_active) { echo "show active"; }?>" id="login" role="tabpanel" aria-labelledby="login-tab">
            <form method="post" action="index.php">
              <div class="form-group">
                <label for="username" id="text-main">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password" id="text-main">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
              </div>
              <div class="alert alert-danger invisible" role="alert">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </form>
          </div>
          <div class="tab-pane fade <?php if ($signup_active) { echo "show active"; }?>" id="singup" role="tabpanel" aria-labelledby="signup-tab">
            <form method="post" action="index.php">
              <div class="form-group">
                <label for="firstName" id="text-main">First name</label>
                <input type="text" class="form-control" id="firstName" placeholder="John" name="name" required>
              </div>
              <div class="form-group">
                <label for="lastName" id="text-main">Last name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Doe" name="surname" required>
              </div>
              <div class="form-group">
                <label for="email" id="text-main">Email</label>
                <input type="email" class="form-control" id="email" placeholder="john.doe@mail.com" name="email" required>
              </div>
              <div class="form-group">
                <label for="username" id="text-main">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password" id="text-main">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
              </div>
              <div class="alert alert-danger invisible" role="alert">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Sing Up</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col"></div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      html,
      body {
        height: 100%;
      }

      body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-login {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
      }
      .form-login .checkbox {
        font-weight: 400;
      }
      .form-login .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
      }
      .form-login .form-control:focus {
        z-index: 2;
      }
      .form-login input[type="username"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
      .form-login input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }

    </style>

</head>
<body>

<?php
	if ($_SERVER["REQUEST_METHOD"] === "GET")
	{
		echo '<form class="form-login" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
				<h1 class="h3 mb-3 font-weight-normal">Login in</h1>
				<label for="inputUsername" class="sr-only">Username</label>
				<input type="username" id="inputUsername" class="form-control" placeholder="Username" name="username" required autofocus>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Login in</button>
			</form>';
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
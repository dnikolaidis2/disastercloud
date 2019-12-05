<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome · Disastercloud</title>
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
        </div>
    </div>
</header>
<main class="h-100">
    <div class="container h-100 py-5">
        <div class="row justify-content-center flex-fill flex-grow-1 align-self-center">
            <div class="col"></div>
            <div class="col-6 bg-white card px-0">
                <ul class="nav nav-tabs nav-fill justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link 
                        <?php if (isset($login)): ?>
                            active
                        <?php else: ?>
                            bg-light-light
                        <?php endif; ?>" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login"
                        aria-selected="<?php if (isset($signup)): ?>
                            true
                        <?php else: ?>
                            false
                        <?php endif; ?>">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link 
                        <?php if (isset($signup)): ?>
                            active
                        <?php else: ?>
                            bg-light-light
                        <?php endif; ?>" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" 
                        aria-selected="<?php if (isset($signup)): ?>
                            true
                        <?php else: ?>
                            false
                        <?php endif; ?>">Sign Up</a>
                    </li>
                </ul>
                <div class="tab-content p-4">
                    <div class="tab-pane fade 
                    <?php if (isset($login)): ?>
                        show active
                    <?php endif; ?>" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form method="post" action="index.php">
                            <input type="hidden" id="action" value="login" name="action">
                            <div class="form-group">
                                <label for="login-username" id="text-main">Username</label>
                                <input type="text" class="form-control
                                <?php if(isset($username_error)): ?>
                                    is-invalid
                                <?php endif; ?>" id="login-username" placeholder="Username" name="username"
                                value="<?=$previous_data['username']?>" required>
                                <?php if(isset($username_error)): ?>
                                    <div class="invalid-feedback">
                                        <?=$username_error?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="login-password" id="text-main">Password</label>
                                <input type="password" class="form-control 
                                <?php if(isset($password_error)): ?>
                                    is-invalid
                                <?php endif; ?>" id="login-password" placeholder="Password" name="password" required>
                                <?php if(isset($password_error)): ?>
                                    <div class="invalid-feedback">
                                        <?=$password_error?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-danger invisible" role="alert" id="login_alert">
                                <?php if (isset($login) && isset($alert_error)): ?>
                                    <?=$alert_error?>
                                <?php endif; ?>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-block">Log in</button>
                                </div>
                                <div class="col-1"></div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="tab-pane fade 
                    <?php if (isset($signup)): ?>
                        show active
                    <?php endif; ?>" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                        <form method="post" action="index.php">
                            <input type="hidden" id="action" value="signup" name="action">
                            <div class="form-group">
                                <label for="firstName" id="text-main">First name</label>
                                <input type="text" class="form-control 
                                <?php if(isset($name_error)): ?>
                                    is-invalid
                                <?php endif; ?>" id="firstName" placeholder="John" name="name" 
                                value="<?=$previous_data['name']?>" required>
                                <?php if(isset($name_error)): ?>
                                    <div class="invalid-feedback">
                                        <?=$name_error?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="lastName" id="text-main">Last name</label>
                                <input type="text" class="form-control
                                <?php if(isset($surname_error)): ?>
                                    is-invalid
                                <?php endif; ?>" id="lastName" placeholder="Doe" name="surname" 
                                value="<?=$previous_data['surname']?>" required>
                                <?php if(isset($surname_error)): ?>
                                    <div class="invalid-feedback">
                                        <?=$surname_error?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="email" id="text-main">Email</label>
                                <input type="email" class="form-control
                                <?php if(isset($email_error)): ?>
                                    is-invalid
                                <?php endif; ?>" id="email" placeholder="john.doe@mail.com" name="email" 
                                value="<?=$previous_data['email']?>" required>
                                <?php if(isset($email_error)): ?>
                                    <div class="invalid-feedback">
                                        <?=$email_error?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="singup-username" id="text-main">Username</label>
                                <input type="text" class="form-control
                                <?php if(isset($username_error)): ?>
                                    is-invalid
                                <?php endif; ?>" id="singup-username" placeholder="Username" name="username" value="<?=$previous_data['username']?>" required>
                                <?php if(isset($username_error)): ?>
                                    <div class="invalid-feedback">
                                        <?=$username_error?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="singup-password" id="text-main">Password</label>
                                <input type="password" class="form-control
                                <?php if(isset($password_error)): ?>
                                    is-invalid
                                <?php endif; ?>" id="singup-password" placeholder="Password" name="password" required>
                                <?php if(isset($password_error)): ?>
                                    <div class="invalid-feedback">
                                        <?=$password_error?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-danger invisible" role="alert" id="signup_alert">
                                <?php if (isset($signup) && isset($alert_error)): ?>
                                    <?=$alert_error?>
                                <?php endif ?>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
</main>
<div class="modal" tabindex="-1" role="dialog" id="error_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Error occured</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <?php if (isset($modal_error)): ?>
                        <?=$modal_error?>
                    <?php endif ?>
                </p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(window).on("load", function () {
        <?php if (isset($modal_error)): ?>
        $("#error_modal").modal("show");
        <?php endif ?>
        <?php if (isset($login) && isset($alert_error)): ?>
        $("#login_alert").removeClass("invisible");
        <?php endif ?>
        <?php if (isset($signup) && isset($alert_error)): ?>
        $("#signup_alert").removeClass("invisible");
        <?php endif; ?>
    });

    $('#signup-tab').on('click', function (e) {
        $(this).removeClass('bg-light-light');
        $('#login-tab').addClass('bg-light-light');
    });

    $('#login-tab').on('click', function (e) {
        $(this).removeClass('bg-light-light');
        $('#signup-tab').addClass('bg-light-light');
    });
</script>

</body>
</html>
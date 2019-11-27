<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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

<br>
<div class="container" id="main">
    <div class="row justify-content-center">
        <div class="col"></div>
        <div class="col-10">
            <ul class="nav nav-tabs nav-fill justify-content-center">
                <li class="nav-item">
                    <a class="nav-link <?php if ($login['active']) {
                        echo "active";
                    } ?>" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login"
                       aria-selected="false">Log In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($signup['active']) {
                        echo "active";
                    } ?>" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup"
                       aria-selected="true">Sign Up</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade <?php if ($login['active']) {
                    echo "show active";
                } ?>" id="login" role="tabpanel" aria-labelledby="login-tab">
                    <form method="post" action="index.php">
                        <input type="hidden" id="action" value="login" name="action">
                        <div class="form-group">
                            <label for="username" id="text-main">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="password" id="text-main">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password"
                                   name="password" required>
                        </div>
                        <div class="alert alert-danger invisible" role="alert" id="login_alert">
                            <?php if ($login['active'] && $login['error']): ?>
                                <?= $login["message"] ?>
                            <?php endif ?>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Log in</button>
                    </form>
                </div>
                <div class="tab-pane fade <?php if ($signup['active']) {
                    echo "show active";
                } ?>" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                    <form method="post" action="index.php">
                        <input type="hidden" id="action" value="signup" name="action">
                        <div class="form-group">
                            <label for="firstName" id="text-main">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="John" name="name"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="lastName" id="text-main">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Doe" name="surname"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="email" id="text-main">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="john.doe@mail.com"
                                   name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="username" id="text-main">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="password" id="text-main">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password"
                                   name="password" required>
                        </div>
                        <div class="alert alert-danger invisible" role="alert" id="signup_alert">
                            <?php if ($signup['active'] && $signup['error']): ?>
                                <?= $signup["message"] ?>
                            <?php endif ?>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="error_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error occured</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <?php if ($modal["active"]): ?>
                        <?= $modal["message"] ?>
                    <?php endif ?>
                </p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<script type="text/javascript">
    $(window).on("load", function () {
        <?php if ($modal["active"]): ?>
        $("#error_modal").modal("show");
        <?php endif ?>
        <?php if ($login['active'] && $login['error']): ?>
        $("#login_alert").removeClass("invisible");
        <?php endif ?>
        <?php if ($signup['active'] && $signup['error']): ?>
        $("#signup_alert").removeClass("invisible");
        <?php endif ?>
    });
</script>

</body>
</html>
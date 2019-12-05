<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Studnet Search · Disastercloud</title>
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
    <div class="container bg-white py-4">
        <div class="row justify-content-center py-3">
            <div class='col-1'></div>
            <div class='col'>
                <h2>Search</h2>
            </div>
            <div class='col-1'></div>
        </div>
        <div class="row justify-content-center">
            <div class='col-1'></div>
            <div class='col'>
                <form action="SearchStudent.php" method="get">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" name="name" id="firstName"
                            <?php if (isset($previous_form["name"])): ?>
                                value="<?=$previous_form["name"]?>"
                            <?php endif ?>>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" name="surname" id="lastName"
                            <?php if (isset($previous_form["surname"])): ?>
                                value="<?=$previous_form["surname"]?>"
                            <?php endif ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="fatherName">Father's Name</label>
                            <input type="text" class="form-control" name="fathername" id="fatherName"
                            <?php if (isset($previous_form["fathername"])): ?>
                                value="<?=$previous_form["fathername"]?>"
                            <?php endif ?>>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <input type="number" step="0.01" max="10.0" min="0.0" class="form-control" name="grade" id="grade"
                            <?php if (isset($previous_form["grade"])): ?>
                                value="<?=$previous_form["grade"]?>"
                            <?php endif ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="mobileNumber">Mobile number</label>
                            <input type="text" class="form-control" name="mobilenumber" id="mobileNumber"
                            <?php if (isset($previous_form["mobilenumber"])): ?>
                                value="<?=$previous_form["mobilenumber"]?>"
                            <?php endif ?>>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="dateOfBirth">Date of birth</label>
                            <input type="date" class="form-control" name="birthday" id="dateOfBirth"
                            <?php if (isset($previous_form["birthday"])): ?>
                                value="<?=$previous_form["birthday"]?>"
                            <?php endif ?>>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end mr-0">
                    <button class="btn btn-secondary mx-1" type="reset" id="reset-btn">Clear</button>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
                </form>
            </div>
            <div class='col-1'></div>
        </div>
        <hr>
    </div>
    <?php if(isset($students)): ?>
        <div class="container bg-white px-5">
            <div class="row justify-content-between">
                <div class="col">
                    <table id="example" class="table table-striped table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Father's Name</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Mobile Number</th>
                            <th scope="col">Birthday</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($students as $s): ?>
                            <tr class="table-row" data-path="/EditStudent.php?id=<?=$s["id"]?>">
                                <td><?=$s["name"]?></td>
                                <td><?=$s["surname"]?></td>
                                <td><?=$s["fathername"]?></td>
                                <td><?=$s["grade"]?></td>
                                <td><?=$s["mobilenumber"]?></td>
                                <td><?=$s["birthday"]?></td>
                                <td>
                                    <a class="btn btn-primary" href="/EditStudent.php?id=<?=$s["id"]?>" role="buttons"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger delete-student" data-toggle="modal" data-target="#confirm-delete" data-id="<?=$s["id"]?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a id="back-to-top" href="#" class="btn btn-dark btn-lg back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirm-delete-label">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete selected Student?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="/DeleteStudent.php" method="post">
                    <input id="confirm-delete-id" type="hidden" name="id" value="">
                    <button type="submit" class="btn btn-danger">Delete</button>    
                </form>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.delete-student').on('click', function(event) {
                    $('#confirm-delete-id').val($(this).data("id"))
                });

                $('#reset-btn').on('click', function(e) {
                    window.location.assign('SearchStudent.php');
                });

                $(window).scroll(function () {
                    if ($(this).scrollTop() > 50) {
                        $('#back-to-top').fadeIn();
                    } else {
                        $('#back-to-top').fadeOut();
                    }
                });

                // scroll body to 0px on click
                $('#back-to-top').click(function () {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 400);
                    return false;
                });
            });
        </script>
    <?php endif; ?>
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
        $(document).ready(function(){
            <?php if (isset($modal_error)): ?>
            $("#error_modal").modal("show");
            <?php endif ?>
        });
    </script>
</main>
</body>
</html>
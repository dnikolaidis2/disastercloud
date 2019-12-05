<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student Manager · Disastercloud</title>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/custom.css">
    <script src="assets/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/stylesheet.css"> 
</head>
<body class="bg-light">
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
<main>
    <div class="container bg-white">
        <div class="row justify-content-between px-5 py-4">
            <div class="col">
                <h2>Student's</h2>
            </div>
            <div class="col-0 mx-3">
                <a class="btn btn-primary" href="/SearchStudent.php" role="buttons"><i class="fas fa-search"></i></a>
                <a class="btn btn-primary" href="/AddStudent.php" role="buttons"><i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="row justify-content-between px-5">
            <div class="col">
                <?php if(isset($students)): ?>
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
                <?php endif;?>
            </div>
        </div>
    </div>
</main>
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

        $('.delete-student').on('click', function(event) {
            $('#confirm-delete-id').val($(this).data("id"))
        });

        $(window).scroll(function () {
            if ($(this).scrollTop() > 1) {
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
</body>
</html>
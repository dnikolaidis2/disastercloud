<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/8f7197f193.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

    <style>

        body {
            /*background-color: #bdc3c7;*/
        }

        #main {
            background-color: #2c3e50;
            padding-top: 2%;
            padding-bottom: 2%;
        }

        #text-main {
            color: #bdc3c7;
        }

        .table-row{
            cursor:pointer;
        }

    </style>
</head>
<body>
<!--
  <form method="post" action="index.php">
    <input type="hidden" id="action" value="logout" name="action">
    <button type="submit" class="btn btn-primary btn-block">Logout</button>
  </form> -->

<div class="container">
    <table id="example" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Father's Name</th>
            <th scope="col">Grade</th>
            <th scope="col">Mobile Number</th>
            <th scope="col">Birthday</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach ($students as $s): ?>
            <tr class="table-row" data-path="/EditStudent.php?id=<?=$s["id"]?>">
                <td><?=$s["name"]?></td>
                <td><?=$s["surname"]?></td>
                <td><?=$s["fathername"]?></td>
                <td><?=$s["grade"]?></td>
                <td><?=$s["mobilenumber"]?></td>
                <td><?=$s["birthday"]?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
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
<script>
    $(document).ready(function($) {
        $(".table-row").click(function() {
            window.location.assign($(this).data("path"));
        });
    });
</script>
</body>
</html>
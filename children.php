<?php

require_once("config.php");

if (isset($_POST['submit'])) {
  $NAME = ucwords($_POST['name']);
  $CHILDID = $_POST['id'];
  $Date = $_POST['bdate'];
  $DATE = date("Y-m-d", strtotime($Date));
  $NATIONALITY = ucwords($_POST['nationality']);
  $GENDER = ucwords($_POST['gender']);
  $NEEDS = $_POST['needs'];

  $query = "INSERT INTO children VALUES('$CHILDID','$NAME','$DATE','$GENDER','$NATIONALITY','$NEEDS')";

  $result = mysqli_query($config, $query);

  if ($result) {
    $message = "Child Record Successfully added to the database";
  } else {
    $message = "Child's Record was not successfully added to the database";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Sunshine Shelter | Children</title>
  <style>
    body {
      font-family: "Poppins";
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .invalid-feedback {
      display: none;
    }

    .was-validated .form-control:invalid,
    .was-validated .form-select:invalid {
      border-color: #dc3545;
    }

    .was-validated .form-control:invalid~.invalid-feedback,
    .was-validated .form-select:invalid~.invalid-feedback {
      display: block;
    }

    .alert {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body class="d-flex justify-content-center flex-column">
  <?php if (isset($message)): ?>
    <div class="alert alert-info alert-dismissible fade show m-2 w-50 text-center" role="alert">
      <?php echo $message ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <form action="" method="post" class="w-50 m-3  p-3 text-bg-dark shadow-lg needs-validation container" novalidate>
    <h1 class="text-center fw-bold">Children Registration</h1>
    <h2 class="text-center fw-light fs-3">Sunshine Shelter Orphange</h2>

    <div class="px-4 position-relative">
      <label for="name" class="form-label">Name</label>
      <input type="text" name="name" id="name" class="form-control " required />
      <div class="valid-tooltip">
        Looks good!
      </div>
    </div>
    <div class="row m-2">
      <div class="col position-relative">
        <label for="id" class="form-label">ChildID</label>
        <input type="text" name="id" id="id" maxlength="6" class="form-control" required />
        <div class="invalid-tooltip">
          Enter a valid id.
        </div>
      </div>
      <div class="col position-relative">
        <label for="bdate" class="form-label">Date Of Birth</label>
        <input type="date" id="bdate" name="bdate" class="form-control" required />
        <div class="invalid-tooltip">
          Enter a valid date
        </div>
      </div>
    </div>

    <div class="row m-2">
      <div class="col position-relative">
        <label for="nation" class="form-label">Nationality</label>
        <input type="text" name="nationality" id="nationality" class="form-control" required />
        <div class="invalid-tooltip">
          Enter a valid nationality.
        </div>
      </div>
      <div class="col position-relative">
        <label for="gender" class="form-label">Gender</label>
        <select name="gender" id="gender" class="form-select">
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>
        <div class="invalid-tooltip">
          Choose a gender.
        </div>
      </div>
    </div>
    <div class="px-3">
      <label for="needs" class="form-label">Special Needs</label>
      <textarea name="needs" id="needs" cols="20" rows="10" class="form-control"></textarea>
    </div>
    <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-primary mt-4 d-flex justify-content-center w-25" name="submit">Submit</button>
    </div>

  </form>
</body>
<script>
  (function() {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
      .forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>

</html>
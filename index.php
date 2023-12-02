<?php require __DIR__ . '/init.php'; ?>
<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload External Files</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">  
  </head>
  <body style="background: #efffee;">
    <div class="container">
      <div class="row">
        <section>
          <p>&nbsp;</p>
        </section>
      </div>
      <div class="row">
        <?php
        if (isset($_POST['uploadnow'])) {
          // upload loan sheet
          $res = $upl->uploadLoan();
          // upload transaction sheet
          // $res = $upl->uploadTransaction();
          // response
          if ( $res === "success" ) {
            $success = $res;
            echo "<script>setTimeout(function() { window.location.reload(true); }, 1000);</script>";
          } else {
            $error = $res;
          }
        }
        ?>
        <div class="col-lg-8 col-md-8 col-sm-12">
          <div class="card">
            <div class="card-header">
              Make your upload here
            </div>
            <div class="card-body">
              <?php if ( !empty($success) ): ?>
                <div class="alert alert-info"><?=$success?></div>
              <?php endif; ?>
              <?php if ( !empty($error) ): ?>
                <div class="alert alert-danger"><?=$error?></div>
              <?php endif; ?>
              <form class="form_upload" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                  <!-- <label for="docfile" class="col-md-3">Choose File to Upload<span class="text-danger">* </span></label> -->
                  <div class="col-md-9">
                    <input class="form-control" type="file" name="docfile" required>
                  </div>
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-primary" name="uploadnow">Upload Now</button>
                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
  </body>
</html>

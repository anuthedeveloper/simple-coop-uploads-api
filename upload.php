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

          $allowedFileType = [
              'application/vnd.ms-excel',
              'text/xls',
              'text/xlsx',
              'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
          ];

          if (in_array($_FILES["docfile"]["type"], $allowedFileType)) {
            $file  = isset($_FILES['docfile']) ? $_FILES['docfile']['tmp_name'] : '';
             //$targetPath = 'uploads/' . $_FILES['docfile']['name'];
             //move_uploaded_file($_FILES['docfile']['tmp_name'], $targetPath);
            // file open and read
            /** Load $inputFileName to a Spreadsheet Object  **/
            $spreadSheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

            //$spreadSheet = $Reader->load($file);
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();
            $sheetCount = count($spreadSheetAry);

            for ($i = 0; $i <= $sheetCount; $i ++) {

              $regno = "";
              if (isset($spreadSheetAry[$i][0])) {
                $regno = $spreadSheetAry[$i][0];
              }
              $membername = "";
              if (isset($spreadSheetAry[$i][1])) {
                $membername = $spreadSheetAry[$i][1];
              }
              $deductions = "";
              if (isset($spreadSheetAry[$i][2])) {
                $deductions = $spreadSheetAry[$i][2];
              }
              $savings = "";
              if (isset($spreadSheetAry[$i][3])) {
                $savings = $spreadSheetAry[$i][3];
              }
              $loanrepay = "";
              if (isset($spreadSheetAry[$i][4])) {
                $loanrepay = $spreadSheetAry[$i][4];
              }
              $loaninterest = "";
              if (isset($spreadSheetAry[$i][5])) {
                $loaninterest = $spreadSheetAry[$i][5];
              }
              $devlevy = "";
              if (isset($spreadSheetAry[$i][6])) {
                $devlevy = $spreadSheetAry[$i][6];
              }
              $transactiondate = "";
              if (isset($spreadSheetAry[$i][7])) {
                  $transactiondate = $spreadSheetAry[$i][7];
              }
              if ( $regno !== '' ) {
                //create query
                $query = "INSERT INTO temptable2 (RegNo, MemberName, Deductions, Savings, LoanRepayment, LoanInterest, Devlevy, TransactionDate) VALUES (?, ?, ?)";
                $params = array($regno, $membername, $deductions, $savings, $loanrepay, $loaninterest, $devlevy, $transactiondate);
                $response = sqlsrv_query($conn, $query, $params);
              }
            }
            sqlsrv_close($conn);
            if($response){
              $success = "Your file has been uploaded successfully";
              echo "<script>
    					setTimeout(function() {
    							window.location = 'http://wemaibadancoop.com.ng/Configuration.aspx';
    					}, 1000);
    					</script>";
            }else{
              $error = "Sorry! There is a problem uploading your file";
            }

          }else{
            $error = "Sorry! This file you're trying to upload is not a valid excel file";
          }
        }
        ?>
        <div class="col-lg-8 col-md-8 col-sm-12">
          <div class="card">
            <div class="card-header">
              Make your upload here
            </div>
            <div class="card-body">
              <?php if (!empty($success)): ?>
                <div class="alert alert-info">
                  <?=$success?>
                </div>
              <?php endif; ?>
              <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                  <?=$error?>
                </div>
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
                <!-- <div class="form-group mt-2">
                  <label for="description" class="col-md-3">Description (Optional)</label>
                  <div class="col-md-9">
                    <textarea class="form-control" name="description" ></textarea>
                  </div>
                </div> -->
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

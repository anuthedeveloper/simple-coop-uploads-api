<?php
use \PhpOffice\PhpSpreadsheet\IOFactory;

class UploadController
{

    public function __construct() {
        // 
    }

    public function loadFile($file)
    {
        $spreadSheet = IOFactory::load($file);

        //$spreadSheet = $Reader->load($file);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
   
        return $spreadSheetAry;
    }

    public function uploadLoan()
    {
        $allowedFileType = [
            'application/vnd.ms-excel',
            'text/xls',
            'text/xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        try {
            if ( !in_array($_FILES["docfile"]["type"], $allowedFileType) ) {
                throw new Exception("Invalid Request! File not supported", 1);
            }

            $file  = isset($_FILES['docfile']) ? $_FILES['docfile']['tmp_name'] : '';
    
            $spreadSheetAry = $this-loadFile($file);
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
                    // create query
                    $query = "INSERT INTO temptable2 (RegNo, MemberName, Deductions, Savings, LoanRepayment, LoanInterest, Devlevy, TransactionDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $params = array(
                        $regno, $membername, $deductions, $savings, $loanrepay, $loaninterest, $devlevy, $transactiondate
                    );

                    $done = sqlsrv_query($conn, $query, $params);
                }
            }

            sqlsrv_close($conn);

            if( !$done ){
                throw new Exception("Process aborted! This may be due to some invalid fields, please check and try again", 1);
            }

            $response = "success";
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        }

        return $response;
    }

    public function uploadTransaction()
    {
        global $db;

        $allowedFileType = [
            'application/vnd.ms-excel',
            'text/xls',
            'text/xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        try {
            if ( !in_array($_FILES["docfile"]["type"], $allowedFileType) ) {
                throw new Exception("Invalid Request! File not supported", 1);
            }

            $file  = isset($_FILES['docfile']) ? $_FILES['docfile']['tmp_name'] : '';
    
            $spreadSheetAry = $this-loadFile($file);
            $sheetCount = count($spreadSheetAry);
    
            for ($i = 0; $i <= $sheetCount; $i ++) {

                $regno = "";
                if (isset($spreadSheetAry[$i][0])) {
                    $regno = $spreadSheetAry[$i][0];
                }
                $savings = "";
                if (isset($spreadSheetAry[$i][1])) {
                    $savings = $spreadSheetAry[$i][1];
                }
                $transactiondate = "";
                if (isset($spreadSheetAry[$i][2])) {
                    $transactiondate = $spreadSheetAry[$i][2];
                }

                if ( $regno !== '' ) {
                    $sql = "INSERT INTO temptable1 (regno, savings, transaction_date) VALUES (?, ?, ?)";
                    $stmt = $db->prepare($sql);
                    $done = $stmt->execute([$regno, $savings, $transactiondate]);
                }
            }

            if( !$done ){
                throw new Exception("Process aborted! This may be due to some invalid fields, please check and try again", 1);
            }

            $response = "success";
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        }

        return $response;
    }
}

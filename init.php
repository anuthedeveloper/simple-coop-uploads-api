<?php
require_once ('./vendor/autoload.php');

/**
 * SQLSERVER 
 */
try {
  $serverName = ".\MSSQLSERVER2014"; //serverName\instanceName
  $connectionInfo = array("Database"=> "", "UID" => "", "PWD" => "");
  $conn = sqlsrv_connect( $serverName, $connectionInfo );
  if( !$conn ) {
    throw new Exception("Connection could not be established.<br />".sqlsrv_errors(), 1);
    die( print_r( sqlsrv_errors(), true));
  }
} catch ( Exception $e ) {
  print $e->getMesaage();
}

/**
 * MYSQL PDO
 */
// try {
//   $db = new PDO('mysql:host=localhost;dbname=test', $user = "root", $pwd = "");
// } catch (PDOException $e) {
//   print "Error!: " . $e->getMessage() . "<br/>";
// }


require __DIR__ . '/classes/uploadController.php';

$upl = new UploadController();

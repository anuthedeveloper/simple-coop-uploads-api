<?php
require_once ('./vendor/autoload.php');
/**
 *
 */
try {
  $serverName = ".\MSSQLSERVER2014"; //serverName\instanceName
  $connectionInfo = array( "Database"=>"wemaiba1_coop", "UID"=>"", "PWD"=>"");
  $conn = sqlsrv_connect( $serverName, $connectionInfo );
  if( !$conn ) {
    throw new Exception("Connection could not be established.<br />".sqlsrv_errors(), 1);
    die( print_r( sqlsrv_errors(), true));
  }
} catch ( Exception $e) {
  print $e->getMesaage();
}

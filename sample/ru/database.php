<?php
$HOME = getenv("HOME");
$WWWROOT = $_SERVER["DOCUMENT_ROOT"];
$DB_DSN = "sqlite:$HOME/sample.sqlite3";
$DB_USER = null;
$DB_PASS = null;
$ADMIN_LOGIN = "admin";
$ADMIN_PASSWORD = "admin";
@include "config.php";
$DB_VERSION = 6;
$CT_TEXT = "Content-Type: text/plain;charset=UTF-8";
$CT_XML = "Content-Type: application/xml;charset=UTF-8";
ini_set("display_errors", 0);
error_reporting(E_ALL);
//Source: https://www.php.net/manual/en/class.errorexception.php#errorexception.examples
function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");
try
{
	session_start();
	$account_id = (int) @$_SESSION["account_id"];
	$role_id = (int) @$_SESSION["role_id"];
	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASS,
	[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);
	$DB_PASS = "";
	try
	{
		$sample_version = $dbh->query("select sample_version from db_sample")->fetchColumn();
	}
	catch(Exception $ex)
	{
		include __dir__ . "/install.php";
	}
	if($sample_version < $DB_VERSION)
	{
		include __dir__ . "/install.php";
	}
	$ADMIN_PASSWORD = "";
}
catch(Exception $ex)
{
	http_response_code(500);
	header($CT_TEXT);
	exit($ex->getMessage());
}

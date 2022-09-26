<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
require('functions.inc.php');

$output = array(
	"error" => false,
  "string" => "",
	"answer" => 0
);

$input_text = $_REQUEST['input_text'];


$answer=getMaxMin($input_text);

$output['string']=$input_text."=".$answer;
$output['answer']=$answer;

echo json_encode($output);
exit();

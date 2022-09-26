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

$result=getSortedModules($input_text);
foreach ($result as $module_marks) {
		$answer = $answer . $module_marks['module'] . ',' . $module_marks['marks'] . 'newline';

}

$output['string']=$input_text."=".$answer;
$output['answer']=$answer;

echo json_encode($output);
exit();

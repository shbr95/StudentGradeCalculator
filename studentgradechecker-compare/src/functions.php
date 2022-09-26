<?php

function getAverage($input_text) {
    $lines = explode("newline", $input_text);
    $module_marks=array();
    foreach ($lines as $line) {
       $line_array = explode(",", $line);
       $module_marks_array = array("module"=>$line_array[0], "marks"=>$line_array[1]);
       array_push($module_marks,$module_marks_array);
    }

  
    $total = 0;

    foreach($module_marks as $key => $module_mark) {
        $total = $total + intval($module_mark['marks']); // add up the total

        $average = $total / count($module_marks);
        
       
    }
    $average = round($average);
    $currentUserAvgGrade = $average;
    return $currentUserAvgGrade;
}

function compare() {
    include 'db.php';
    $input_text = $_GET['input_text'];
    $currentUserAvgGrade = getAverage($input_text);
    $result = $mysqli -> query("SELECT AVG(averageGrade) AS average FROM results");
    if (mysqli_num_rows($result) > 0 ) { 
        $row = mysqli_fetch_assoc($result); 
        $dbAvgGrade = $row['average'];
        $dbAvgGrade = round($dbAvgGrade,0);
        $output['dbAvgGrade']=$dbAvgGrade;
    } else {
        $output['dbAvgGrade']=0;
    }
    $result = $mysqli -> query("SELECT * FROM `results`"); 
    if (mysqli_num_rows($result) > 0 ) {
        $numRows = mysqli_num_rows ($result);
    } else {
        $output['numRows']=0;
    }
    $output['currentUserAvg']=$currentUserAvgGrade;
    $output['dbAvgGrade']=$dbAvgGrade;
    $output['numRows']=$numRows;
    echo json_encode($output);
}

?>
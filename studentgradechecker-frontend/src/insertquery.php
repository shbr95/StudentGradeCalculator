<?php
include 'db.php';
echo $_SESSION["userId"];

if(!isset($_SESSION['userId'])) {
    $input_text = $_GET['input_text'];
    echo $input_text;
    $lines = explode("newline", $input_text);
        $module_marks=array();
        foreach ($lines as $line) {
        $line_array = explode(",", $line);
        $module_marks_array = array("module"=>$line_array[0], "marks"=>$line_array[1]);
        array_push($module_marks,$module_marks_array);
        }
        echo "<br>";
        print_r($module_marks);
        $total = 0;
        foreach($module_marks as $key => $module_mark) {
            $total += intval($module_mark['marks']); // add up the total
            $average = $total / count($module_marks);
        }
        $average = round($average,0);
        echo $average;
        if ($average!= 0) {
            $userid = null;
            $stmt = $mysqli->prepare("INSERT INTO `results` (`user_id`, `averageGrade`) VALUES (?, ?)");
            $stmt->bind_param("ss", $userid, $average);
            $stmt->execute();
            $_SESSION["userId"] = $mysqli->insert_id;
            echo $_SESSION["userId"];
        }
}
    


?>
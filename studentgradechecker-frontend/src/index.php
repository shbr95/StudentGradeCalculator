<?php
include 'db.php';
if(!isset($_SESSION['userId'])) {
   // $result = $mysqli -> query("SELECT * FROM `results`");
  //  $num_rows = mysqli_num_rows($result);
   // $_SESSION["userId"] = $num_rows + 1;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>StudentGradeChecker</title>
    <script type="text/javascript">
        let input_text = '';
        let total_marks = '';
        let max_module = '';
        let min_module = '';
        let sorted_modules = '';
        let proxyURL = "http://studentgradechecker-proxy.40322903.qpc.hal.davecutting.uk";

        function displayTotal() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = 'Total marks = ' + total_marks;

        }

        function displayMaxMin() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = 'Highest scoring module = ' + max_module +
                '\nLowest scoring module = ' + min_module;

        }

        function displaySortedModules() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = sorted_modules;

        }


        function displayTotal() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = total + ' total marks';

        }

        function displayClassification() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = classification;

        }

        function displayMedian() {
            document.getElementById('output-text').value = '';
            if (oddEven == "odd") {
                document.getElementById('output-text').value = "As you completed an odd number of modules the median of your module grades is "+moduleName1+": "+answer+"."
            } else {
                document.getElementById('output-text').value = "As you completed an even number of modules the median of your module grades is the value between your grade for "+moduleName1+" and "+moduleName2+". The median value is "+answer+"." 
            }
            

        }

        function displayComparison() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = "Your average grade is "+currentUserAvg+". The average grade of other users is "+dbAvgGrade+" (from " + numRows +" entries).";

        }

        function displayError() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = "Error";

        }

        function displayServerError() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = "Server error, please try again later";

        }

        function displayCalculating() {
            document.getElementById('output-text').value = '';
            document.getElementById('output-text').value = "Calculating result...";

        }



        function clearText() {
            document.getElementById('input-text').value = '';
            document.getElementById('output-text').value = '';

        }


        function insertQuery(input_text) {
            
            if (input_text == '') {

                return;
            } else {
                input_text_edited = ''
                lines = input_text.match(/[^\r\n]+/g);
                for (let i = 0; i < lines.length; i++) {
                    if (i != (lines.length - 1)) {
                        input_text_edited += lines[i] + "newline";
                    } else {
                        input_text_edited += lines[i];
                    }
                }

                var xhttp;
                if (input_text == "") {
                    document.getElementById("input-text").innerHTML = "";
                    return;
                }
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("input-text").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "insertquery.php?input_text=" + input_text_edited, true);
                xhttp.send();
                return;
            }
        }





        function getMaxMin() {
            input_text = document.getElementById('input-text').value
            if (input_text == '')
                return;
            else {
                input_text_edited = ''
                lines = input_text.match(/[^\r\n]+/g);
                for (let i = 0; i < lines.length; i++) {
                    if (i != (lines.length - 1)) {
                        input_text_edited += lines[i] + "newline";
                    } else {
                        input_text_edited += lines[i];
                    }
                }

                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var j = JSON.parse(this.response);
                        max_min_returned = j.answer;
                        max_min_returned_array = max_min_returned.split('newline');
                        max_module = max_min_returned_array[0];
                        min_module = max_min_returned_array[1];
                        displayMaxMin();
                    }
                };

                xhttp.open("GET", proxyURL + "?input_text=" + input_text_edited + "&func=maxmin");
                xhttp.send();

                insertQuery(input_text)

                return;
            }


        }

        function getSortedModules() {
            input_text = document.getElementById('input-text').value
            if (input_text == '') {
                displayError();
                return;
            } else {
                input_text_edited = ''
                lines = input_text.match(/[^\r\n]+/g);
                for (let i = 0; i < lines.length; i++) {
                    if (i != (lines.length - 1)) {
                        input_text_edited += lines[i] + "newline";
                    } else {
                        input_text_edited += lines[i];
                    }
                }

                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var j = JSON.parse(this.response);
                                errorResponse = j.error;
                                sorted_modules_returned = j.answer;
                                sorted_modules_array = sorted_modules_returned.split('newline');
                                sorted_modules = '';
                                for (let i = 0; i < sorted_modules_array.length; i++) {
                                    sorted_modules += sorted_modules_array[i] + '\r\n';
                            }
                            if (errorResponse == false) {
                                displaySortedModules();
                            } else {
                                displayError();
                            }
                        } else {
                        displayCalculating()
                    }
                };

                xhttp.open("GET", proxyURL + "?input_text=" + input_text_edited + "&func=sort");
                xhttp.send();

                insertQuery(input_text)

                return;
            }

        }




        function getTotal() {
            input_text = document.getElementById('input-text').value
            if (input_text == '') {
                displayError();
                return;
            } else {
                input_text_edited = ''
                lines = input_text.match(/[^\r\n]+/g);
                for (let i = 0; i < lines.length; i++) {
                    if (i != (lines.length - 1)) {
                        input_text_edited += lines[i] + "newline";
                    } else {
                        input_text_edited += lines[i];
                    }
                }

                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var j = JSON.parse(this.response);
                        total = j.answer;
                        errorResponse = j.error;
                        console.log(errorResponse);
                        console.log(proxyURL + "?input_text=" + input_text_edited + "&func=total");
                        if (errorResponse == false) {
                            displayTotal();
                        } else {
                            displayError();
                        }
                    }  else {
                        displayCalculating()
                    }

                }
                xhttp.open("GET", proxyURL + "?input_text=" + input_text_edited + "&func=total");
                setTimeout(() => xhttp.send(), 500);
                insertQuery(input_text)
                return;

            }
        }



        function getClassification() {
            input_text = document.getElementById('input-text').value
            if (input_text == '')
                return;
            else {
                input_text_edited = ''
                lines = input_text.match(/[^\r\n]+/g);
                for (let i = 0; i < lines.length; i++) {
                    if (i != (lines.length - 1)) {
                        input_text_edited += lines[i] + "newline";
                    } else {
                        input_text_edited += lines[i];
                    }
                }

                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var j = JSON.parse(this.response);
                        classification = j.answer;
                        displayClassification();

                    }
                };

                xhttp.open("GET", proxyURL + "?input_text=" + input_text_edited + "&func=classification", false);
                xhttp.send();

                insertQuery(input_text)

                return;
            }
        }



        function getMedian() {
            input_text = document.getElementById('input-text').value
            if (input_text == '')
                return;
            else {
                input_text_edited = ''
                lines = input_text.match(/[^\r\n]+/g);
                for (let i = 0; i < lines.length; i++) {
                    if (i != (lines.length - 1)) {
                        input_text_edited += lines[i] + "newline";
                    } else {
                        input_text_edited += lines[i];
                    }
                }

                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var j = JSON.parse(this.response);
                        moduleName1 = j.moduleName1
                        moduleName2 = j.moduleName2
                        oddEven = j.oddEven
                        answer = j.answer
                        displayMedian();

                    }
                };

                xhttp.open("GET", proxyURL + "?input_text=" + input_text_edited + "&func=median", false);
                xhttp.send();

                insertQuery(input_text)

                return;
            }
        }


    



        function compareUsers() {
            input_text = document.getElementById('input-text').value
            if (input_text == '')
                return;
            else {
                input_text_edited = ''
                lines = input_text.match(/[^\r\n]+/g);
                for (let i = 0; i < lines.length; i++) {
                    if (i != (lines.length - 1)) {
                        input_text_edited += lines[i] + "newline";
                    } else {
                        input_text_edited += lines[i];
                    }
                }

                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var j = JSON.parse(this.response);
                        currentUserAvg = j.currentUserAvg;
                        dbAvgGrade = j.dbAvgGrade;
                        numRows = j.numRows
                        displayComparison();

                    }
                };

                xhttp.open("GET", proxyURL + "?input_text=" + input_text_edited + "&func=compare");
                xhttp.send();

                insertQuery(input_text)

                return;
            }
        }


    </script>

    <style type="text/css">
        body {
            font-size: 150%;
            font-family: monospace;
        }

        #logo {
            font-family: Calibri, sans-serif;
            font-weight: lighter;
            color: #505050;
            margin: 0.5em;
        }

        #sgc {
            text-align: center;
            margin-top: 1em;
        }

        .display-input {
            font-size: 90%;
            color: black;
            background-color: white;
            padding: 0.2em;
            margin: 0.2em;
            font-family: monospace;
            letter-spacing: 0.1em;
            width: 600px;

        }

        .display-output {
            font-size: 90%;
            color: white;
            background-color: black;
            padding: 0.2em;
            margin: 0.2em;
            font-family: monospace;
            letter-spacing: 0.1em;
            width: 600px;

        }

        .sgcbutton-active {
            background-color: green;
            color: white;
            padding: 0px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            margin: 4px 2px;
            cursor: pointer;
            height: 40px;
            width: 400px;
        }

        .sgcbutton-inactive {
            background-color: gray;
            color: white;
            padding: 0px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            margin: 4px 2px;
            cursor: pointer;
            height: 40px;
            width: 400px;
        }

        .sgcbutton-clear {
            background-color: red;
            color: white;
            padding: 0px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            margin: 4px 2px;
            cursor: pointer;
            height: 40px;
            width: 400px;
        }
    </style>

</head>

<body>
    <div id="sgc">
        <div id="logo">
            Student Grade Checker App
        </div>
        <div>
            <textarea class="display-input" id="input-text" rows="5" cols="35" placeholder="Enter the module names and marks separated by comma [put each module in a new line]" value=""></textarea>
        </div>
        <div>
            <textarea class="display-output" id="output-text" rows="5" cols="35" readonly=1 placeholder="Results here..." value=""></textarea>
        </div>
        <div>
            <button class="sgcbutton-active" onclick="getTotal();">Total Marks</button>
        </div>
        <div>
            <button class="sgcbutton-active" onclick="getMaxMin();">Highest & Lowest Scoring Modules</button>
        </div>
        <div>
            <button class="sgcbutton-active" onclick="getSortedModules();">Sort Modules</button>
        </div>
        <div>
            <button class="sgcbutton-active" onclick="getClassification();">Classify Grade</button>
        </div>
        <div>
            <button class="sgcbutton-active" onclick="getMedian();">Get median grade</button>
        </div>
        <div>
            <button class="sgcbutton-active" onclick="compareUsers();">Compare to other users</button>
        </div>

        <div>
            <button class="sgcbutton-clear" onclick="clearText();">Clear</button>
        </div>

    </div>
</body>

<script type="text/javascript">
</script>

</html>
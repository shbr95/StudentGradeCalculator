'use strict';
const express = require('express');

const PORT = 80;
const HOST = '0.0.0.0';


const app = express();
var functions = require('./functions');




app.get('/', (req,res) => {

    var output = {
        'error': false,
        'string': '',
        'moduleName1': '',
        'moduleName2': '',
        'oddEven': '',
        'answer': 0
    };

    res.setHeader('Content-Type', 'application/json');
    res.setHeader('Access-Control-Allow-Origin', '*')
    var input_text = req.query.input_text

//Add Error Handiling for undefiend Variables
    if(input_text === undefined){
      output.error = true;
      output.string = "Input text missing";
    }else{
      output.string = input_text;
      var moduleMarks = functions.sortArray(input_text)

      //get odd median
      if(moduleMarks.length%2 != 0){
        var median = functions.getMedianOdd(moduleMarks)
        var moduleName1 = functions.GetModuleName1(moduleMarks)
        output.oddEven = "odd"
      } else {
        var median = functions.getMedianEven(moduleMarks)
        var moduleName1 = functions.GetModuleName1(moduleMarks)
        var moduleName2 = functions.GetModuleName2(moduleMarks)
        output.oddEven = "even"
      }

      

      output.moduleName1 = moduleName1
      output.moduleName2 = moduleName2
      output.answer = median
    
    console.log(moduleName1)
    console.log(moduleName2)
    console.log(median)

	}


    res.end(JSON.stringify(output));
});

app.listen(PORT, HOST);

from flask import Flask 
from flask import request
from flask import Response
from collections import OrderedDict
import totalfunctions
import json


def total(input_text):
    lines = input_text.split("newline")
    moduleMarks = []
    for line in lines:
        lineArray = line.split(",")
        moduleMarksArray={
            "module": lineArray[0],
            "mark": lineArray[1]
        }
        moduleMarks.append(moduleMarksArray)
    total = 0
    for moduleMark in moduleMarks:
        total = total + int(moduleMark["mark"])    
    return total
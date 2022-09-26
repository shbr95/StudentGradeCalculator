from ast import Return
from curses import keyname
from operator import itemgetter
from flask import Flask, request, redirect, make_response, jsonify
import flask
import requests
import time
from random import randrange
import datetime
from datetime import date
import json
from datetime import datetime
from flaskext.mysql import MySQL
import statistics

def moduleMarksReturn(inputText):
    lines = inputText.split("newline")
    moduleMarks = []
    for line in lines:
        lineArray = line.split(",")
        moduleMarksArray = {
            "module": lineArray[0],
            "mark": int(lineArray[1])
        }
        moduleMarks.append(moduleMarksArray)
    return moduleMarks


def maxmin(inputText, moduleMarks=[]):
    moduleMarks = moduleMarksReturn(inputText)
    moduleMarks = sorted(moduleMarks, key=lambda dct: dct['mark'])
    minModule = str(moduleMarks[0]['module']) + \
        ', ' + str(moduleMarks[0]['mark'])
    maxModule = str(moduleMarks[len(moduleMarks)-1]['module']) + \
        ', ' + str(moduleMarks[len(moduleMarks)-1]['mark'])
    maxMinModule = maxModule + 'newline' + minModule
    return maxMinModule

def sort(moduleMarks=[]):
    moduleMarks = moduleMarksReturn(moduleMarks)
    moduleMarks = sorted(moduleMarks, key=lambda dct: dct['mark'], reverse=True)
    answer = ""
    for line in moduleMarks: 
        answer = answer + line["module"] + ","+ str(line["mark"]) + "newline"
    return answer

def total(moduleMarks=[]):
    moduleMarks = moduleMarksReturn(moduleMarks)
    total = 0
    for moduleMark in moduleMarks:
        total = total + int(moduleMark["mark"])
    return total

def classification(moduleMarks=[]):
    
    totalMarks = total(moduleMarks)
    moduleMarks = moduleMarksReturn(moduleMarks)
    average = totalMarks/len(moduleMarks)
    intAverage = int(average)
    classification = ""
    print(intAverage)
    
    if intAverage >= 70:
        classification = "Distinction"
    elif intAverage <= 69 and intAverage >= 60:
        classification = "Merit"
    elif intAverage <= 59 and intAverage >= 50:
        classification = "Pass"
    elif intAverage < 50:
        classification = "Fail"
    
    print(len(moduleMarks))
    print(moduleMarks)
    return classification

def average(moduleMarks=[]):
    totalMarks = total(moduleMarks)
    moduleMarks = moduleMarksReturn(moduleMarks)
    average = totalMarks/len(moduleMarks)
    intAverage = round(average)
    return intAverage


def testFunctions(actual, expected, currentTime, total_time, moduleMark1, moduleMark2, moduleMark3, moduleMark4, moduleMark5, moduleMark6):
    checkResult = actual == expected
    isCorrect = "Correct" if checkResult else "incorrect"
    output_string = currentTime + " For the input values \"" + str(moduleMark1) + ", " + str(moduleMark2) + ", " + str(moduleMark3) + ", " + str(moduleMark4) + ", " + str(moduleMark5) + ", " + str(moduleMark6) + "\" the expected answer was \"" + str(expected) + "\" and the actual answer from the API was \"" + str(actual) + "\". The response was " + isCorrect + " and took " + str(total_time) + " seconds"
    return output_string

def outputTitle(title):
        f = open("results.txt", "a")
        f.write(title + "\n")
        f.close()

def outputResults(outputString):

        f = open("results.txt", "a")
        f.write(outputString + "\n")
        f.close()


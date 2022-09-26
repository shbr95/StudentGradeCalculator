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
import monitoringfunctions
import time
import atexit
from apscheduler.schedulers.background import BackgroundScheduler
import statistics



app = Flask(__name__)


def monitor():
    mysql = MySQL()
    app.config['MYSQL_DATABASE_USER'] = 'root'
    app.config['MYSQL_DATABASE_PASSWORD'] = 'my_secret_password'
    app.config['MYSQL_DATABASE_DB'] = 'studentgradechecker-db'
    app.config['MYSQL_DATABASE_HOST'] = 'db'
    mysql.init_app(app)

    FunctionsUrl = "http://studentgradechecker-proxy.40322903.qpc.hal.davecutting.uk/functionslist"
    output = requests.get(FunctionsUrl)
    output = json.loads(output.text)

    html = ""

    for key in output.keys():
        title = "Tests for  " + str(key)
        html = html + "<h2>" + title + "</h2>"
        monitoringfunctions.outputTitle(title)
        for loop in range(10):
            apiUrl = ""
            apiUrl = "http://studentgradechecker-proxy.40322903.qpc.hal.davecutting.uk"
            inputText = ""
            moduleMark1 = randrange(99)
            moduleMark2 = randrange(99)
            moduleMark3 = randrange(99)
            moduleMark4 = randrange(99)
            moduleMark5 = randrange(99)
            moduleMark6 = randrange(99)
            module1 = "module1,"
            module2 = "newlinemodule2,"
            module3 = "newlinemodule3,"
            module4 = "newlinemodule4,"
            module5 = "newlinemodule5,"
            module6 = "newlinemodule6,"
            inputText = module1+str(moduleMark1)+module2+str(moduleMark2)+module3+str(
                moduleMark3)+module4+str(moduleMark4)+module5+str(moduleMark5)+module6+str(moduleMark6)

            apiUrl = apiUrl+"?input_text="+inputText+"&func="+key
   

            now = datetime.now()
            dt_string = now.strftime("%d/%m/%Y %H:%M:%S")
            currentTime = "["+dt_string + "]"
            start_time = time.time()
            result_json_response = requests.get(apiUrl)
            end_time = time.time()
            total_time = end_time - start_time

            apiOutput = json.loads(result_json_response.text)

            if key == 'maxmin':
                moduleMarks = monitoringfunctions.moduleMarksReturn(inputText)
                expected = monitoringfunctions.maxmin(inputText, moduleMarks)
                actual = apiOutput['answer']
                outputString = monitoringfunctions.testFunctions(
                    actual, expected, currentTime, total_time, moduleMark1, moduleMark2, moduleMark3, moduleMark4, moduleMark5, moduleMark6)
                html = html + "<p>" + outputString + "</p>"
                monitoringfunctions.outputResults(outputString)


            if key == 'sort':
                expected = monitoringfunctions.sort(inputText)
                actual = apiOutput['answer']
                outputString = monitoringfunctions.testFunctions(
                    actual, expected, currentTime, total_time, moduleMark1, moduleMark2, moduleMark3, moduleMark4, moduleMark5, moduleMark6)
                html = html + "<p>" + outputString + "</p>"
                monitoringfunctions.outputResults(outputString)

            if key == 'total':
                expected = monitoringfunctions.total(inputText)
                actual = apiOutput['answer']
                outputString = monitoringfunctions.testFunctions(
                    actual, expected, currentTime, total_time, moduleMark1, moduleMark2, moduleMark3, moduleMark4, moduleMark5, moduleMark6)
                html = html + "<p>" + outputString + "</p>"
                monitoringfunctions.outputResults(outputString)

            if key == 'classification':
                expected = monitoringfunctions.classification(inputText)
                actual = apiOutput['answer']
                outputString = monitoringfunctions.testFunctions(
                    actual, expected, currentTime, total_time, moduleMark1, moduleMark2, moduleMark3, moduleMark4, moduleMark5, moduleMark6)
                html = html + "<p>" + outputString + "</p>"
                monitoringfunctions.outputResults(outputString)

            

            if key == "compare":
                conn = mysql.connect()
                cursor = conn.cursor()
                cursor.execute(
                    "SELECT AVG(averageGrade) AS average FROM results")
                DbAverage = cursor.fetchone()

                html = html + "<h3> Compare (Database average) </h3>"
                actualDbAverageInt = apiOutput['dbAvgGrade']
                expectedDbAverageInt = int(DbAverage[0])
                outputString = monitoringfunctions.testFunctions(
                    actualDbAverageInt, expectedDbAverageInt, currentTime, total_time, moduleMark1, moduleMark2, moduleMark3, moduleMark4, moduleMark5, moduleMark6)
                html = html + "<p>" + outputString + "</p>"
                monitoringfunctions.outputResults(outputString)

                html = html + "<h3> Compare (current user average) </h3>"
                actualCurrentUserAvg = apiOutput['currentUserAvg']
                expectedCurrentUserAvg = monitoringfunctions.average(inputText)
                outputString = monitoringfunctions.testFunctions(
                    actualCurrentUserAvg, expectedCurrentUserAvg, currentTime, total_time, moduleMark1, moduleMark2, moduleMark3, moduleMark4, moduleMark5, moduleMark6)
                html = html + "<p>" + outputString + "</p>"
                monitoringfunctions.outputResults(outputString)

                html = html + "<h3> Compare (number of rows) </h3>"
                actualNumRows = apiOutput['numRows']
                expectedNumRows = cursor.execute("SELECT * FROM `results`")
                outputString = monitoringfunctions.testFunctions(
                    actualNumRows, expectedNumRows, currentTime, total_time, moduleMark1, moduleMark2, moduleMark3, moduleMark4, moduleMark5, moduleMark6)
                html = html + "<p>" + outputString + "</p>"
                monitoringfunctions.outputResults(outputString)

    f = open("results.txt", "a")
    f.write("\n \n")
    f.close()

    return html

# Create the background scheduler
scheduler = BackgroundScheduler()
# Create the job
scheduler.add_job(func=monitor, trigger="interval", seconds=3600)
# Start the scheduler
scheduler.start()

# Shut down the scheduler when exiting the app
atexit.register(lambda: scheduler.shutdown())




@app.route('/')
def hello_world():
    htmlText1 = "<h1>Monitoring and Metrics</h1> <hr>"
    htmlText2 = "<h2> <a href=/test> Click here to test microservices application </a> <h2> <hr>"
    htmlText3 = "<h2> <a href=/viewresults> Click here to view results</a> <h2> <hr>"
    landingPage = htmlText1+htmlText2+htmlText3


    return landingPage


@app.route('/test')
def test():
    html = monitor()
    return html

   

@app.route('/viewresults')
def results():
    #opens the text file and reads the data
    f = open("results.txt", "r")
    lines = f.readlines()
    f.close()

    html = "<h1>View Results </h1>"

    # outputing each line of results and formats in html paragraphs
    for line in lines:
        output = "<p>" + line + "</p> <hr>"
        html = html + output

    return html



if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)



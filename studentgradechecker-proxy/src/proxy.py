import json
from flask import Flask, request
import requests
import flask 
from proxyfunctions import functions   

app = Flask(__name__)



@app.route("/")
def proxy_home():
    #get parameters from input text
    sentence = request.args.get('input_text')
    editor_function = request.args.get('func')
    # check list of proxy functions
    for func, url in functions.items():
        if func == editor_function:
            function_found = True
            editor_function = url
    query = editor_function + "/?input_text=" + sentence
    output = requests.get(query)
        # output for error
    if output.status_code != 200:
        output = {
        "error": True,
        "sentence": "Error",
        "answer": 0
        }
        json_output = json.dumps(output)
        response = flask.Response(json_output)
        response.headers['Content-Type'] = 'application/json'
        response.headers['Access-Control-Allow-Origin'] = '*'
        return response
    else:
        response = flask.Response(output)
        response.headers['Content-Type'] = 'application/json'
        response.headers['Access-Control-Allow-Origin'] = '*'
        return response

@app.route("/functionslist")
def returnFunctionsList():

        json_output = json.dumps(functions)
        response = flask.Response(json_output)
        response.headers['Content-Type'] = 'application/json'
        response.headers['Access-Control-Allow-Origin'] = '*'
        return json_output



if __name__ == '__main__':
    app.run(host = '0.0.0.0', debug=True)
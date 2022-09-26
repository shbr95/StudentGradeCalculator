
from flask import Flask 
from flask import request
from flask import Response

from werkzeug.exceptions import HTTPException

from collections import OrderedDict
import totalfunctions
import json

app = Flask(__name__) 
@app.route("/")

def apirequest():
    try:
        input_text = request.args.get('input_text')
        totalfunctions.total(input_text)
    except Exception:
        error = True
    else:
        error = False

    x={
        "error": error,
        "string": input_text,
        "answer": totalfunctions.total(input_text)
        }
    reply = json.dumps(x)
    r = Response (response=reply, status=200, mimetype="application/json")
    r.headers["Content-Type"]="application/json"
    r.headers["Access-Control-Allow-Origin"]="*" 
    return r


if __name__ == '__main__':
    app.run(host='0.0.0.0', port =80) 



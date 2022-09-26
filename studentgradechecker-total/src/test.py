import unittest
from app import app
from flask import Flask 
from flask import request
from flask import Response
from flask import jsonify, make_response
from werkzeug.exceptions import HTTPException
from collections import OrderedDict
import totalfunctions
import json
import logging

class TestTotal(unittest.TestCase):
    def setUp(self):
        self.app = app.test_client()
 
    def test_apiResponse(self):
        response = self.app.get('/?input_text=Module1,90newlineModule2,80newlineModule3,90')
        actual = response.get_json()
        expected = {"error": False, "string": "Module1,90newlineModule2,80newlineModule3,90", "answer": 260}
        self.assertEqual(actual, expected)
    
    def testTotalFunction(self):
        input_text = "Module1,90newlineModule2,80newlineModule3,90"
        actual = totalfunctions.total(input_text)
        self.assertEqual(actual, 260)


    

       


if __name__ == '__main__':
    unittest.main()

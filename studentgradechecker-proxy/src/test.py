import unittest
import json
from flask import Flask, request
import requests
import flask 
from proxyfunctions import functions  
from proxy import app

class TestTotal(unittest.TestCase):
    def setUp(self):
        self.app = app.test_client()

    def test_APIResponseTotal(self):
      
        r = self.app.get('/?func=total&input_text=Module1,90newlineModule2,80newlineModule3,90')
        self.assertEqual(r.status_code, 200)


    def test_ProxyTotal(self):

        response = self.app.get('/?func=total&input_text=Module1,90newlineModule2,80newlineModule3,90')
        actual = response.get_json()
        expected = {"error": False, "string": "Module1,90newlineModule2,80newlineModule3,90", "answer": 260}
        self.assertEqual(actual, expected)

class TestSort(unittest.TestCase):
    def setUp(self):
        self.app = app.test_client()

    def test_APIResponseSort(self):
        self.app = app.test_client()
        r = self.app.get('/?func=sort&input_text=Module1,90newlineModule2,80newlineModule3,90')
        self.assertEqual(r.status_code, 200)

    def test_ProxySort(self):
        self.app = app.test_client()
        response = self.app.get('/?func=sort&input_text=Module1,90newlineModule2,80newlineModule3,90')
        actual = response.get_json()
        expected = {"error": False, "string": "Module1,90newlineModule2,80newlineModule3,90=Module1,90newlineModule3,90newlineModule2,80newline", "answer": "Module1,90newlineModule3,90newlineModule2,80newline"}
        self.assertEqual(actual, expected)

class TestMedian(unittest.TestCase):
    def setUp(self):
        self.app = app.test_client()

    def test_APIResponseMedian(self):
        self.app = app.test_client()
        r = self.app.get('/?func=median&input_text=Module1,90newlineModule2,80newlineModule3,90')
        self.assertEqual(r.status_code, 200)

    def test_ProxyMedian(self):
        self.app = app.test_client()
        response = self.app.get('/?func=median&input_text=Module1,90newlineModule2,80newlineModule3,90')
        actual = response.get_json()
        expected = {"error": False, "string": "Module1,90newlineModule2,80newlineModule3,90", "moduleName1": "Module1", "oddEven": "odd", "answer": "90"}
        self.assertEqual(actual, expected)

class TestMaxMin(unittest.TestCase):

    def setUp(self):
        self.app = app.test_client()

    def test_APIResponseMaxMin(self):
        self.app = app.test_client()
        r = self.app.get('/?func=maxmin&input_text=Module1,90newlineModule2,80newlineModule3,90')
        self.assertEqual(r.status_code, 200)

    def test_ProxyMaxMin(self):
        self.app = app.test_client()
        response = self.app.get('/?func=maxmin&input_text=Module1,90newlineModule2,80newlineModule3,90')
        actual = response.get_json()
        expected = {"error": False, "string": "Module1,90newlineModule2,80newlineModule3,90=Module1, 90newlineModule2, 80", "answer": "Module1, 90newlineModule2, 80"}
        self.assertEqual(actual, expected)


class TestClassification(unittest.TestCase):

    def setUp(self):
        self.app = app.test_client()

    def test_APIResponseClassification(self):
        self.app = app.test_client()
        r = self.app.get('/?func=classification&input_text=Module1,90newlineModule2,80newlineModule3,90')
        self.assertEqual(r.status_code, 200)

    def test_ProxyMaxClassifcation(self):
        self.app = app.test_client()
        response = self.app.get('/?func=classification&input_text=Module1,90newlineModule2,80newlineModule3,90')
        actual = response.get_json()
        expected = { "answer": "Distinction", "error": False, "string": "Module1,90newlineModule2,80newlineModule3,90" }
        self.assertEqual(actual, expected)



    

       


if __name__ == '__main__':
    unittest.main()

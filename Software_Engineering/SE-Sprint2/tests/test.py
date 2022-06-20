import os
import sys
import unittest

#to import app from app the following 3 lines are needed
currentdir = os.path.dirname(os.path.realpath(__file__))
parentdir = os.path.dirname(currentdir)
sys.path.append(parentdir)
from app import app

class TestCases(unittest.TestCase):

    # test for visitor registration page
    def test_visitor_registration(self):
        tester = app.test_client(self)
        response = tester.get('/', content_type="html/text")
        self.assertIn(b'Visitor Registration', response.data)

    # test for agent sign in page
    def test_agent_signin(self):
        tester= app.test_client(self)
        response = tester.get('/agent-signin', content_type="html/text")
        self.assertIn(b'Agent Signin', response.data)
    
    # test for hospital sign in page
    def test_hospital_signin(self):
        tester= app.test_client(self)
        response = tester.get('/hospital-signin', content_type="html/text")
        self.assertIn(b'Hospital Signin', response.data)

    # test for agent tools page
    def test_agent_tools(self):
        tester= app.test_client(self)
        response = tester.get('/agent_tools', content_type="html/text")
        self.assertIn(b'Agent tools', response.data)
    
    # test for hospital tools page
    def test_hospital_tools(self):
        tester= app.test_client(self)
        response = tester.get('/hospital_tools', content_type="html/text")
        self.assertIn(b'Hospital tools', response.data)

if __name__=='__main__':
   unittest.main()
import unittest

from app import app
from flask import json


class CoronaTest(unittest.TestCase):
    def setUp(self):
        self.app = app.test_client()

    # tests to check all unprotected routes are working

    def test_main_page(self):
        response = self.app.get('/', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    def test_visitorRegistration_page(self):
        response = self.app.get('/visitorregistration', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    def test_placeRegistration_page(self):
        response = self.app.get('/placeregistration', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    def test_agentLogin_page(self):
        response = self.app.get('/agentlogin', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    def test_hospitalLogin_page(self):
        response = self.app.get('/hospitallogin', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    # test to check that all protected routes fail without registered/loggedin client
    def test_placeHome_page(self):
        response = self.app.get('/placehome', follow_redirects=True)
        self.assertIn(
            b'<form action="/placeregistration" method="post">', response.data)

    def test_visitorHome_page(self):
        response = self.app.get('/visitorhome', follow_redirects=True)
        self.assertIn(
            b'<form action="/visitorregistration" method="post">', response.data)

    def test_agentHome_page(self):
        response = self.app.get('/agenthome', follow_redirects=True)
        self.assertIn(
            b'<form action="agentlogin" method="post">', response.data)

    def test_hospitalHome_page(self):
        response = self.app.get('/hospitalhome', follow_redirects=True)
        self.assertIn(
            b'<form action="hospitallogin" method="post">', response.data)

    # test visitor registration with missing data - leaving out phone

    def test_visitorRegistration_fail(self):
        response = self.app.post(
            '/visitorregistration', data=dict(fname="test", lname="test", city="test", address="test", email="sdfsd@sdf"), follow_redirects=True)

        self.assertEqual(response.status_code, 400)

    # test visitor registration with full data
    def test_visitorRegistration_work(self):
        response = self.app.post(
            '/visitorregistration', data=dict(fname="test", lname="test", city="test", address="test", email="sdfsd@sdf", phone="23432"), follow_redirects=True)

        self.assertEqual(response.status_code, 200)

    # test place registration with missing data - leaving out email
    def test_placeRegistration_fail(self):
        response = self.app.post(
            '/placeregistration', data=dict(pname="test", address="test", phone="23432"), follow_redirects=True)

        self.assertEqual(response.status_code, 400)

    # test place registration with full data
    def test_placeRegistration_work(self):
        response = self.app.post(
            '/placeregistration', data=dict(pname="test", address="test", email="test@sd", phone="23432"), follow_redirects=True)

        self.assertEqual(response.status_code, 200)

    # test agent login with wrong data

    def test_agentLogin_fail(self):
        response = self.app.post(
            '/agentlogin', data=dict(agent_id="10", username="test", password="test"), follow_redirects=True)

        self.assertEqual(response.status_code, 400)

    # test admin login with correct data

    def test_adminLogin_work(self):
        response = self.app.post(
            '/agentlogin', data=dict(agent_id=2, username="testname", password="testpassword"), follow_redirects=True)

        self.assertEqual(response.status_code, 200)

    # test hospital login with wrong data

    def test_hospitalLogin_fail(self):
        response = self.app.post(
            '/hospitallogin', data=dict(hospital_id="10", username="test", password="test"), follow_redirects=True)

        self.assertEqual(response.status_code, 400)

    # test hospital login with correct data

    def test_hospitalLogin_work(self):
        response = self.app.post(
            '/hospitallogin', data=dict(hospital_id="2", username="testname", password="testpassword"), follow_redirects=True)

        self.assertEqual(response.status_code, 200)


if __name__ == "__main__":
    unittest.main()

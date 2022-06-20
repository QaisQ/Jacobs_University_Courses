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
        response = self.app.get('/visitor-registration', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    def test_placeRegistration_page(self):
        response = self.app.get('/place-registration', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    def test_agentLogin_page(self):
        response = self.app.get('/agent-signin', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    def test_hospitalLogin_page(self):
        response = self.app.get('/hospital-signin', follow_redirects=True)
        self.assertEqual(response.status_code, 200)

    # test to check that all protected routes fail without registered/loggedin client
    def test_placeHome_page(self):
        response = self.app.get('/place-homepage', follow_redirects=True)
        self.assertIn(
            b'<form action="/place-registration" method="post">', response.data)

    def test_visitorHome_page(self):
        response = self.app.get('/visitor-homepage', follow_redirects=True)
        self.assertIn(
            b'<form action="/visitor-registration" method="post">', response.data)

    def test_agentHome_page(self):
        response = self.app.get('/agent-homepage', follow_redirects=True)
        self.assertIn(
            b'<form action="agent-signin" method="post">', response.data)

    def test_hospitalHome_page(self):
        response = self.app.get('/hospital-homepage', follow_redirects=True)
        self.assertIn(
            b'<form action="/hospital-signin" method="post">', response.data)

    # test visitor registration with missing data - leaving out phone

    def test_visitorRegistration_fail(self):
        response = self.app.post(
            '/visitor-registration', data=dict(fname="test", lname="test", city="test", address="test", email="sdfsd@sdf"), follow_redirects=True)

        self.assertEqual(response.status_code, 400)

    # test visitor registration with full data
    def test_visitorRegistration_work(self):
        response = self.app.post(
            '/visitor-registration', data=dict(fname="test", lname="test", city="test", address="test", email="sdfsd@sdf", phone="23432"), follow_redirects=True)

        self.assertEqual(response.status_code, 200)

    # test place registration with missing data - leaving out email
    def test_placeRegistration_fail(self):
        response = self.app.post(
            '/place-registration', data=dict(name="test", address="test", phone="23432"), follow_redirects=True)

        self.assertEqual(response.status_code, 400)

    # test place registration with full data
    def test_placeRegistration_work(self):
        response = self.app.post(
            '/place-registration', data=dict(name="test", address="test", email="test@sd", phone="23432"), follow_redirects=True)

        self.assertEqual(response.status_code, 200)

    # test agent login with wrong data

    def test_agentLogin_fail(self):
        response = self.app.post(
            '/agent-signin', data=dict(username="test", password="test"), follow_redirects=True)

        self.assertEqual(response.status_code, 400)

    # test admin login with correct data

    def test_adminLogin_work(self):
        response = self.app.post(
            '/agent-signin', data=dict(username="testname", password="testpassword"), follow_redirects=True)

        self.assertEqual(response.status_code, 200)

    # test hospital login with wrong data

    def test_hospitalLogin_fail(self):
        response = self.app.post(
            '/hospital-signin', data=dict(username="test", password="test"), follow_redirects=True)

        self.assertEqual(response.status_code, 400)

    # test hospital login with correct data

    def test_hospitalLogin_work(self):
        response = self.app.post(
            '/hospital-signin', data=dict(username="testname", password="testpassword"), follow_redirects=True)

        self.assertEqual(response.status_code, 200)


if __name__ == "__main__":
    unittest.main()
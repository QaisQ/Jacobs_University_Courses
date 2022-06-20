from cgi import test
import unittest
from urllib import response
import os, sys
currentdir = os.path.dirname(os.path.realpath(__file__))
parentdir = os.path.dirname(currentdir)
sys.path.append(parentdir)
from app import app

class coronaAppTests(unittest.TestCase):

    # checking status code and data returned in Home page
    def test_home_page(self):
        tester = app.test_client(self)
        response = tester.get("/", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Corona Web Service", response.data)

    # checking status code and data returned in visitor registration page
    def test_Visitor_registration_page(self):
        tester = app.test_client(self)
        response = tester.get("/registerVisitor", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Corona Web Service", response.data)

    # checking status code and data returned in place registration page
    def test_place_registration_page(self):
        tester = app.test_client(self)
        response = tester.get("/registerPlace", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Place name", response.data)

    # checking status code and data returned in agent login page
    def test_agent_login_page_1(self):
        tester = app.test_client(self)
        response = tester.get("/loginAgent", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Agent Login", response.data)
    
    # checking status code and data returned in Hospital login page
    def test_hospital_login_page_1(self):
        tester = app.test_client(self)
        response = tester.get("/loginHospital", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Hospital Login", response.data)
    
    # checking status code and data returned in QR scanning page
    def test_qr_scanning_page(self):
        tester = app.test_client(self)
        response = tester.get("/gotoQRscan", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)

    # checking visitor registering form
    def test_registering_user_page(self):
        tester = app.test_client(self)
        userData = {"visitor_name": "fqfq", "username":"fqfq","address":"rqrqrqr", "email":"errr@gmail.com","phone_number":"6116161616",  "device_id": "8728" ,"password":"pass"}
        response = tester.post("/registerVisitor", data=userData, follow_redirects = True)
        self.assertIn(b"You have been added to Record.", response.data)

    # checking duplicated entry of visitor while registering form
    # citizens are identified uniquelz by citizen id
    # also because this test depends on execution of previous test, it must
    # come in alphabetical order to previous test
    def test_registering_user_page_for_duplicates(self):
        tester = app.test_client(self)
        userData = {"citizen_id": "108", "visitor_name": "uk", "address":"uk", "phone_number":"103", "email":"uk@gmail.com", "device_id": "103" ,"infected":"1"}
        response = tester.post("/registerVisitor", data=userData, follow_redirects = True)
        statusCode = response.status_code
        self.assertEqual(statusCode, 400)

    # checking Place registering form
    def test_registering_place_page(self):
        tester = app.test_client(self)
        placeData = {"Place_name":"San tiago", "address":"santigo, new road", "QR":"QRS"}
        response = tester.post("/registerPlace", data=placeData, follow_redirects =True )
        statusCode = response.status_code
        self.assertEqual(statusCode, 400)    
    # checking Hospital login form
    def test_hospital_login_page(self):
        tester = app.test_client(self)
        loginData = {"name" :"admin", "password" : "admin"}
        response = tester.post("/loginHospital", data=loginData, follow_redirects =True )
        statusCode = response.status_code
        self.assertEqual(statusCode, 400)

    # check agent login page
    def test_agent_login_page(self):
        tester = app.test_client(self)
        loginData = {"email" :"admin", "password" : "admin"}
        response = tester.post("/loginAgent", data=loginData, follow_redirects =True )
        statusCode = response.status_code
        self.assertEqual(statusCode, 400)

    # test about page
    def test_about_page(self):
        tester = app.test_client(self)
        response = tester.get("/about", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"About", response.data)
    
    # test logout page
    def test_logout_page(self):
        tester = app.test_client(self)
        response = tester.post("/logout", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 405)

    # test contact page
    def test_contact_page(self):
        tester = app.test_client(self)
        response = tester.get("/contact", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Home", response.data)
    
    # test thankyou page
    def test_thankyou_page(self):
        tester = app.test_client(self)
        response = tester.get("/thankyou", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Corona Web Service", response.data)
    
    # test terms page
    def test_terms_page(self):
        tester = app.test_client(self)
        response = tester.get("/termsandconditions", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Home", response.data)

    # test register visitor page
    def test_register_visitor_page(self):
        tester = app.test_client(self)
        response = tester.get("/registerVisitor", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Register Visitor", response.data)

    # test register place page
    def test_register_place_page(self):
        tester = app.test_client(self)
        response = tester.get("/registerPlace", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Register Place", response.data)

    # test login visitor page
    def test_login_visitor_page(self):
        tester = app.test_client(self)
        response = tester.get("/loginVisitor", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Visitor login", response.data)
    
    # test login place page
    def test_login_place_page(self):
        tester = app.test_client(self)
        response = tester.get("/loginPlace", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Place login", response.data)

    # test login agent page
    def test_login_agent_page(self):
        tester = app.test_client(self)
        response = tester.get("/loginAgent", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Agent login", response.data)
    
    # test agent dashboard page
    def test_agent_dashboard_page(self):
        tester = app.test_client(self)
        response = tester.get("/agentDashboard", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Agent Dashboard", response.data)
    
    # test agent sees Hospitals page
    def test_agent_seesHospitals_page(self):
        tester = app.test_client(self)
        response = tester.get("/agentSeesHospitals", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Hospital List", response.data)

    # test agent add Hospitals page
    def test_agent_addHospitals_page(self):
        tester = app.test_client(self)
        response = tester.get("/addhospital", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Add", response.data)
    
    # test hospital dashboard page
    def test_hospital_dashboard_page(self):
        tester = app.test_client(self)
        response = tester.get("/hospitalDashboard", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Visitor List", response.data)

    # test getContacts
    def test_get_contacts_page(self):
        tester = app.test_client(self)
        response = tester.get("/getContacts/12314", content_type="html/text")
        expected_response = b'[[12314, "cool", "Dolly Newlove", "22839 Havey Place", 4272923420, "dnewlove7@digg.com", "46.200.41.149", 0, "QjK4DqK", 0]]'
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertEqual(response.data, expected_response)
    

    def test_visitor_history_page(self):
        tester = app.test_client(self)
        response = tester.get("/getVisitorHistory/36679/100", content_type="html/text")
        expected_response = [[1,18,"Lowe-Cremin","36112 Johnson Point","2022-05-06 17:00:16.385775","2022-05-06 17:00:32.056341"],[2,18,"Lowe-Cremin","36112 Johnson Point","2022-05-06 17:01:18.098285","2022-05-06 17:35:14.002696"],[3,18,"Lowe-Cremin","36112 Johnson Point","2022-05-06 17:35:30.673494","2022-05-06 17:37:28.391675"],[4,18,"Lowe-Cremin","36112 Johnson Point","2022-05-06 17:41:48.153185","2022-05-06 17:42:05.688674"],[5,18,"Lowe-Cremin","36112 Johnson Point","2022-05-06 17:42:45.736627","2022-05-06 17:42:59.010253"],[6,18,"Lowe-Cremin","36112 Johnson Point","2022-05-06 17:43:21.469566","2022-05-06 17:43:35.852476"]]
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertEqual(response.get_json(), expected_response)

    def test_place_history_page(self):
        tester = app.test_client(self)
        response = tester.get("/getPlaceHistory/18/100", content_type="html/text")
        expected_response = [[1,36679,"fdairton0@pen.io","2022-05-06 17:00:16.385775","2022-05-06 17:00:32.056341",0],[2,36679,"fdairton0@pen.io","2022-05-06 17:01:18.098285","2022-05-06 17:35:14.002696",0],[3,36679,"fdairton0@pen.io","2022-05-06 17:35:30.673494","2022-05-06 17:37:28.391675",0],[4,36679,"fdairton0@pen.io","2022-05-06 17:41:48.153185","2022-05-06 17:42:05.688674",0],[5,36679,"fdairton0@pen.io","2022-05-06 17:42:45.736627","2022-05-06 17:42:59.010253",0],[6,36679,"fdairton0@pen.io","2022-05-06 17:43:21.469566","2022-05-06 17:43:35.852476",0]]
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertEqual(response.get_json(), expected_response)
    
    def test_documentation_page(self):
        tester = app.test_client(self)
        response = tester.get("/docs", content_type="html/text")
        statusCode = response.status_code
        self.assertEqual(statusCode, 200)
        self.assertIn(b"Corona Archive Web Service Documentation", response.data)

if __name__ == "__main__":
    unittest.main()
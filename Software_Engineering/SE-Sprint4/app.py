import json
from turtle import done
from flask import Flask, jsonify, redirect, render_template, url_for, request,session
from flask_selfdoc import Autodoc
import sqlite3 
print(sqlite3.sqlite_version)
import requests 
import qrcode
from random import randrange
from datetime import datetime, timedelta


# initilaing flask app
app = Flask(__name__) 
app.secret_key = "se"
# connecting to sqlite
conn = sqlite3.connect('visitors.db')
c = conn.cursor()

auto = Autodoc(app)

def check_login_info(user_type,username,password): 
     
    print(user_type)
    nconn = sqlite3.connect('visitors.db',  check_same_thread=False )
    nc = nconn.cursor()
    print(type(nc))
    try:
        if user_type == "visitors":
            nc.execute('SELECT *  FROM visitors WHERE username = "{username}" AND password = "{password}";'
                        .format(username = username, password = password))
        elif user_type  == "places":
            nc.execute('SELECT *  FROM places WHERE username = "{username}" AND password = "{password}";'
                        .format(username = username, password = password))
        elif user_type == "agents":
            nc.execute('SELECT *  FROM agents WHERE username = "{username}" AND password = "{password}";'
                        .format(username = username, password = password))
        elif user_type == "hospitals":
           nc.execute(f"SELECT * from hospitals WHERE username='{username}' AND password='{password}';" )
            
        m = nc.fetchall() 
        if len(m) == 0:
            return -1
        nconn.close()
        print(m)
        return m
    except: 
        print("out")
        return -1

conn.commit()
conn.close()



@app.route('/')
@auto.doc()
def index():
    """ Homepage """
    return render_template("index.html")

@app.route('/about')
@auto.doc()
def about():
    """ About this project """
    return render_template("about.html")  

def logout_page(**kwargs):
    """ Render the logout page """
    url = "logout.html"
    return render_template(url, **kwargs)


@app.route('/logout', methods=['GET'])
@auto.doc()
def logout():    
    """ logs the user out """
    user = session["user_type"]
    session.clear()
    return logout_page(logout_success = True,user=user)


@app.route('/contact')
@auto.doc()
def contact():
    """ Contact us page """
    return render_template("contact.html")


@app.route('/thankyou')
@auto.doc()
def thankyou():
    """ display a thank you page after sending a message """
    return render_template("thankyoupage.html")


@app.route('/termsandconditions')
@auto.doc()
def termsandconditions():
    """ display the terms and condition page """
    return render_template("terms.html")


@app.route('/registerVisitor', methods=['POST', 'GET'])
@auto.doc()
def registerVisitor():
    """ Visitor Registration page """ 
    try: 
        """ if user already logged is as visitor, display the QR scanner page """
        if session["vist_log_in"]: 
            return render_template("scanQR.html") 
    except:
        pass
    if request.method == 'POST':
        """ if the request is a post request then register the visitor """
        username = request.form['username']
        visitor_name = request.form['visitor_name']
        address = request.form['address']
        email = request.form['email']
        phone_number = request.form['phone_number']
        device_id = request.form['device_id']
        password = request.form['password']
        nconn = sqlite3.connect('visitors.db',  check_same_thread=False)
        nc = nconn.cursor()
        nc.execute(f"SElECT * FROM visitors WHERE username=='{username}'")
        validateUser = nc.fetchone()
        if not validateUser:
            """ if the username doesn't already exsits, create the visitor's account """
            nc.execute("INSERT INTO visitors (username, visitor_name, address, email, phone_number, device_id, infected, password, checked_in) VALUES (?,?,?,?,?,?,0, ?,0)",
                    (username, visitor_name, address, email, phone_number, device_id, password))

            nconn.commit()
            nconn.close()
            return render_template("linker.html")
        else:
            """ else, display an error. """
            return render_template('error.html', errorValue="User already exists.")
    else:
        return render_template("registerVisitor.html")


@app.route('/registerPlace', methods=['POST', 'GET'])
@auto.doc()
def registerPlace():  
    """ Place registration page """
    try:
        if session["place_log"]:
            """ If the user is already logged in as a place, display the place's QR code. """
            return render_template("qrpage.html") 
    except:
        pass
    if request.method == 'POST':
        username = request.form['username']
        place_name = request.form['place_name']
        address = request.form['address']
        password = request.form['password']
        nconn = sqlite3.connect('visitors.db',  check_same_thread=False)
        nc = nconn.cursor() 
        qr_code = username + place_name
        nc.execute(f"SElECT * FROM places WHERE username='{username}'")
        validateUser = nc.fetchone()
        if not validateUser:

            nc.execute("INSERT INTO places (place_name,username, address, qrcode, password) VALUES (?,?,?,?,?)",
                    (place_name,username,address, qr_code, password))

        nconn.commit()
        nconn.close() 
        return render_template("linker2.html")

    else:
        return render_template("registerPlace.html")


@app.route('/loginVisitor', methods=['POST', 'GET'])
@auto.doc()
def loginVisitor(): 
    """ Visitor login page """
    try:
        if session['vist_log_in']: 
            if isCheckedIn(session['vist_id']):
                return render_template("scanQR.html", checkedIn = True)
            else:
                return render_template("scanQR.html")  
    except:
        pass  
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password'] 
        user_type = "visitors"
        value = check_login_info(user_type,username,password) 
        if value != -1: 
            session["vist_log_in"] = True 
            session["username"] = username   
            session["user_type"] = user_type 
            print("user") 
            print(session["user_type"]) 
            session["vist_id"] = value[0][0] 
            session["vist_name"] = value[0][1]    
            if isCheckedIn(session['vist_id']):
                return render_template("scanQR.html", checkedIn = True)
            else:
                return render_template("scanQR.html")
    else:
        return render_template("loginVisitor.html")


@app.route('/loginPlace', methods=['POST', 'GET'])
@auto.doc()
def loginPlace():
    """ Place login page """
    try: 
        if session["place_log"]: 
            return render_template("qrpage.html") 
    except:
        pass
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password'] 
        user_type = "places"
        nconn = sqlite3.connect('visitors.db',  check_same_thread=False ) 
        cursor = nconn.cursor() 
        statement = f"SELECT * from places WHERE username='{username}' AND password='{password}';" 
        print("before")  
        value = f"SELECT qrcode from places WHERE username='{username}';"  
        print(value)
        cursor.execute(statement)  
        data = cursor.fetchall()
        if cursor.fetchone:  
            session["place_log"] = True
            session["username"] = username
            session["user_type"] = user_type 
            session["place_id"] = data[0][0] 
            session["place_name"] = data[0][1]
            cursor.execute(value)
            if cursor.fetchone:  
                data = cursor.fetchall()  
                star = ''.join(map(str, data))
                print(type(star))
                print(star)
                img = qrcode.make(star) 
                img.save("./static/img/seee.jpeg") 
                nconn.close()
                return render_template("qrpage.html")
        else: 
            return "Errror" 
        

    else:
        return render_template("loginPlace.html")


@app.route('/loginHospital', methods=['POST', 'GET'])
@auto.doc()
def loginHospital(): 
    """ Hospital login page """
    try:
        if session['hos_logged_in']:
            return hospitalDashboard() 
    except: 
        pass
    if request.method == 'POST':

        username = request.form['username']
        password = request.form['password'] 
        user_type = "hospitals"
        data = check_login_info(user_type,username,password) 
        print("data")
        print(data)
        if data != -1: 
            session["hos_logged_in"] = True 
            session["username"] = username   
            session["user_type"] = user_type 
            print("user") 
            print(session["user_type"]) 
            session["hospital_id"] = data[0][0] 
            session["hosp_name"] = data[0][1]   
            print("In hopsital") 
            return hospitalDashboard() 
        else: 
            return "Errror"

    else:
        return render_template("loginHospital.html")


@app.route('/loginAgent', methods=['POST', 'GET'])
@auto.doc()
def loginAgent(): 
    """ Agent login page """
    try:
        if session['agent_logged_in']:
            return agentDashboard()
    except:
        pass
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password'] 
        user_type = "agents"
        value = check_login_info(user_type,username,password) 
        if value != -1:
            session["agent_logged_in"] = True 
            session["agent_username"] = username   
            session["user_type"] = user_type 
            print("user_type")  
            print(session["user_type"]) 
            return agentDashboard() 
        else:
            return "Wrong Credentials"
    else:
        return render_template("loginAgent.html")


@app.route('/agentDashboard', methods=['POST', 'GET'])
@auto.doc()
def agentDashboard():
    """ display the agent dashboard page. """
    nconn = sqlite3.connect('visitors.db',  check_same_thread=False)
    nc = nconn.cursor()
    nc.execute(
        f"SELECT citizen_id, visitor_name, username, address, phone_number, email, device_id, infected FROM visitors")
    tuple_array = nc.fetchall()
    print('here')
    print(tuple_array)

    array = [list(elem) for elem in tuple_array]
    return render_template("agentPage.html", array=array)


@app.route('/agentSeesHospitals', methods=['POST', 'GET'])
@auto.doc()
def agentSeesHospitals():
    """ Display a list of hospitals to the agent. """
    if request.method == 'GET':
        nconn = sqlite3.connect('visitors.db',  check_same_thread=False)
        nc = nconn.cursor()
        nc.execute(f"SELECT hospital_id, name FROM hospitals")
        tuple_array = nc.fetchall()
        array = [list(elem) for elem in tuple_array]
        return render_template("agentSeesHospitals.html", array=array)


@app.route('/agentaddHospital', methods=['GET', 'POST'])
@auto.doc()
def agentaddHospital():
    """ Insert new hospitals added by an agent to the system. """
    if request.method == 'POST':
        username = request.form["username"] 
        password = request.form["password"] 
        hospital_name = request.form["hosp_name"] 
        nconn = sqlite3.connect('visitors.db',  check_same_thread=False) 
        nc = nconn.cursor()
        nc.execute(f"SElECT * FROM hospitals WHERE username=='{username}'")  
        validate = nc.fetchone() 
        if not validate: 
            nc.execute("INSERT INTO hospitals (name,username,password) VALUES (?,?,?)",
                    (hospital_name,username,password))
            nconn.commit()
            nconn.close()  
            return render_template("added.html")
        else: 
            return render_template('error.html', errorValue="User already exists.") 
    else: 
        return "faak" 

@app.route("/addhospital", methods=['GET','POST']) 
@auto.doc()
def addhospital(): 
    """ Display the addhospital page. """
    return render_template("addhospital.html")

@app.route('/hospitalDashboard', methods=['GET', 'POST'])
@auto.doc()
def hospitalDashboard():
    """ Display the hospital dashboard. """
    print("In dash")
    nconn = sqlite3.connect('visitors.db',  check_same_thread=False)
    nc = nconn.cursor()
    nc.execute(
    f"SELECT citizen_id, visitor_name, username, address, phone_number, email, device_id, infected FROM visitors")
    tuple_array = nc.fetchall()
    array = [list(elem) for elem in tuple_array]
    return render_template("hospitalPage.html", array=array) 

@app.route('/showQRcode/<QRcode>')
@auto.doc()
def showQRcode(QRcode):
    """ Show the QR code """
    return render_template("showQRcode.html", QRcode=QRcode)


@app.route('/gotoQRscan')
@auto.doc()
def scanQRcode():
    """ Display the QR scanner page """
    return render_template("scanQR.html") 


@app.route("/visit/<placeID>", methods=['POST', 'GET'])
@auto.doc()
def visitPlace(placeID):
    """ Check the logged in visitor to <placeID>  """
    print(f'User Type: {session.get("user_type")}')
    print(f'Visitor ID: {session.get("vist_id")}')    
    """ check if logged in user is visitor, else return error """
    if(session.get("user_type") == "visitors"):
        """ check if visitor is already checked in """
        if isCheckedIn(session.get("vist_id")):
            return "Visitor Already Checked In."
        else:
            conn = sqlite3.connect('visitors.db',  check_same_thread=False)
            cursor = conn.cursor()
            statement = f'INSERT INTO Visits (citizen_id, place_id, check_in_time) VALUES ({session.get("vist_id")}, (SELECT place_id FROM places WHERE qrcode="{placeID}"), "{datetime.now()}"); UPDATE visitors SET checked_in=1 WHERE citizen_id={session.get("vist_id")};'
            print(f'Statement: {statement}')
            cursor.executescript(statement)
            conn.commit()
            conn.close()
            return 'done'
    else:
        """ Return Error """
        return 'Error'

def isCheckedIn(userID):
    """ 
        connect to db 
        query for visitors.checked_in and return 
    """
    conn = sqlite3.connect('visitors.db',  check_same_thread=False)
    cursor = conn.cursor()
    statement = f'SELECT checked_in FROM visitors WHERE citizen_id={userID}'
    cursor.execute(statement)
    checked = cursor.fetchone()
    conn.close()
    return bool(checked[0])

@app.route('/checkout', methods=['POST', 'GET'])
@auto.doc()
def checkout():
    """
        Check out function
        Checks out the visitor from the establishment
    """
    if(session.get("user_type") == "visitors"):
        conn = sqlite3.connect('visitors.db',  check_same_thread=False)
        cursor = conn.cursor()
        statement = f"SELECT visit_id FROM Visits WHERE citizen_id={session.get('vist_id')} AND check_out_time IS NULL;"
        cursor.execute(statement)
        rows = cursor.fetchone()
        if rows:
            statement = f"""UPDATE Visits SET check_out_time="{datetime.now()}" WHERE citizen_id={session.get("vist_id")} AND check_out_time IS NULL; UPDATE visitors SET checked_in=0 WHERE citizen_id={session.get("vist_id")};"""
            cursor.executescript(statement)
            conn.commit()
            return 'Checked Out Successfully'
        else:
            return 'Not Checked In'
    else:
        """ return render_template('ErrorVisiting.html') """
        return 'Not logged in as a visitor'

def getCurrentDateAndTime():
    """ Returns the current date and time in the format %Y-%m-%d %H:%M:%S.%f """
    now = datetime.now()
    dt_string = now.strftime("%Y-%m-%d") 
    dt2_string = now.strftime("%H:%M:%S.%f") 
    val_string = str(dt_string)+str(" ")+str(dt2_string)
    return val_string

def getVisitors():
    """ get the list of all visits """
    conn = sqlite3.connect('visitors.db',  check_same_thread=False)
    cursor = conn.cursor()
    statement = f'SELECT Visits.visit_id, visitors.citizen_id, places.place_id, visitors.email, Visits.check_in_time, Visits.check_out_time, visitors.infected FROM Visits INNER JOIN visitors ON Visits.citizen_id = visitors.citizen_id INNER JOIN places ON Visits.place_id = places.place_id;'
    cursor.execute(statement)
    visitors = cursor.fetchall()
    return [list(visitor) for visitor in visitors]

def getContactList(InfectedVisitorID):
    """ Get The List of possible infected by which came into contact with the infected person in the last 14 days and their contacts and etc """
    
    def dateToUTC(date):
        """ Return UTC from date string """
        return datetime.strptime(date, '%Y-%m-%d %H:%M:%S.%f')

    def fixDates(visits):
        """ Change the the check out time to current date and time to do the calculations and get the UTC from of dates """
        for visit in visits:
            if (visit[5] == None):
                visit[5] = getCurrentDateAndTime()
            visit[4] = dateToUTC(visit[4])
            visit[5] = dateToUTC(visit[5])
        return visits

    def checkOverlap(date1_in, date1_out, date2_in, date2_out):
        """ Check if two <check_in, check_out> pairs overlap with each others """
        return ((date2_in <= date1_in <= date2_out) or (date1_in <= date2_in <= date1_out))

    def getOverlapList(vis ,visitorsList):
        """ Get the list of visits that overlap with a certain visit """
        ll = []
        for visit in vis:   
            for visitor in visitorsList:
                if (visit[1]!= visitor[1]) and (visit[2] == visitor[2]) and(checkOverlap(visit[4], visit[5], visitor[4], visitor[5])):
                    ll.append(visitor)
        return ll

    def getVisits(visitorID, visitorsList):
        """ Get the visits list for a certain visitor """
        ll = []
        for visitor in visitorsList:
            if (visitorID == visitor[1]):
                ll.append(visitor)
        return ll

    def getAfterDate(list, date):
        """ Get visits that starts after a certain date """
        li = []
        if not date:
            return []
        for visit in list:
            if visit[4] >= date:
                li.append(visit)
        return li, getEarliestDate(li)

    def getEndingAfter(list, date):
        """ Get visits that ends after a certain date """
        li = []
        if not date:
            return []
        for visit in list:
            if visit[5] >= date:
                li.append(visit)
        return li

    def getEarliestDate(list):
        """ Get the earliest start date between visits list """
        list.sort(key = lambda x: x[4])
        if list:
            return list[0][4]

    def getInfected(id, visits_list, date):
        """ Get the immediate contact list with the infected person since the date parameter and then for each person in the contact list it checks for their contacts since the inital contact with the infected person. """
        visited = []
        queue = []

        visited.append(id)
        newList, newDate = getAfterDate(getVisits(id, visits_list), date)
        lll = getOverlapList(newList, visitorsList=getEndingAfter(visits_list, newDate))
        for visit in lll:
                if visit[1] not in visited:
                    queue.append(visit[1])
                    visited.append(visit[1])
        return visited
    return getInfected(InfectedVisitorID, fixDates(getVisitors()), datetime.today()-timedelta(days=14))

@app.route('/getContacts/<int:visitorID>')
@auto.doc()
def getContacts(visitorID):
    """ API call to get the contact list of an infected persons in the last `14` days """
    ret = getContactList(visitorID)
    cursor = conn = sqlite3.connect('visitors.db',  check_same_thread=False)
    cursor = conn.cursor()
    if len(ret) == 1:
        statement = f'SELECT * FROM visitors WHERE citizen_id = {ret[0]};'
    else:
        statement = f'SELECT * FROM visitors WHERE citizen_id IN {tuple(ret)};'
    cursor.execute(statement)
    visitors = cursor.fetchall()
    return json.dumps(visitors)

@app.route('/getVisitorHistory/<int:VisitorID>/<int:Number_of_Days>')
@auto.doc()
def getVisitorHistory(VisitorID, Number_of_Days):
    """ API call to get the history of a persons visits in the last `Number_of_Days` days """
    cursor = conn = sqlite3.connect('visitors.db',  check_same_thread=False)
    cursor = conn.cursor()
    statement = f'SELECT Visits.visit_id, places.place_id, places.place_name, places.address, Visits.check_in_time, Visits.check_out_time FROM Visits INNER JOIN visitors ON Visits.citizen_id = visitors.citizen_id INNER JOIN places ON Visits.place_id = places.place_id WHERE Visits.citizen_id = {VisitorID};'
    cursor.execute(statement)
    visits = cursor.fetchall()
    visits = [list(visit) for visit in visits]
    visits_last_x_days = []
    for visit in visits:   
        timeDel = datetime.today() - datetime.strptime(visit[5], '%Y-%m-%d %H:%M:%S.%f')
        if timeDel.days <= Number_of_Days:
            visits_last_x_days.append(visit)
    response = jsonify(visits_last_x_days)
    response.headers.add('Access-Control-Allow-Origin', '*')
    return response

@app.route('/getPlaceHistory/<int:PlaceID>/<int:Number_of_Days>')
@auto.doc()
def getPlaceVisitorsHistory(PlaceID, Number_of_Days):
    """ API call to get a place's history in the last `Number_of_Days` days """
    cursor = conn = sqlite3.connect('visitors.db',  check_same_thread=False)
    cursor = conn.cursor()
    statement = f'SELECT Visits.visit_id, visitors.citizen_id, visitors.email, Visits.check_in_time, Visits.check_out_time, visitors.infected FROM Visits INNER JOIN visitors ON Visits.citizen_id = visitors.citizen_id INNER JOIN places ON Visits.place_id = places.place_id WHERE Visits.place_id = {PlaceID};'
    cursor.execute(statement)
    visits = cursor.fetchall()
    visits = [list(visit) for visit in visits]
    print(visits)
    visits_last_x_days = []
    for visit in visits:   
        timeDel = datetime.today() - datetime.strptime(visit[4], '%Y-%m-%d %H:%M:%S.%f')
        if timeDel.days <= Number_of_Days:
            visits_last_x_days.append(visit)
    response = jsonify(visits_last_x_days)
    response.headers.add('Access-Control-Allow-Origin', '*')
    return response

@app.route("/docs")
@auto.doc()
def documentation():
    """ Show this documentation page """
    return auto.html(title='Corona Archive Web Service Documentation')

# change port to open it in different port
if __name__ == "__main__":
    app.debug = True
    app.run(host="0.0.0.0", port=4888)

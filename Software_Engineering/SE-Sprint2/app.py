from flask import Flask, render_template, redirect, session, url_for, request
from flaskext.mysql import MySQL
import yaml
import uuid
import qrcode
from flask_selfdoc import Autodoc
import os
from datetime import timedelta

app = Flask(__name__)
app.secret_key = os.urandom(16)
app.permanent_session_lifetime = timedelta(days=30)


#mysql configuration
db = yaml.safe_load(open('db.yaml'))
app.config['MYSQL_DATABASE_HOST'] = db['mysql_host']
app.config['MYSQL_DATABASE_USER'] = db['mysql_user']
app.config['MYSQL_DATABASE_PASSWORD'] = db['mysql_password']
app.config['MYSQL_DATABASE_DB'] = db['mysql_db']

# init app
mysql = MySQL()
mysql.init_app(app)
auto = Autodoc(app)

# function to que mysql cursor
def get_cursor():
    cursor = mysql.get_db().cursor()
    return cursor


#image folder
imageFolder = os.path.join('static', 'img')
app.config['UPLOAD_FOLDER'] = imageFolder

#homepage render 
@app.route('/')
@auto.doc()
def index():
    backdrop_picture = os.path.join(app.config['UPLOAD_FOLDER'], 'backdrop.jpg')
    return render_template('index.html', pic1 = backdrop_picture)

# visitor registration page
@app.route('/visitor-registration', methods=['POST','GET'])
@auto.doc()
def visitorRegister():
    """Landing page, registration page for visitors.
    Form Data: 
        name: name of visitor
        password: password of visitor
        address: address of visitor
        city: city of visitor
    All fields are required.
    """
    # check if the visitor already has a saved session
    if "visitor_device_id" in session:
        return redirect(url_for('visitorHomepage'))

    cur = get_cursor()
    # check that all fields are filled
    if request.method == 'POST' and 'fname' in request.form and 'lname' in request.form and 'address' in request.form \
        and 'city' in request.form and 'email' in request.form and 'phone' in request.form:

        session.permanent = True

        # get data from form and put it in database
        first_name_visitor =  request.form['fname']
        name = request.form['fname'] + " " + request.form['lname']
        address = request.form['address'] + ", " + request.form['city']
        email = request.form['email']
        phone = request.form['phone']
        device_id = uuid.uuid4()    # generate a unique string
        session["visitor_device_id"] = device_id

        cur.execute('INSERT INTO Visitor (visitor_name,address,email,phone_number, device_id) \
                VALUES (%s,%s,%s,%s,%s)' , (name, address, email, phone, device_id))
        mysql.get_db().commit()
        cur.close()
        
        return redirect(url_for('visitorHomepage', first_name = first_name_visitor))
    else:
        return render_template('visitor_registration.html')

# place registration page
@app.route('/place-registration', methods=['POST','GET'])
@auto.doc()
def placeRegister():
    """Landing page, registration page for visitors.
    Form Data: 
        name: name of visitor
        password: password of visitor
        address: address of visitor
        city: city of visitor
    All fields are required.
    """

    # check if the place already has a saved session
    if "place_device_id" in session:
        return redirect(url_for('placeHomepage'))

    cur = get_cursor()
    # check that all fields are filled
    if request.method == 'POST' and 'name' in request.form and 'address' in request.form \
    and 'city' in request.form and 'email' in request.form and 'phone' in request.form:

        session.permanent = True

        # get data from form and put it in database
        name = request.form['name']
        address = request.form['address'] + ", " + request.form['city']
        email = request.form['email']
        phone = request.form['phone']
        unique_QR = uuid.uuid4()        # generate a unique string
        session["place_device_id"] = unique_QR

        cur.execute('INSERT INTO Places (place_name,address,email,phone_number,QRcode) \
                VALUES (%s,%s,%s,%s,%s)' , (name, address, email, phone, unique_QR))
        mysql.get_db().commit()
        cur.close()
        return redirect(url_for('placeHomepage'))
    else:
        return render_template('place_registration.html')


# agent sign in page
@app.route('/agent-signin', methods=['POST', 'GET'])
@auto.doc()
def agentSignin():
    """login page for agents.
    Form Data: 
        username: username of agent
        password: password of agent
    All fields are required.
    Must be a correct combination in the database
    """

    # check if agent has a saved session
    if "agent_device_id" in session:
        return redirect(url_for('agent_tools'))

    error = None
    cur = get_cursor()
    # check that all form fields are filled
    if request.method == 'POST' and 'username' in request.form  and 'password' in request.form:
        
        session.permanent = True
        unique_agent = uuid.uuid4()     # generate a unique string
        session["agent_device_id"] = unique_agent

        # get data from form and put it in database
        username = request.form['username']
        password = request.form['password']
        cur.execute("SELECT * FROM Agent A WHERE A.username = %s AND A.password = %s", (username, password))
        account = cur.fetchone()
        if account:
            session['loggedin'] = True
            session['username'] = username
            session['agent_id'] = account[0]
            cur.close()
            return redirect(url_for('agent_tools'))
        else:
            error = 'Error occured'
            return render_template('agent_signin.html', error=error)

    else:
        return render_template('agent_signin.html')

#hospital sign in page
@app.route('/hospital-signin', methods=['POST', 'GET'])
@auto.doc()
def hospitalSignin():
    """login page for hospital.
    Form Data: 
        username: username of hospital
        password: password of hospital
    All fields are required.
    Must be a correct combination in the database
    """

    # check if hospital has a session
    if "hospital_device_id" in session:
        return redirect(url_for('hospital_tools'))

    error = None
    cur = get_cursor()
    # check that all fields are filled
    if request.method == 'POST' and 'username' in request.form  and 'password' in request.form:

        session.permanent = True
        unique_hospital = uuid.uuid4()      # generate a unique string
        session["hospital_device_id"] = unique_hospital

        # get data from form and put it in database
        username = request.form['username']
        password = request.form['password']
        cur.execute("SELECT * FROM Hospital A WHERE A.username = %s AND A.password = %s", (username, password))
        account = cur.fetchone()
        if account:
            session['loggedin'] = True
            session['username'] = username
            session['hospital_id'] = account[0]
            cur.close()
            return redirect(url_for('hospital_tools'))
        else:
            error = 'Error occured'
            return render_template('hospital_signin.html', error=error)

    else:
        return render_template('hospital_signin.html')

# visitor homepage
@app.route('/visitor-homepage/<first_name>')
@auto.doc()
def visitorHomepage(first_name):
    # if the visitor is not in session return to home
    if "visitor_device_id" not in session:
        return redirect('/')
    return render_template('visitor_homepage.html', first_name = first_name)

# place homepage
@app.route('/place-homepage')
@auto.doc()
def placeHomepage():
    # if the place is not in session return to home
    if "place_device_id" not in session:
        return redirect('/')

    return render_template('place_homepage.html')


#QR PICture folder
QRimageFolder = os.path.join('static', 'QR')
app.config['UPLOAD_FOLDER'] = QRimageFolder

# downloads QR to device
@app.route('/download-QR')
@auto.doc()
def downloadQR():
    # generate unique QR code that carries the place session as data
    qr = qrcode.QRCode(
        version=1,
        box_size=15,
        border=15
    )
    data = session["place_device_id"]
    qr.add_data(data)
    qr.make(fit=True)
    qr_img = qr.make_image(fill = 'black', back_color='white')
    # saves image to file
    qr_img.save("static/QR/PlaceQR.png")

    

    qr_picture = os.path.join(app.config['UPLOAD_FOLDER'], 'PlaceQR.png')
    return render_template('place_homepage.html', qr = qr_picture)


# impressum page
@app.route('/impressum',methods=['POST','GET'])
@auto.doc()
def impressum():
    return render_template('imprint.html')

# agent tools page
@app.route('/agent_tools', methods=['POST','GET'])
@auto.doc()
def agent_tools():
    """agent tools page.
    Implementation pending
    """
    
    # if the agent is not in session return to home
    if "agent_device_id" not in session:
        return redirect('/')

    cur = get_cursor()
    cur.execute('SELECT citizen_id, visitor_name FROM Visitor WHERE infected')
    infected_people = cur.fetchall()
    # Struggling to figure out the query for places with infected visitors
    # TO DO
    cur.execute('SELECT place_id, place_name FROM Places')
    infected_places = cur.fetchall()
    return render_template('agent_tools.html',
        infected_people = infected_people, infected_places = infected_places)

#hospital tools page
@app.route('/hospital_tools',methods=['POST','GET'])
@auto.doc()
def hospital_tools():
    """hospital tools page.
    Implementation pending
    """

    # if the hospital is not in session return to home
    if "hospital_device_id" not in session:
        return redirect('/')

    cur = get_cursor()
    cur.execute('SELECT citizen_id, visitor_name FROM Visitor WHERE infected')
    infected_people = cur.fetchall()
    # Struggling to figure out the query for places with infected visitors
    cur.execute('SELECT place_id, place_name FROM Places')
    infected_places = cur.fetchall()
    return render_template('hospital_tools.html', infected_people = infected_people, infected_places = infected_places)

# Add /docs at the end of the standard link for the documentation
@app.route('/docs')
def docs():
    return auto.html(title='Corona Center API Docs')


@app.route('/visitor-logout')
def visitorLogout():
    """
        Deletes visitor session and returns to homepage
    """
    session.pop("visitor_device_id", None)
    return redirect('/')

@app.route('/place-logout')
def placeLogout():
    """
        Deletes place session and returns to homepage
    """
    session.pop("place_device_id", None)
    return redirect('/')

@app.route('/agent-logout')
def agentLogout():
    """
        Deletes agent session and returns to homepage
    """
    session.pop("agent_device_id", None)
    return redirect('/')

@app.route('/hospital-logout')
def hospitalLogout():
    """
        Deletes hospital session and returns to homepage
    """
    session.pop("hospital_device_id", None)
    return redirect('/')

@app.route('/user-search', methods=['POST', 'GET'])
def UserSearch():
    pass
    
    
    
    
if __name__ == "__main__":
    app.run(debug = True)

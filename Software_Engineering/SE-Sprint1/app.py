from flask import Flask, render_template, request, redirect, url_for, session
from flask_mysqldb import MySQL
from datetime import datetime
import yaml
import uuid
import qrcode
import qrcode.image.svg
from io import BytesIO
from flask_bcrypt import Bcrypt
from flask_selfdoc import Autodoc

app = Flask(__name__)
bcrypt = Bcrypt(app)
auto = Autodoc(app)
app.secret_key = 'BAD_SECRET_KEY'

# load database configuration into flask app from file
db = yaml.safe_load(open('db.yaml'))
app.config['MYSQL_HOST'] = db['mysql_host']
app.config['MYSQL_USER'] = db['mysql_user']
app.config['MYSQL_PASSWORD'] = db['mysql_password']
app.config['MYSQL_DB'] = db['mysql_db']
app.config['SECRET_KEY'] = db['bcrypt_secret']

mysql = MySQL(app)

# route for home/index


@app.before_request
def before_request():
    session.permanent = True


@app.route('/')
@app.route('/index')
@auto.doc()
def index():
    """ Home page route shows user selection menu
        Not protected
    """
    # if user is already signed in as a visitor redirect to home

    return render_template('index.html')


# route for handling visitor registration
# will handle GET and POST requests for sending html and recieving form data
@app.route('/visitorregistration', methods=['GET', 'POST'])
@auto.doc()
def registerVisitor():
    """Visitor registration route
       Requires: fname
                 lname
                 city
                 address
                 email
                 phone
        If registration is successful, will redirect to '/visitorhome'
    """
    # if the user is already logged in redirect to home
    if 'User_device_id' in session:
        return redirect('/visitorhome')

    if request.method == 'POST':
        cur = mysql.connection.cursor()

        # obtain form data from request object
        fname = request.form['fname']
        lname = request.form['lname']
        city = request.form['city']
        address = request.form['address']
        email = request.form['email']
        phone = request.form['phone']
        device_id = uuid.uuid4()  # generate unique identifier for user device

        if (fname == "" or lname == "" or city == "" or address == "" or email == "" or phone == ""):
            return render_template('visitor-registration.html'), 400

        # set user session object
        session['User_device_id'] = device_id

        command = f'INSERT INTO Visitor(fname, lname, city , address, phone_number, email, device_id) values("{fname}", "{lname}", "{city}", "{address}", {phone}, "{email}", "{device_id}")'

        # execute and commit sql command
        cur.execute(command)
        mysql.connection.commit()

        cur.close()

        # redirect to home upon finishing
        return redirect('/visitorhome')

    else:  # if the method was GET send html
        return render_template('visitor-registration.html')


# route for place owner registration which handles get and post requests

@app.route('/placeregistration', methods=['GET', 'POST'])
@auto.doc()
def registerPlace():
    """ Place owner registration route
        Requires:pname
                 address
                 email
                 phone
        If registration is successful, will redirect to '/placehome'
    """
    # if visitor is already registered redirect to home
    if 'Place_device_id' in session:
        return redirect('/placehome')

    if request.method == 'POST':
        cur = mysql.connection.cursor()

        # obtain form data from request object
        pname = request.form['pname']
        phone = request.form['phone']
        address = request.form['address']
        email = request.form['email']

        if (pname == "" or phone == "" or address == "" or email == ""):
            return render_template('place-registration.html'), 400

        # generate unique string for QRcode
        QRcode = uuid.uuid4()

        # set session with QRcode
        session['Place_device_id'] = QRcode

        command = f'INSERT INTO PlaceOwner(place_name, phone_no, email, address, QRcode) values("{pname}", {phone}, "{email}", "{address}", "{QRcode}" )'

        # execute and commit sql
        cur.execute(command)
        mysql.connection.commit()

        cur.close()

        return redirect('/placehome')

    else:  # if request was get send html
        return render_template('place-registration.html')

# route for handling agent login with username and password


@app.route('/agentlogin', methods=['GET', 'POST'])
@auto.doc()
def loginAgent():
    """ Agent login route
        Requires: agent_id
                  username
                  password
        If login is successful, will redirect to '/agenthome'
    """
    if 'Agent_id' in session:
        return redirect('/agenthome')
    if request.method == 'POST':

        # fetch form data from request
        agent_id = request.form['agent_id']
        username = request.form['username']
        password = request.form['password']

        # check if all required data was provided
        if (agent_id == "" or username == "" or password == ""):
            return render_template('agent-login.html'),  401

        cur = mysql.connection.cursor()

        # find agent specified by the id
        command = f'SELECT * from Agent WHERE agent_id={agent_id}'

        cur.execute(command)

        agent = cur.fetchall()
        if (len(agent) == 0):  # if no agent was found
            return redirect('/agentlogin'), 400

        else:
            # check username and password
            if (agent[0][1] == username and agent[0][2] == password):
                session['Agent_id'] = agent_id
                return render_template('agent-home.html')
            else:
                return render_template('agent-login.html'),  401
    else:
        return render_template('agent-login.html')


@app.route('/agenthome')
@auto.doc()
def agentHome():
    """ Agent home route
        Will be used to show Agent tools
    """
    if 'Agent_id' not in session:
        return redirect('/agentlogin')
    return render_template('agent-home.html')


@app.route('/hospitallogin', methods=['GET', 'POST'])
@auto.doc()
def loginHospital():
    """Hospital Login route, handles both get and post
       requirements: hospital_id
                     username
                     password
       If registration is successful, will redirect to '/hospitalhome
    """
    if 'Hospital_id' in session:
        return redirect('/hospitalhome')
    if request.method == 'POST':

        # fetch form data from request
        hospital_id = request.form['hospital_id']
        username = request.form['username']
        password = request.form['password']

        if (hospital_id == "" or username == "" or password == ""):
            return render_template('hospital-login.html'),  401

        cur = mysql.connection.cursor()

        command = f'SELECT * from Hospital WHERE hospital_id={hospital_id}'

        cur.execute(command)

        hospital = cur.fetchall()
        if (len(hospital) == 0):
            return redirect('/hospitallogin'), 400

        else:
            print(bcrypt.generate_password_hash(password))
            if (hospital[0][1] == username and hospital[0][2] == password):
                session['Hospital_id'] = hospital_id
                return redirect('/hospitalhome')
            else:
                return render_template('hospital-login.html'),  401
    else:
        return render_template('hospital-login.html')

# route for visitor home


@app.route('/hospitalhome')
@auto.doc()
def hospitalHome():
    """ Hospital home route
    """
    if 'Hospital_id' not in session:
        return redirect('/hospitallogin')
    return render_template('hospital-home.html')


@app.route('/visitorhome')
@auto.doc()
def visitorHome():
    """ Visitor home route
        Used to show visitor scan in 
    """
    # if visitor is not logged in, redirect to home
    if 'User_device_id' not in session:
        return redirect('/visitorregistration')
    return render_template('visitor-home.html')

# route for handling visitor signin to a place


@app.route('/place/<id>')
@auto.doc()
def visitorSignedIn(id):
    """ Visitor signed in route
        Used to get add the user to place
    """
    # if visitor is not logged in redirect to home
    if 'User_device_id' not in session:
        return redirect('/')

    cur = mysql.connection.cursor()
    # fetch place of name
    command = f'SELECT place_name FROM PlaceOwner WHERE QRcode="{str(id)}"'

    cur.execute(command)
    # obtain name from returened data
    record = cur.fetchall()[0][0]

    # send html with name as data
    return render_template('checked-in-place.html', data=record)

# route for handling place home, will show QRcode for place owner


@app.route('/placehome')
@auto.doc()
def placeHome():
    """ Place home route
        Used to show the place owner their QR
    """
    # if place owner is not logged in, redirect to home

    if 'Place_device_id' not in session:
        return redirect('/placeregistration')

    # fetch QRcode string from session
    data = session['Place_device_id']

    # select format of QR to generate
    factory = qrcode.image.svg.SvgImage

    # generate QRcode
    img = qrcode.make(data, image_factory=factory)

    # convert generated QRcode into html readable format
    stream = BytesIO()
    img.save(stream)
    svg = stream.getvalue().decode()

    # send html with the svg as data_svg
    return render_template('place-home.html', data_svg=svg)

# data routes

# route for handling visitor sign into place, implemented to handle AJAX requests


@app.route('/signin', methods=['POST'])
@auto.doc()
def signIn():
    """Sign in route
       requirements: time (signin)
                     qr
        Used to add record of user signin to database

    """
    if 'User_device_id' not in session:
        return redirect('/')

    cur = mysql.connection.cursor()

    # get time and qr from request object, needed to create a record
    time = request.form['time']
    qr = request.form['qrcode']
    device_id = session['User_device_id']

    # query string for finding whether a visitor has already signed into the place they are trying to sign into
    command = f'SELECT * FROM VisitorToPlace WHERE QRcode="{qr}" AND device_id="{device_id}" AND exit_time IS NULL'

    cur.execute(command)
    result = cur.fetchall()

    # if the visitor has not signed in
    if len(result) == 0:

        # string for creating new record, exit time is left NULL and updated later
        command = f'INSERT INTO VisitorToPlace(QRcode, device_id, entry_time) VALUES ("{qr}", "{device_id}","{time}")'
        cur.execute(command)
        mysql.connection.commit()

        cur.close()
        return time  # return entry time

    # if the visitor has already signed in
    else:
        # query for fetching entry time
        command = f'SELECT * FROM VisitorToPlace WHERE QRcode="{qr}" AND device_id="{device_id}" AND exit_time IS NULL'
        cur.execute(command)

        # extracting query time from query
        result = cur.fetchall()[0][2]

        cur.close()

        return str(result)  # return entry time

# route for handling user signout, implemented to handle AJAX request


@app.route('/signout', methods=['POST'])
@auto.doc()
def signOut():
    """ Sign out route
        Used to update database to reflect visitor signout 
    """
    # if user is not already logged in
    if 'User_device_id' not in session:
        return redirect('/')

    # obtain time and qr
    time = request.form['time']
    qr = request.form['qrcode']
    device_id = session['User_device_id']

    cur = mysql.connection.cursor()

    # query string for updating exit time of record identified by qr, devce and entry time
    command = f'UPDATE VisitorToPlace SET exit_time="{time}" WHERE QRcode="{qr}" AND device_id="{device_id}" AND exit_time is NULL'

    cur.execute(command)

    mysql.connection.commit()

    cur.close()

    return "Saved"  # return confirmation of signing out


@app.route('/docs')
def documentation():
    return auto.html(title='Beergame API Documentation')


@app.route('/logout')
def logout():
    """
        Used to logout any user
    """
    session.clear()
    return redirect('/')


if __name__ == "__main__":
    app.run(debug=True)

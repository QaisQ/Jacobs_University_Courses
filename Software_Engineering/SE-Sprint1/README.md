# Corona Archive Readme

Corona Archive is a system that allows for simple record of user movement 
that can be used for contact tracing.


### Contributors
#### Sprint 1
- Qais Qamhia
- Minyahel Haile

### Built with
```
- Python
- HTML
- CSS
- JavaScript
- MySQL
- Flask
```

### File structure
```
    \--se-02-team-15
        \--static
            \--css
            \--js
    \templates
        \--
    -- app.py
    -- sql_statements.sql
    -- README.md
    -- requirements.txt
    -- test.txt
    -- test-manualTesting.ods
    -- .gitignore

```

## Getting Started

These instructions are primarily specified for unix based systems
### Prereqquisites
- Mysql (both client and server)
    - If libbysqlclient-dev is missing you can install it with
    ```
        sudo apt-get install python-dev default-libmysqlclient-dev libssl-dev
    ```
- Virtualenv
- Latest version of pip or pip3 (important to get latest required packages)

### Installation Guide

```
    #clone the repo

    $ cd SE-Sprint01-Team27

    $ virtuaenv env

    $ source env/bin/activate

    $ pip3 install -r requirements.txt

    $ mysql -u {ENTER USERNAME WITH DATABASE PRIVELEGES} -p

    # Inside mysql

    mysql> source sql_statements.sql
    mysql> exit

    # update db.yaml with your own username and  password, if necessary you can also change the secret key used for bcrypt

    
    $ python3 app.py 
    # for further instructions such as port selection or lan 
    # wide availability use 
    #  FLASK_APP=app.py FLASK_ENV=development flask run --host=0.0.0.0 --port={DESIRED PORT NUMBER}


```
## Run tests
```
    $ python3 test.py
```

## Sprint1 Implemented
- [x] Created sql_statements that will initialize the database and create the required tables
- [x] Created the index, registration, and home pages for all users
- [x] Implemented login functionality for Admin and Hospital
- [x] Implemented Registration for visitor along with session tracking 
- [x] Implemented Registration for Place owner along with session tracking
- [x] Implemented QRcode generation and display functionality for Place owner 
- [x] Implemented QR code downloading for place owner
- [x] Implemented QRcode scanning for visitor 
- [x] Implemented database recording of visitor entry into a location
- [x] Implemented route protection for only verified users
- [x] Implemented tests for main web page loading and route protection
- [x] Implemented logout that clears sesssions
 
## Notable Issues and Tips
- If you setup flask for lan wide serving and check the service on your phone, the camera won't work as browser security policies require https to provide access to camera
- Best way to check if it works is:
    - Start flask lan wide (has to be same network) - might not work on eduroam! 
    - Register to app as placeowner from mobile device and obtain QRcode
    - Access app from serving laptop through localhost
    - Get access to camera and scan QR from laptop

- Adding admins and hospitals is only possible through mysql 
     - There are default accounts for both agent and hospital
        - id: 1, username: testname, password: testpassword
- The only way to check if users signed in and out at the moment is through mysql by directly observing the VisitorToPlace table
- Manual tests are writted in test-manualTesting.ods, can be opened through excel or libreoffice
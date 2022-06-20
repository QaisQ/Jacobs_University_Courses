# README

### Contributors

Sprint 1:
- Ujjwal khadka
- Julian Jeremiah Weske

Sprint 3:
- Suyash Thapa
- Diego Ricardo Zablah

Sprint 4:
- Qais Qamhia
- Hani Alnahas

### Built with
* HTML
* CSS
* [Python3](https://www.python.org/download/releases/3.0/)
* [VannilaJS](http://vanilla-js.com/)
* [Flask](https://www.fullstackpython.com/flask.html)
* [Sqlite3](https://www.sqlite.org/)



### Prerequisites
- Flask
- Sqlite3(The Vs code extension SQlite can be handy to visualize the tables.) 


### How To Run

1. Install `virtualenv`:
```
$ pip install virtualenv
```

2. Open a terminal in the project root directory and run:
```
$ virtualenv env
```

3. Then run the command:
```
$ source env/bin/activate
```

4. Then install the dependencies:
```
$ (env) pip install flask requests
```
5. Install additional dependencies:
```
$ (env)pip3 install -r requirements.txt
```
6. Finally start the web server:
```
$ (env) python3 app.py
```

This server will start on port 5000 by default. You can change this in `app.py` by changing the following line to this:

```python
if __name__ == "__main__":
    app.run(debug=True, port=<desired port>)
```

# Run tests
```
$ python3 test-1stSprint.py
```

## Sprint 1 Activity

✅  Visitors can registered

✅  Places can be registered

✅  Users are identified uniquelz by their citizen id. If not registered they have 
    to first register them in the service else they can use their citizen id to scan QR
    and their corresponding data is fetched from database.

✅  The visitor can fill in the form displayed to their screen by providing information such
    as enter their name, address, and city they live in.

✅  The visitor can choose whether to provide their contact number, email address, or both.

✅  After registering, the visitors are directed to the scanning page.

✅  Agent and hospitals must be able to log in.

✅  Agent shall be able to log in with the credentials given by us

✅  Authentication of a user on trying to log in to the system must be performed.

✅ The place owners must register with information about their place, such as name,
    address and a contact point, such as an email address or contact number.

✅ The place owners shall be given a QR code.

✅ QR code given to place owners shall be able to be downloaded.

## Sprint3 changes
- ✅ Added session keys to hospitals,visitors,agents and place  
- ✅ Hospitals shall now be able to look for visitors and there covid status(either infected or not)
- ✅ Hospitals could search a visitor by username
- ✅ Hospitals can also search a visitor by email
- ✅ Hospitals shall be able to search a visitor by citizen_id
- ✅ Hospitals shall be able to search a visitor by name
- ✅ Agents shall now be able to register hospitals 
- ✅ Agents shall now be able to access the hospitals in a table
- ✅ Agents shall be able to search hospitals by id
- ✅ Agents shall be able to search hospitals by Hospital name
- ✅ Agents also has a feature of arranging the hospital table in ascending and descending order
- ✅ Visitors can now scan the qr code
- ✅ Place can now a valid qr code and place would also be able to download the qrcode
- ✅ Added the requirements.txt files
- ✅ added more testcases 
- ✅ Moved the changed done in Sprint2 from Sprint2 folder
- ✅ Appended the changes done in Sprint2 to main branch
- ✅ Added logout features
- ✅ Added logoutfile for logout
- ✅ Added linker and linker2 page to link the visitor and place to log in after registration 

# Added requirements 
- qrcode7.3.1 to use qr code generation 
- Pillow9.1.0 to use display the qr code 

The changes done in Sprint2 had been stored in a sprint2 folder.In sprint3 the changes done in sprint2 was appended to the main branch and changes were done accordingly to Sprint2.Sprint 2 had very basic functionalites with no session keys, In sprint3 the more functionalites were added like the hospital table,the agent portal,valid qr code to places and a scanner for the visitors to scan qr code. 

## Sprint 4 Activity
- [X] Added visits table in the database.
- [X] Added username field in each table, with their respective data in the SQL file.
- [X] Visitors now have the ability to check in to places by scanning the QR code.
- [X] Visitors can check out of places.
- [X] A checked in visitor will be checked in accross all devices, and can't check in again unless they check out first.
- [X] An agent can get the immediate contact list of an infected person in the last 14 days under /getContacts/\<visitorID\>.
- [X] Updated the requirments file
- [X] Added the ability to get a visitor's history under /getVisitorHistory/\<visitorID\>/\<number_Of_Days\>
- [X] Added the ability to get a place's history under /getPlaceHistory/\<placeID\>/\<number_Of_Days\>
- [X] Documented the project
- [X] Added automatic documentation page under /docs
- [X] Added test cases
- [X] Fixed come of the old cases
- [X] File restructuring
- [X] Changed homepage design
- [X] Changed navigation bar design
- [X] Added the option to go back to homepage by clicking the name of the site
- [X] Changed user registration design
- [X] Changed place registration design
- [X] Changed visitor login design
- [X] Changed hospital login design
- [X] Changed agent login design
- [X] Updated design in qrpage


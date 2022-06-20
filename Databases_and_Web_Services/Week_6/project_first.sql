CREATE TABLE users(

    user_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    location VARCHAR(255),
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255)

);

--------------------------------------------------------------------------------------
INSERT INTO users (username, location, name, password, email, phone_number)
   VALUES("player_1", "Bremen", "gamer_1", "01", "player@gamer.com", "0123456789");

   
INSERT INTO users (username, location, name, password, email, phone_number)
   VALUES("player_2", "Berlin", "gamer_2", "02", "gamer@player.com", "9876543210");
--------------------------------------------------------------------------------------
DELETE FROM users WHERE user_id = 1;
--------------------------------------------------------------------------------------
UPDATE users
SET username = "1_player", location = "Frankfurt", name = "1_gamer", password = "01", email = "play@game.com", phone_number = "0246810"
WHERE user_id = 2; 
--------------------------------------------------------------------------------------

CREATE TABLE partner_organizations(

    organization_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    password INTEGER NOT NULL,
    phone_number INTEGER NOT NULL, 
    legal_certification BLOB NOT NULL,
    location VARCHAR(255) NOT NULL
    
);

--------------------------------------------------------------------------------------
INSERT INTO partner_organizations(organization_id, name, email, login_key, phone_number, legal_certification, location)
   VALUES(69, "ABC", "AB@C.com", "011", "12345", "CNDS", "Dresden");

INSERT INTO partner_organizations(organization_id, name, email, login_key, phone_number, legal_certification, location)
   VALUES(3, "UNICEF", "unicef_is_cool@C.com", "123124d12", "0963131242", "exists", "Bremen");
   
INSERT INTO partner_organizations(organization_id, name, email, login_key, phone_number, legal_certification, location)
   VALUES(2, "CBA", "CB@A.com", "110", "54321", "SDNC", "Dusseldorf");
--------------------------------------------------------------------------------------
DELETE FROM partner_organizations WHERE organization_id = 1;
--------------------------------------------------------------------------------------
UPDATE partner_organizations
SET organization_id = 2
WHERE name = "CBA"; 

UPDATE partner_organizations
SET location = "Cologne"
WHERE name = "CBA"; 
--------------------------------------------------------------------------------------


CREATE TABLE volunteering_opportunities(

    volunteering_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    organization_id INTEGER NOT NULL,
    category_id INTEGER NOT NULL,
    contact_number INTEGER NOT NULL, 
    location VARCHAR(255) NOT NULL,
    duration VARCHAR(255) NOT NULL,
    FOREIGN KEY (organization_id) REFERENCES partner_organizations(organization_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE CASCADE
);
---------------------------------------------------------------------------------------
CREATE TABLE fundraisers(
    fundraiser_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    organization_id INTEGER,
    login_key INTEGER NOT NULL,
    category_id INTEGER,
    contact_number INTEGER NOT NULL, 
    FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id) ON DELETE CASCADE,
    FOREIGN KEY(category_id) REFERENCES category(category_id) ON DELETE CASCADE
);


---------------------------------------------------------------------------------------

CREATE TABLE bank_details_users(
    bank_id INTEGER AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER,
    bank_name VARCHAR(255) NOT NULL,
    BIC VARCHAR(20) NOT NULL,
    IBAN VARCHAR(30) UNIQUE NOT NULL,
    payment_method VARCHAR(255),
    FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE

);

--------------------------------------------------------------------------------------
INSERT INTO bank_details_users(user_id, bank_id, bank_name, BIC, IBAN, payment_method)
   VALUES(2, 32, "Sparkasse", "321312432", "DE325435543543289721", "Paypal");

INSERT INTO bank_details_users(user_id, bank_id, bank_name, BIC, IBAN, payment_method)
   VALUES(3, 44, "Deutsche Bank", "98932133", "DE373243543289721", "Paypal");
   
INSERT INTO bank_details_users(user_id, bank_id, bank_name, BIC, IBAN, payment_method)
   VALUES(4, 54, "N26", "65454432", "DE373243544342421", "Bank Transfer");
--------------------------------------------------------------------------------------
DELETE FROM partner_organizations WHERE organization_id = 1;
--------------------------------------------------------------------------------------
UPDATE partner_organizations
SET name = "POP", email = "Frank@furt.com", login_key = "111", phone_number = "0122112", legal_certification = "GGGG", location = "Hamburg"
WHERE organization_id = 2; 
--------------------------------------------------------------------------------------

CREATE TABLE bank_details_partners(
    bank_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    organization_id INTEGER,
    
    bank_name VARCHAR(255) NOT NULL,
    BIC VARCHAR(20) NOT NULL,
    IBAN VARCHAR(20) UNIQUE NOT NULL,
    payment_method VARCHAR(255),
    FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id) ON DELETE CASCADE

);

--------------------------------------------------------------------------------------
INSERT INTO bank_details_partners(organization_id, bank_id, bank_name, BIC, IBAN, payment_method)
   VALUES(2, 1, "N26", "N26XX", "DE89 89..", "Card");

INSERT INTO bank_details_partners(organization_id, bank_id, bank_name, BIC, IBAN, payment_method)
   VALUES(69, 2, "Sparkasse", "4567" , "34567", "Card");
   
INSERT INTO bank_details_partners(organization_id, bank_id, bank_name, BIC, IBAN, payment_method)
   VALUES(3, 3, "Volksbank", "VolkXX", "DE69 69..", "Cheque");
--------------------------------------------------------------------------------------
DELETE FROM bank_details_partners WHERE organization_id = 1;
--------------------------------------------------------------------------------------
UPDATE bank_details_partners
SET bank_id = 2, bank_name = "N26", BIC = "XXN26", IBAN = "DE00 99...", payment_method = "Cheque",
WHERE organization_id = 2; 
--------------------------------------------------------------------------------------


CREATE TABLE feed(
    
    post_id INTEGER PRIMARY KEY,
    author_id INTEGER,
    content BLOB NOT NULL,
    caption VARCHAR(255),
    emergency_status VARCHAR(255),
    likes INTEGER,
    FOREIGN KEY(author_id) REFERENCES partner_organizations(organization_id) ON DELETE CASCADE

);


CREATE TABLE category(

    category_id INTEGER PRIMARY KEY,
    organization_id INTEGER NOT NULL,
    category_name VARCHAR(255),
    
    FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id) ON DELETE CASCADE

);

--------------------------------------------------------------------------------------
INSERT INTO category(category_id, organization_id, category_name)
   VALUES(1, 69, "Mental Health");

INSERT INTO category(category_id, organization_id, category_name)
   VALUES(2, 3, "Hunger");
   
INSERT INTO category(category_id, organization_id, category_name)
   VALUES(3, 2, "Death");
--------------------------------------------------------------------------------------
DELETE FROM category WHERE category_id = 1;
--------------------------------------------------------------------------------------
UPDATE category
SET category_id = 1, organization_id = 1, category_name = "Mental Health",
WHERE organization_id = 2; 
--------------------------------------------------------------------------------------


-- CREATE TABLE belongs_to(

--     category_id INTEGER,
--     organization_id VARCHAR(255),
--     FOREIGN KEY(category_id) REFERENCES Category(category_id),
--     FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id) ON DELETE CASCADE,
--     PRIMARY KEY(category_id, organization_id)
-- );


CREATE TABLE posts_to(

    post_id INTEGER,
    organization_id INTEGER,
    content VARCHAR(255),
    caption VARCHAR(255),
    emergency_status VARCHAR(255),
    FOREIGN KEY(post_id) REFERENCES feed(post_id),
    FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id),
    PRIMARY KEY(post_id)
    
);


CREATE TABLE looks_at(

    post_id INTEGER,
    user_id INTEGER,
    FOREIGN KEY(post_id) REFERENCES feed(post_id),
    FOREIGN KEY(user_id) REFERENCES users(user_id),
    PRIMARY KEY(post_id, user_id)
    
);


CREATE TABLE donates_to(

    donation_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    user_id INTEGER,
    organization_id INTEGER,
    amount INTEGER NOT NULL,
    FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id),
    FOREIGN KEY(user_id) REFERENCES users(user_id)
    
);


-----------------------------------




/*
MariaDB [group20]> SELECT * FROM users;
+---------+------------------+-----------+---------------+----------+----------------------+--------------+
| user_id | username         | location  | name          | password | email                | phone_number |
+---------+------------------+-----------+---------------+----------+----------------------+--------------+
|       2 | 1_player         | Frankfurt | 1_gamer       | 01       | play@game.com        | 0246810      |
|       3 | player_2         | Berlin    | gamer_2       | 02       | gamer@player.com     | 9876543210   |
|       4 | donator_334      | Berlin    | not_agamer_2  | 0232     | game66r@player.com   | 983242310    |
|       5 | JohnGreen69      | Berlin    | Johngreener_2 | 02143212 | johngreen@player.com | 98235231310  |
|       6 | HankGreenisOlder | Berlin    | Hank greener  | password | hankgreen@player.com | 98235231311  |
+---------+------------------+-----------+---------------+----------+----------------------+--------------+
5 rows in set (0.000 sec)

MariaDB [group20]> SELECT * FROM partner_organizations;
+-----------------+--------+------------------+-----------+--------------+---------------------+-------------+
| organization_id | name   | email            | login_key | phone_number | legal_certification | location    |
+-----------------+--------+------------------+-----------+--------------+---------------------+-------------+
|               2 | CBA    | CB@A.com         |       110 |        54321 | SDNC                | Düsseldorf  |
|               3 | UniCEF | unicef@gmail.com |     93423 |     13413241 | exists              | USA         |
|              69 | ABC    | AB@C.com         |        11 |        12345 | CNDS                | Dresden     |
+-----------------+--------+------------------+-----------+--------------+---------------------+-------------+
3 rows in set (0.000 sec)

MariaDB [group20]> SELECT * FROM category;
+-------------+-----------------+---------------+
| category_id | organization_id | category_name |
+-------------+-----------------+---------------+
|           1 |               2 | Mental Health |
|           2 |               3 | Hunger        |
|           3 |              69 | Death         |
+-------------+-----------------+---------------+
3 rows in set (0.000 sec)

MariaDB [group20]> SELECT * FROM bank_details_users;
+---------+---------+---------------+-----------+----------------------+----------------+
| user_id | bank_id | bank_name     | BIC       | IBAN                 | payment_method |
+---------+---------+---------------+-----------+----------------------+----------------+
|       2 |      32 | Sparkasse     | 321312432 | DE325435543543289721 | Paypal         |
|       3 |      44 | Deutsche Bank | 98932133  | DE373243543289721    | Paypal         |
|       4 |      54 | N26           | 65454432  | DE373243544342421    | Bank Transfer  |
+---------+---------+---------------+-----------+----------------------+----------------+
3 rows in set (0.000 sec)

MariaDB [group20]> SELECT * FROM bank_details_partners;
+-----------------+---------+-----------+--------+-----------+----------------+
| organization_id | bank_id | bank_name | BIC    | IBAN      | payment_method |
+-----------------+---------+-----------+--------+-----------+----------------+
|               2 |       1 | N26       | N26XX  | DE89 89.. | Card           |
|               3 |       3 | Volksbank | VolkXX | DE69 69.. | Cheque         |
|              69 |       2 | Sparkasse | 4567   | 34567     | Card           |
+-----------------+---------+-----------+--------+-----------+----------------+
3 rows in set (0.000 sec)

*/

--Template

SELECT DISTINCT *columnname* FROM *table*, *table* WHERE *columnname* = *stuff*;

1.) SELECT DISTINCT username FROM users, bank_details_users WHERE payment_method = "Paypal";
2.) SELECT DISTINCT email FROM partner_organizations, bank_details_partners WHERE bank_name = "N26";
3.) SELECT DISTINCT category_name FROM category, partner_organizations WHERE location = "Cologne";
4.) SELECT DISTINCT IBAN FROM bank_details_partners, partner_organizations WHERE legal_certification = "exists";



SELECT username, email, location FROM users WHERE username <> "player_2" GROUP BY location HAVING count(*) = 1

SELECT name FROM users WHERE user_id = MAX(user_id)
SELECT * FROM users  WHERE user_id > 3 GROUP BY location HAVING location = "Berlin"

SELECT * FROM bank_details_partners  WHERE organization_id <> 3 LIMIT 1;

SELECT username FROM bank_details_users, users WHERE bank_details_users.bank_name = "Sparkasse" AND location = "Berlin"

 SELECT DISTINCT name, location, bank_name, BIC, IBAN FROM 
 partner_organizations JOIN bank_details_partners ON
 bank_details_partners.organization_id = partner_organizations.organization_id 
 JOIN category ON category.organization_id = partner_organizations.organization_id 
 WHERE category_name = "Mental Health";
 
  SELECT DISTINCT name FROM 
 partner_organizations, category WHERE category_name = "Mental Health";





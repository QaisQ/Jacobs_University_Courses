CREATE TABLE visitors (
                citizen_id integer not null primary key,
                username text NOT NULL,
                visitor_name text not null,
                address text not null,
                phone_number integer default null,
                email text default null,
                device_id text not null UNIQUE,
                infected binary not null,
                password text not null,
                checked_in binary default 0
                );
CREATE TABLE places (
                place_id integer not null primary key,
                username text NOT NULL,
                place_name text not null,
                address text not null,
                qrcode text not null,
				password text not null
                );
CREATE TABLE agents (
                agent_id integer not null primary key,
                username text NOT NULL,
                email text not null,
                password text not null
                );
CREATE TABLE hospitals (
                hospital_id integer not null primary key,
                name text not null,
                password text not null
                );

CREATE TABLE Visits( 
                 visit_id integer PRIMARY KEY AUTOINCREMENT,
                 citizen_id integer NOT NULL,
                 place_id integer NOT NULL,
                 check_in_time text,
                 check_out_time text,
                 CONSTRAINT fk_visiting
                    FOREIGN KEY (citizen_id) 
                    REFERENCES visitors (citizen_id)
                    ON DELETE CASCADE
                    FOREIGN KEY (place_id) 
                    REFERENCES places (place_id)
                    ON DELETE CASCADE

             );
CREATE TABLE Users(

    username VARCHAR(255),
    Location VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    login_key INTEGER NOT NULL,
    email VARCHAR(255),
    phone_number VARCHAR(255),

    PRIMARY KEY(username)

);

CREATE TABLE Bank_Details_Users(

    bank_name VARCHAR(255),
    BIC INTEGER,
    IBAN INTEGER,
    payment_method VARCHAR(255)

);

CREATE TABLE feed(
    
    post_id INTEGER,
    author_id INTEGER,
    likes INTEGER,
    FOREIGN KEY(post_id, author_id)

);

CREATE TABLE partner_organizations(

    organization_id INTEGER,
    name VARCHAR(255),
    email VARCHAR(255),
    login_key INTEGER,
    phone_number INTEGER,
    legal_certification VARCHAR(255),
    location VARCHAR(255),

    PRIMARY KEY(organization_id)
    
);

CREATE TABLE Bank_Details_partners(

    bank_name VARCHAR(255),
    BIC INTEGER,
    IBAN INTEGER,
    payment_method VARCHAR(100)

);

CREATE TABLE Category(

    category_id integer,
    category_name VARCHAR(255),
    
    FOREIGN KEY(organization_id),
    PRIMARY KEY(category_id)

);

CREATE TABLE Post(

    post_id INTEGER,
    content VARCHAR(255),
    caption VARCHAR(255),
    emergency_status VARCHAR(255),

    PRIMARY KEY(post_id)
    
);

CREATE TABLE belongs_to(

    category_id INTEGER,
    organization_id VARCHAR(255),
    FOREIGN KEY(category_id) REFERENCES Category(category_id),
    FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id),
    PRIMARY KEY(category_id, organization_id)

);

CREATE TABLE posts_to(

    post_id INTEGER,
    organization_id INTEGER,
    content VARCHAR(255),
    caption VARCHAR(255),
    emergency_status VARCHAR(255),
    FOREIGN KEY(post_id) REFERENCES feed(post_id),
    FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id),
    PRIMARY KEY(post_id, organization_id)
    
);

CREATE TABLE looks_at(

    post_id INTEGER,
    author_id INTEGER,
    FOREIGN KEY(post_id) REFERENCES feed(post_id),
    FOREIGN KEY(author_id) REFERENCES feed(author_id),
    PRIMARY KEY(post_id, author_id)
    
);

CREATE TABLE donates_to(

    organization_id INTEGER,
    FOREIGN KEY(organization_id) REFERENCES partner_organizations(organization_id),
    PRIMARY KEY(organization_id)
    
);
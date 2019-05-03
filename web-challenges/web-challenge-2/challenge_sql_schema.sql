CREATE TABLE users (
    user_id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE credit_card (
    record_id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    ccnumber varchar(255) NOT NULL,
    PRIMARY KEY (record_id)
);
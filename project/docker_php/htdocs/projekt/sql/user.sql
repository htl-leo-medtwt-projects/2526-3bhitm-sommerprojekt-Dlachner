CREATE TABLE user (
    user_id INT NOT NULL AUTO_INCREMENT,
    vorname VARCHAR(50) NOT NULL,
    nachname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    passwort VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE warenkorb (
    warenkorb_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    menge INT NOT NULL DEFAULT 1,
    PRIMARY KEY (warenkorb_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE wunschliste (
    wunschliste_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    PRIMARY KEY (wunschliste_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE bestellung (
    bestellung_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    datum DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    gesamtpreis DECIMAL(10,2) NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'offen',
    PRIMARY KEY (bestellung_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE bestellung_position (
    position_id INT NOT NULL AUTO_INCREMENT,
    bestellung_id INT NOT NULL,
    product_id INT NOT NULL,
    menge INT NOT NULL,
    preis_damals DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (position_id),
    FOREIGN KEY (bestellung_id) REFERENCES bestellung(bestellung_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);
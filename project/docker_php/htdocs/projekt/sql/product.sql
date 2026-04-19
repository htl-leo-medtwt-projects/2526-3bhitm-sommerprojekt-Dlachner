CREATE DATABASE IF NOT EXISTS produkt_db;
USE produkt_db;

CREATE TABLE product (
    product_id INT NOT NULL AUTO_INCREMENT,
    beschreibung VARCHAR(200) NOT NULL,
    preis DECIMAL(10,2) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    kategorie VARCHAR(50) NOT NULL,
    PRIMARY KEY (product_id)
);

CREATE TABLE accessories (
    product_id INT NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE bearings (
    product_id INT NOT NULL,
    material VARCHAR(50) NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE deck (
    product_id INT NOT NULL,
    length DECIMAL(4,2) NOT NULL,
    width DECIMAL(4,2) NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE griptape (
    product_id INT NOT NULL,
    size INT NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE picture (
    pictureid INT NOT NULL AUTO_INCREMENT,
    bildpfad VARCHAR(100) NOT NULL,
    product_product_id INT NOT NULL,
    ismain CHAR(1) NOT NULL,
    PRIMARY KEY (pictureid),
    FOREIGN KEY (product_product_id) REFERENCES product(product_id)
);

CREATE TABLE trucks (
    product_id INT NOT NULL,
    height DECIMAL(4,2) NOT NULL,
    width DECIMAL(4,2) NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE wheels (
    product_id INT NOT NULL,
    width INT NOT NULL,
    durchmesser INT NOT NULL,
    typ VARCHAR(20) NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);
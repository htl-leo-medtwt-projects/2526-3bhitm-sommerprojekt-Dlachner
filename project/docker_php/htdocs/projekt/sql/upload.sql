-- Produkt 25
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Dragons 93A V4 Medium Ride 54mm Rollen',69.95, 'Powell_Peralta', 'wheels');

INSERT INTO deck (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 17, 54, '93A');
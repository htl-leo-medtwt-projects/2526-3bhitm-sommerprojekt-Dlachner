-- !! width ist lauffläche

-- Produkt 25       Bild: powellperalta1_1, powellperalta1_2
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Dragons 93A V4 Medium Ride 54mm Rollen',69.95, 'Powell_Peralta', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 17, 54, '93A');

-- Produkt 26       Bild: bonesWheels1_1
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('100s Originals V4 Wide 53mm Rollen',69.95, 'Bones_Wheels', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 21, 53, '100A');

-- Produkt 27       Bild: powellperalta2_1
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Dragons 93A V1 Narrow Ride 52mm Rollen',69.95, 'Powell_Peralta', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 14.5, 52, '93A');

-- Produkt 28       Bild: powellperalta3_1, powellperalta3_2
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Dragons 93A V6 Medium Ride 56mm Rollen',69.95, 'Powell_Peralta', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 17, 56, '93A');

-- Produkt 29       Bild: powellperalta4_1
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Dragons Nano Rat 93A AA2 Wide Ride 54mm Rollen',69.95, 'Powell_Peralta', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 18, 54, '93A');

-- Produkt 30       Bild: bonesWheels2_1, bonesWheels2_2, bonesWheels2_3
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Originals 100A V5 Sidecut 53mm Rollen',44.95, 'Bones_Wheels', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 17, 53, '100A');

-- Produkt 31       Bild: powellperalta5_1, powellperalta5_2
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Dragons 88A V6 Medium Ride 56mm Rollen',69.95, 'Powell_Peralta', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 17, 56, '88A');

-- Produkt 32       Bild: welcome1_1, welcome1_2
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Orbs Apparitions 53mm Rollen',34.95, 'Welcome', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 19, 53, '99A');

-- Produkt 33       Bild: spitfire1_1, spitfire1_2
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('X Thrasher Classic Flame F499 52mm Rollen',74.95, 'Spitfire', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 16, 52, '99A');

-- Produkt 34       Bild: welcome2_1, welcome2_2, welcome2_3
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Orbs Specters Swirls 99A 56mm Rollen',34.95, 'Welcome', 'wheels');

INSERT INTO wheels (product_id, width, durchmesser, typ) VALUES
(LAST_INSERT_ID(), 20, 56, '99A');


-- Produkt 1
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Brand Logo 8.5" Skateboard Deck', 94.95, 'Baker', 'deck');

INSERT INTO deck (product_id, width, length) VALUES
(LAST_INSERT_ID(), 8.5, 32);

-- Produkt 3
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Razor Dot 8.25″ Skateboard Deck', 74.95, 'Santa_Cruz', 'deck');

INSERT INTO deck (product_id, width, length) VALUES
(LAST_INSERT_ID(), 8.25, 31.8);

-- Produkt 4
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Cut Collage 8.5″ Skateboard Deck', 74.95, 'Santa_Cruz', 'deck');

INSERT INTO deck (product_id, width, length) VALUES
(LAST_INSERT_ID(), 8.5, 32.2);

-- Produkt 5
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Hawk Spiral 8″ Skateboard Deck', 64.95, 'Birdhouse', 'deck');

INSERT INTO deck (product_id, width, length) VALUES
(LAST_INSERT_ID(), 8, 31.5);

-- Produkt 6
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Team Logo 8.25″ Skateboard Deck', 59.95, 'Birdhouse', 'deck');

INSERT INTO deck (product_id, width, length) VALUES
(LAST_INSERT_ID(), 8.25, 32.0);

-- Produkt 7
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Crowded Hand 8.5″ Skateboard Deck', 89.95, 'Santa_Cruz', 'deck');

INSERT INTO deck (product_id, width, length) VALUES
(LAST_INSERT_ID(), 8.5, 32.2);

-- Produkt 8
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Heavens (Gold Foil) 8.5″ Skateboard Deck', 89.95, 'DGK', 'deck');

INSERT INTO deck (product_id, width, length) VALUES
(LAST_INSERT_ID(), 8.5, 32.2);

-- Produkt 9
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Spellcaster Mazzari 8.38″ Skateboard Deck', 89.95, 'DGK', 'deck');

INSERT INTO deck (product_id, width, length) VALUES
(LAST_INSERT_ID(), 8.38, 32);
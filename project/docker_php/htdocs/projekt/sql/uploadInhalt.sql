-- 1. Produkt eintragen
INSERT INTO product (beschreibung, preis, brand, kategorie) VALUES
('Brand Logo 8.5" Skateboard Deck', 94.95, 'Baker', 'deck');

-- 2. Deck-Details eintragen (product_id = 1, da erstes Produkt)
INSERT INTO deck (product_id, width, length) VALUES
(1, 8.5, 32);

INSERT INTO picture (bildpfad, product_product_id, ismain) VALUES
('images/decks/baker_front.webp', 1, '1'),
('images/decks/baker_back.webp', 1, '0'),
('images/decks/baker_side.webp', 1, '0');
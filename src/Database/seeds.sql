INSERT INTO market.product_type(name, tax_percentage)
VALUES	('CARNES', 15),
		('CONGELADOS', 4.2),
		('DOCES', 7.5),
		('FRIOS', 2.5),
		('FRUTAS', 5),
		('LEGUMES', 5),
		('MASSAS', 10);

INSERT INTO market.product(description, product_type_id, brand, price, quantity, ean, entry_date, due_date)
VALUES	('Alcatra Friboi 1Kg', 1, 'JBS', 50.49, 10, '123456789101', CURRENT_DATE, CURRENT_DATE + 15),
		('Linguiça Sadia 1 pacote', 2, 'Sadia', 20, 5, '123456789102', CURRENT_DATE, CURRENT_DATE  + 30),
		('Pé de Moleque 1 unidade', 3, 'Nestlé', 1.50, 100, '123456789103', CURRENT_DATE, CURRENT_DATE + 60),
		('Apresuntado Seara 1 peça', 4, 'Seara', 25.99, 10, '123456789104', CURRENT_DATE, CURRENT_DATE + 30),
		('Maça Turma da Mônica', 5, 'Turma da Mônica', 8, 12, '123456789105', CURRENT_DATE, CURRENT_DATE + 30),
		('Chuchu 1 unidade', 6, 'Quitanda', 4, 50, '123456789106', CURRENT_DATE, CURRENT_DATE + 15),
		('Macarrão Espaguete Renata 1 pacote', 7, 'Renata', 7.50, 10, '123456789107', CURRENT_DATE, CURRENT_DATE + 30);

INSERT INTO market.product_sell(product_id, price, sold_amount)
VALUES	(1, 50.49, 3),
		(2, 20, 2),
		(4, 25.99, 5),
		(7, 7.50, 9);

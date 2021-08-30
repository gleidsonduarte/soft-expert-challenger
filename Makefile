SHELL := /bin/bash

.PHONY: up down list php postgresql

up:	docker-compose.yaml
	@docker-compose up -d --build

# Destroy all containers in this projetc.
down: docker-compose.yaml
	@docker-compose down

# List all containers in this projetc.
ps:
	@docker-compose ps

test-unit:
	@vendor/bin/phpunit --group=unit_tests

# Access the PHP container.
php: docker-compose.yaml
	@docker exec -it softexpert-market-php /bin/bash

# Access the PostgreSQL container.
postgre:
	@docker exec -it softexpert-market-postgre psql -d softexpert_market -U gleidson -w market@123456

# Compile SCSS files to single CSS.
sass:
	@sass --watch src/View/css/main.scss src/View/css/main.css
CREATE SCHEMA IF NOT EXISTS market;

CREATE TABLE IF NOT EXISTS market.product_type (
    product_type_id SERIAL      NOT NULL,
    name            VARCHAR(50) NOT NULL,
    tax_percentage  DECIMAL     NOT NULL,
    CONSTRAINT product_type_pk PRIMARY KEY (product_type_id)
);

CREATE TABLE IF NOT EXISTS market.product (
    product_id      SERIAL      NOT NULL,
    description     VARCHAR(50) NOT NULL,
    product_type_id INT         NOT NULL,
    brand           VARCHAR(50) NOT NULL,
    price           DECIMAL     NOT NULL,
    quantity        INT         NOT NULL,
    ean             VARCHAR(13) NOT NULL,
    entry_date      DATE        NOT NULL,
    due_date        DATE        NOT NULL,
    CONSTRAINT product_pk PRIMARY KEY (product_id),
    CONSTRAINT product_type_fk
        FOREIGN KEY (product_type_id)
            REFERENCES market.product_type (product_type_id)
);

CREATE TABLE IF NOT EXISTS market.product_sell (
    product_sell_id SERIAL      NOT NULL,
    product_id      INT         NOT NULL,
    price           DECIMAL     NOT NULL,
    sold_amount     INT         NOT NULL,
    CONSTRAINT product_sell_pk PRIMARY KEY (product_sell_id),
    CONSTRAINT product_fk
        FOREIGN KEY (product_id)
            REFERENCES market.product (product_id)
);

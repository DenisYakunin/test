CREATE TABLE customers (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    inn VARCHAR(12) NOT NULL,
    kpp VARCHAR(9) NOT NULL
);

CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    code VARCHAR(10) NOT NULL,
    price VARCHAR(10) NOT NULL,
    name VARCHAR(64) NOT NULL,
    description VARCHAR(300)
);

CREATE TABLE customers2products (
    id SERIAL PRIMARY KEY,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    status INT NOT NULL,
    amount_available INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(customer_id, product_id)
);
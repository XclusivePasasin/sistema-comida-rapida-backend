CREATE DATABASE fast_food;

USE fast_food;

CREATE TABLE categories (
    id_category INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50)
);

CREATE TABLE dishes (
    id_dish INT PRIMARY KEY AUTO_INCREMENT,
    dish_name VARCHAR(50),
    price FLOAT,
    description VARCHAR(255),
    id_category INT,
    FOREIGN KEY (id_category) REFERENCES categories(id_category)
);

CREATE TABLE customers (
    dui VARCHAR(10) PRIMARY KEY,
    first_name VARCHAR(70),
    last_name VARCHAR(70),
    address VARCHAR(255),
    phone VARCHAR(8)
);

CREATE TABLE tables (
    id_table INT PRIMARY KEY AUTO_INCREMENT,
    table_number VARCHAR(4)
);

CREATE TABLE users (
    id_user INT PRIMARY KEY AUTO_INCREMENT, 
    password VARCHAR(255),
    role VARCHAR(1),
    username VARCHAR(15),
    employee_name VARCHAR(70),
    phone VARCHAR(8)
);


CREATE TABLE `orders` (
    id_order INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    order_date DATETIME,
    customer_dui VARCHAR(10),
    id_table INT,
    status VARCHAR(1),
    total FLOAT,
    payment_method VARCHAR(40),
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (customer_dui) REFERENCES customers(dui),
    FOREIGN KEY (id_table) REFERENCES tables(id_table)
);

CREATE TABLE order_details (
    id_order_detail INT PRIMARY KEY AUTO_INCREMENT,
    id_dish INT,
    id_order INT,
    quantity INT,
    subtotal FLOAT,
    FOREIGN KEY (id_dish) REFERENCES dishes(id_dish),
    FOREIGN KEY (id_order) REFERENCES `orders`(id_order)
);

INSERT INTO users (password, role, username, employee_name, phone) 
VALUES (
    'demo',  
    'A',          
    'Administrador',   
    'Fast Food',  
    '77777777'   
);
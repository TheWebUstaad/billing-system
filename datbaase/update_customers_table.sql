-- Create customers table
CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) UNIQUE,
    email VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Modify bills table to reference customers
ALTER TABLE bills
    DROP COLUMN customer_name,
    DROP COLUMN customer_phone,
    ADD COLUMN customer_id INT NOT NULL AFTER bill_number,
    ADD FOREIGN KEY (customer_id) REFERENCES customers(id); 
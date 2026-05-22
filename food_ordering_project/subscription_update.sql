CREATE TABLE Subscription (
    subscription_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    plan_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Active',
    CONSTRAINT fk_subscription_customer
        FOREIGN KEY (customer_id) REFERENCES Customer(customer_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO Subscription (customer_id, plan_name, price, start_date, end_date, status)
VALUES
    (1, 'Monthly', 199.00, '2026-04-01', '2026-04-30', 'Active');

INSERT INTO Subscription (customer_id, plan_name, price, start_date, end_date, status)
VALUES
    (1, 'Premium Monthly', 499.00, '2026-05-01', '2026-05-30', 'Active');

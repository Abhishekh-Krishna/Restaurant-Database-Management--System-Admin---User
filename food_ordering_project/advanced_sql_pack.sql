-- advanced_sql_pack.sql
-- Taste of India advanced SQL backend pack
-- Database: smart_food_ordering
-- Compatible with XAMPP / phpMyAdmin / MySQL Workbench

USE smart_food_ordering;
SET NAMES utf8mb4;

-- =========================================================
-- 1. USEFUL SELECT QUERIES
-- =========================================================

-- Query 1: View all customers
SELECT
    customer_id,
    full_name,
    email,
    phone,
    address
FROM Customer
ORDER BY customer_id;

-- Query 2: View all Taste of India outlets
SELECT
    restaurant_id AS outlet_id,
    restaurant_name AS outlet_name,
    owner_name AS outlet_manager,
    email,
    phone,
    address
FROM Restaurant
ORDER BY restaurant_id;

-- Query 3: View menu items with category and outlet details
SELECT
    m.menu_item_id,
    m.item_name,
    c.category_name,
    r.restaurant_name AS outlet_name,
    m.price,
    CASE
        WHEN m.is_available = 1 THEN 'Available'
        ELSE 'Not Available'
    END AS availability
FROM Menu_Item m
INNER JOIN Category c ON m.category_id = c.category_id
INNER JOIN Restaurant r ON m.restaurant_id = r.restaurant_id
ORDER BY c.category_name, m.item_name;

-- Query 4: View orders with customer and outlet names
SELECT
    o.order_id,
    c.full_name AS customer_name,
    r.restaurant_name AS outlet_name,
    o.order_date,
    o.order_type,
    o.total_amount,
    o.order_status
FROM Orders o
INNER JOIN Customer c ON o.customer_id = c.customer_id
INNER JOIN Restaurant r ON o.restaurant_id = r.restaurant_id
ORDER BY o.order_date DESC;

-- Query 5: View payment records with order and customer details
SELECT
    p.payment_id,
    p.order_id,
    c.full_name AS customer_name,
    p.payment_date,
    p.amount_paid,
    p.payment_method,
    p.payment_status
FROM Payment p
INNER JOIN Orders o ON p.order_id = o.order_id
INNER JOIN Customer c ON o.customer_id = c.customer_id
ORDER BY p.payment_date DESC;

-- Query 6: View subscription status for all customers
SELECT
    c.customer_id,
    c.full_name,
    c.email,
    s.plan_name,
    s.price,
    s.start_date,
    s.end_date,
    CASE
        WHEN s.subscription_id IS NOT NULL
             AND s.status = 'Active'
             AND s.end_date >= CURDATE()
        THEN 'Subscribed'
        ELSE 'Not Subscribed'
    END AS subscription_status
FROM Customer c
LEFT JOIN Subscription s ON c.customer_id = s.customer_id
ORDER BY c.customer_id, s.subscription_id DESC;

-- Query 7: Outlet-wise menu item count
SELECT
    r.restaurant_id AS outlet_id,
    r.restaurant_name AS outlet_name,
    COUNT(m.menu_item_id) AS total_menu_items
FROM Restaurant r
LEFT JOIN Menu_Item m ON r.restaurant_id = m.restaurant_id
GROUP BY r.restaurant_id, r.restaurant_name
ORDER BY r.restaurant_id;

-- Query 8: Total paid revenue
SELECT
    IFNULL(SUM(amount_paid), 0) AS total_paid_revenue
FROM Payment
WHERE payment_status = 'Paid';

-- Query 9: Revenue by outlet
SELECT
    r.restaurant_id AS outlet_id,
    r.restaurant_name AS outlet_name,
    IFNULL(SUM(p.amount_paid), 0) AS paid_revenue
FROM Restaurant r
LEFT JOIN Orders o ON r.restaurant_id = o.restaurant_id
LEFT JOIN Payment p ON o.order_id = p.order_id AND p.payment_status = 'Paid'
GROUP BY r.restaurant_id, r.restaurant_name
ORDER BY paid_revenue DESC;

-- Query 10: Most ordered regular menu items
SELECT
    m.menu_item_id,
    m.item_name,
    SUM(od.quantity) AS total_quantity_ordered,
    SUM(od.quantity * od.unit_price) AS item_revenue
FROM Order_Details od
INNER JOIN Menu_Item m ON od.menu_item_id = m.menu_item_id
GROUP BY m.menu_item_id, m.item_name
ORDER BY total_quantity_ordered DESC, item_revenue DESC;

-- =========================================================
-- 2. NESTED QUERIES
-- =========================================================

-- Nested Query 1: Customers who spent more than the average customer spend
SELECT
    c.customer_id,
    c.full_name,
    SUM(o.total_amount) AS customer_total_spent
FROM Customer c
INNER JOIN Orders o ON c.customer_id = o.customer_id
GROUP BY c.customer_id, c.full_name
HAVING SUM(o.total_amount) > (
    SELECT AVG(customer_total)
    FROM (
        SELECT SUM(total_amount) AS customer_total
        FROM Orders
        GROUP BY customer_id
    ) AS customer_totals
);

-- Nested Query 2: Menu items priced above the overall average menu price
SELECT
    menu_item_id,
    item_name,
    price
FROM Menu_Item
WHERE price > (
    SELECT AVG(price)
    FROM Menu_Item
)
ORDER BY price DESC;

-- =========================================================
-- 3. CORRELATED QUERIES
-- =========================================================

-- Correlated Query 1: Customers with their individual order count
SELECT
    c.customer_id,
    c.full_name,
    (
        SELECT COUNT(*)
        FROM Orders o
        WHERE o.customer_id = c.customer_id
    ) AS total_orders
FROM Customer c
ORDER BY c.customer_id;

-- Correlated Query 2: Outlets with their latest order date
SELECT
    r.restaurant_id AS outlet_id,
    r.restaurant_name AS outlet_name,
    (
        SELECT MAX(o.order_date)
        FROM Orders o
        WHERE o.restaurant_id = r.restaurant_id
    ) AS latest_order_date
FROM Restaurant r
ORDER BY r.restaurant_id;

-- =========================================================
-- 4. FUNCTIONS
-- =========================================================

DROP FUNCTION IF EXISTS fn_customer_total_spent;
DROP FUNCTION IF EXISTS fn_is_active_subscriber;

DELIMITER $$

CREATE FUNCTION fn_customer_total_spent(p_customer_id INT)
RETURNS DECIMAL(10,2)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_total DECIMAL(10,2);

    SELECT IFNULL(SUM(total_amount), 0)
    INTO v_total
    FROM Orders
    WHERE customer_id = p_customer_id;

    RETURN v_total;
END $$

-- Test example:
-- SELECT fn_customer_total_spent(1) AS total_spent;

CREATE FUNCTION fn_is_active_subscriber(p_customer_id INT)
RETURNS VARCHAR(3)
NOT DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_count INT;

    SELECT COUNT(*)
    INTO v_count
    FROM Subscription
    WHERE customer_id = p_customer_id
      AND status = 'Active'
      AND end_date >= CURDATE();

    IF v_count > 0 THEN
        RETURN 'Yes';
    ELSE
        RETURN 'No';
    END IF;
END $$

-- Test example:
-- SELECT fn_is_active_subscriber(1) AS is_subscriber;

DELIMITER ;

-- =========================================================
-- 5. PROCEDURES
-- =========================================================

DROP PROCEDURE IF EXISTS sp_get_customer_order_history;
DROP PROCEDURE IF EXISTS sp_get_outlet_menu;

DELIMITER $$

CREATE PROCEDURE sp_get_customer_order_history(IN p_customer_id INT)
BEGIN
    SELECT
        o.order_id,
        o.order_date,
        r.restaurant_name AS outlet_name,
        o.order_type,
        o.total_amount,
        o.order_status,
        p.payment_method,
        p.payment_status
    FROM Orders o
    INNER JOIN Restaurant r ON o.restaurant_id = r.restaurant_id
    LEFT JOIN Payment p ON o.order_id = p.order_id
    WHERE o.customer_id = p_customer_id
    ORDER BY o.order_date DESC;
END $$

-- Test example:
-- CALL sp_get_customer_order_history(1);

CREATE PROCEDURE sp_get_outlet_menu(IN p_outlet_id INT)
BEGIN
    SELECT
        m.menu_item_id,
        m.item_name,
        c.category_name,
        m.description,
        m.price,
        CASE
            WHEN m.is_available = 1 THEN 'Available'
            ELSE 'Not Available'
        END AS availability
    FROM Menu_Item m
    INNER JOIN Category c ON m.category_id = c.category_id
    WHERE m.restaurant_id = p_outlet_id
    ORDER BY c.category_name, m.item_name;
END $$

-- Test example:
-- CALL sp_get_outlet_menu(1);

DELIMITER ;

-- =========================================================
-- 6. WEBSITE-TESTABLE TRIGGERS
-- =========================================================

DROP TRIGGER IF EXISTS trg_orders_before_insert_defaults;
DROP TRIGGER IF EXISTS trg_payment_before_insert_defaults;
DROP TRIGGER IF EXISTS trg_subscription_before_insert_defaults;

DELIMITER $$

CREATE TRIGGER trg_orders_before_insert_defaults
BEFORE INSERT ON Orders
FOR EACH ROW
BEGIN
    IF NEW.order_date IS NULL THEN
        SET NEW.order_date = NOW();
    END IF;

    IF NEW.order_status IS NULL OR NEW.order_status = '' THEN
        SET NEW.order_status = 'Pending';
    END IF;
END $$

-- Test example:
-- checkout.php inserts into Orders during normal checkout.
-- Manual test: INSERT INTO Orders (customer_id, restaurant_id, order_date, order_type, total_amount, order_status)
-- VALUES (1, 1, NULL, 'Regular', 250.00, NULL);

CREATE TRIGGER trg_payment_before_insert_defaults
BEFORE INSERT ON Payment
FOR EACH ROW
BEGIN
    IF NEW.payment_date IS NULL THEN
        SET NEW.payment_date = NOW();
    END IF;

    IF NEW.payment_status IS NULL OR NEW.payment_status = '' THEN
        SET NEW.payment_status = 'Paid';
    END IF;
END $$

-- Test example:
-- checkout.php inserts into Payment after an order is placed.
-- Manual test: INSERT INTO Payment (order_id, payment_date, amount_paid, payment_method, payment_status)
-- VALUES (1, NULL, 250.00, 'UPI', NULL);

CREATE TRIGGER trg_subscription_before_insert_defaults
BEFORE INSERT ON Subscription
FOR EACH ROW
BEGIN
    IF NEW.start_date IS NULL THEN
        SET NEW.start_date = CURDATE();
    END IF;

    IF NEW.end_date IS NULL THEN
        SET NEW.end_date = DATE_ADD(NEW.start_date, INTERVAL 30 DAY);
    END IF;

    IF NEW.status IS NULL OR NEW.status = '' THEN
        SET NEW.status = 'Active';
    END IF;
END $$

-- Test example:
-- subscription_checkout.php or the subscription flow inserts into Subscription after payment.
-- Manual test: INSERT INTO Subscription (customer_id, plan_name, price, start_date, end_date, status)
-- VALUES (1, 'Monthly', 199.00, CURDATE(), NULL, NULL);

DELIMITER ;

-- =========================================================
-- HOW TO TEST USING WEBSITE
-- =========================================================

-- 1. Customer registration/login flow:
--    Use register.php and login.php to create and enter a customer account.

-- 2. Outlet and menu flow:
--    Open restaurants.php, choose an outlet, then open menu.php to add menu items to the session cart.

-- 3. Checkout trigger testing:
--    checkout.php creates rows in Orders and Payment.
--    The Orders trigger can auto-fill order_date/order_status if missing.
--    The Payment trigger can auto-fill payment_date/payment_status if missing.

-- 4. Order review:
--    Open my_orders.php after checkout to confirm the new order appears for the logged-in customer.

-- 5. Subscription trigger testing:
--    subscription_checkout.php, or the active subscription payment flow, creates rows in Subscription.
--    The Subscription trigger can auto-fill start_date, end_date, and status when they are missing.

-- 6. Admin review:
--    Use admin/orders.php, admin/payments.php, and admin/subscriptions.php to review order, payment, and subscription records.

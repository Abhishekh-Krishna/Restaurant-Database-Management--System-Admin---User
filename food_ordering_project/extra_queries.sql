USE smart_food_ordering;

SELECT c.customer_id, c.full_name
FROM Customer c
WHERE c.customer_id IN (
    SELECT o.customer_id
    FROM Orders o
    GROUP BY o.customer_id
    HAVING SUM(o.total_amount) > (
        SELECT AVG(customer_total)
        FROM (
            SELECT SUM(total_amount) AS customer_total
            FROM Orders
            GROUP BY customer_id
        ) AS avg_table
    )
);

SELECT m.menu_item_id, m.item_name, m.restaurant_id, m.price
FROM Menu_Item m
WHERE m.price > (
    SELECT AVG(m2.price)
    FROM Menu_Item m2
    WHERE m2.restaurant_id = m.restaurant_id
);

DELIMITER $$

CREATE FUNCTION fn_total_customer_spent(customerId INT)
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE total_spent DECIMAL(10,2);

    SELECT IFNULL(SUM(total_amount), 0)
    INTO total_spent
    FROM Orders
    WHERE customer_id = customerId;

    RETURN total_spent;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE sp_update_order_status(IN orderId INT, IN newStatus VARCHAR(20))
BEGIN
    UPDATE Orders
    SET order_status = newStatus
    WHERE order_id = orderId;
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER trg_reduce_surplus_quantity
AFTER INSERT ON Order_Details
FOR EACH ROW
BEGIN
    IF NEW.surplus_item_id IS NOT NULL THEN
        UPDATE Surplus_Item
        SET quantity_available = quantity_available - NEW.quantity
        WHERE surplus_item_id = NEW.surplus_item_id;
    END IF;
END $$

DELIMITER ;

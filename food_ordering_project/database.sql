-- Taste of India - Outlet Ordering and Surplus Meal Management System
-- Beginner-friendly MySQL database schema

CREATE DATABASE IF NOT EXISTS smart_food_ordering CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE smart_food_ordering;
SET NAMES utf8mb4;

-- Remove old tables first so the script can be re-run easily
DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS Order_Details;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Surplus_Item;
DROP TABLE IF EXISTS Menu_Item;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS Admin;


CREATE TABLE Admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20)
);


CREATE TABLE Customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255)
);


CREATE TABLE Restaurant (
    restaurant_id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_name VARCHAR(100) NOT NULL,
    owner_name VARCHAR(100),
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address VARCHAR(255),
    INDEX idx_restaurant_name (restaurant_name)
);


CREATE TABLE Category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    category_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (restaurant_id) REFERENCES Restaurant(restaurant_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Menu_Item (
    menu_item_id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    category_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    description VARCHAR(255),
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(500) NOT NULL DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg',
    is_available TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (restaurant_id) REFERENCES Restaurant(restaurant_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Category(category_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Surplus_Item (
    surplus_item_id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity_available INT NOT NULL,
    surplus_price DECIMAL(10,2) NOT NULL,
    available_until DATETIME NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Available',
    FOREIGN KEY (restaurant_id) REFERENCES Restaurant(restaurant_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES Menu_Item(menu_item_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    restaurant_id INT NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    order_type VARCHAR(20) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    order_status VARCHAR(20) NOT NULL DEFAULT 'Pending',
    INDEX idx_orders_customer_id (customer_id),
    INDEX idx_orders_restaurant_id (restaurant_id),
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (restaurant_id) REFERENCES Restaurant(restaurant_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Order_Details (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NULL,
    surplus_item_id INT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    CHECK (
        (menu_item_id IS NOT NULL AND surplus_item_id IS NULL) OR
        (menu_item_id IS NULL AND surplus_item_id IS NOT NULL)
    ),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES Menu_Item(menu_item_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (surplus_item_id) REFERENCES Surplus_Item(surplus_item_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);


CREATE TABLE Payment (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL UNIQUE,
    payment_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    amount_paid DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_status VARCHAR(20) NOT NULL DEFAULT 'Paid',
    INDEX idx_payment_order_id (order_id),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


-- Sample data for Admin
INSERT INTO Admin (full_name, email, password, phone) VALUES
('System Admin', 'admin@smartfood.com', 'admin123', '9876543210');


-- Sample data for Customer
INSERT INTO Customer (full_name, email, password, phone, address) VALUES
('Amit Sharma', 'amit@gmail.com', 'amit123', '9123456780', 'Kolkata'),
('Priya Das', 'priya@gmail.com', 'priya123', '9234567890', 'Howrah');


-- Sample data for Restaurant table used as Taste of India outlets
INSERT INTO Restaurant (restaurant_name, owner_name, email, phone, address) VALUES
('Taste of India - Park Street Outlet', 'Rakesh Gupta', 'parkstreet@tasteofindia.com', '9345678901', '18A Park Street, Kolkata, West Bengal 700071'),
('Taste of India - Salt Lake Outlet', 'Sneha Roy', 'saltlake@tasteofindia.com', '9456789012', 'City Centre 1, DC Block, Sector I, Bidhannagar, Kolkata, West Bengal 700064'),
('Taste of India - Gariahat Outlet', 'Arindam Sen', 'gariahat@tasteofindia.com', '9567890123', '45A Gariahat Road, Ballygunge, Kolkata, West Bengal 700019');


-- Sample data for Category
INSERT INTO Category (restaurant_id, category_name) VALUES
(1, 'Starters'),
(1, 'Main Course'),
(1, 'Breads'),
(1, 'Rice & Biryani'),
(1, 'Desserts'),
(1, 'Beverages');


-- Sample data for Menu_Item
INSERT INTO Menu_Item (restaurant_id, category_id, item_name, description, price, image_url, is_available) VALUES
(1, 1, 'Paneer Tikka', 'Char-grilled paneer cubes marinated with yogurt and Indian spices.', 220.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Hara Bhara Kebab', 'Spinach, peas, and potato kebabs cooked until crisp and golden.', 180.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Chicken Tikka', 'Boneless chicken pieces roasted in a smoky tandoori marinade.', 240.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Veg Spring Roll', 'Crisp rolls filled with spiced vegetables and served with chutney.', 160.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Aloo Tikki Chaat', 'Potato patties topped with yogurt, chutneys, and crunchy sev.', 150.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Fish Amritsari', 'Punjabi-style fish fritters with ajwain, gram flour, and lime.', 260.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Tandoori Mushroom', 'Juicy mushrooms tossed in tandoori masala and roasted hot.', 190.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Crispy Corn Pepper', 'Crunchy corn kernels tossed with pepper, onion, and spices.', 170.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Seekh Kebab', 'Minced meat kebabs seasoned with herbs and grilled on skewers.', 250.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 1, 'Masala Papad', 'Roasted papad topped with onion, tomato, coriander, and spices.', 90.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg', 1),
(1, 2, 'Butter Chicken', 'Tender chicken simmered in rich tomato, butter, and cream gravy.', 320.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Paneer Butter Masala', 'Paneer cubes cooked in creamy tomato gravy with mild spices.', 260.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Dal Makhani', 'Slow-cooked black lentils finished with butter and cream.', 220.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Kadai Paneer', 'Paneer tossed with peppers, onion, and kadai masala.', 250.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Chicken Curry', 'Homestyle chicken curry cooked with onions, tomato, and spices.', 300.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Chana Masala', 'Chickpeas cooked in a tangy North Indian masala.', 210.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Mutton Rogan Josh', 'Kashmiri-style mutton curry with aromatic spices.', 420.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Malai Kofta', 'Soft kofta dumplings served in a creamy cashew gravy.', 270.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Veg Kolhapuri', 'Mixed vegetables cooked in a bold Kolhapuri spice blend.', 230.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 2, 'Fish Curry', 'Fresh fish simmered in a lightly spiced Indian curry.', 340.00, 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg', 1),
(1, 3, 'Butter Naan', 'Soft tandoor-baked naan brushed with melted butter.', 70.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Garlic Naan', 'Fluffy naan topped with garlic, coriander, and butter.', 90.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Tandoori Roti', 'Whole wheat roti baked fresh in the tandoor.', 45.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Laccha Paratha', 'Layered flaky paratha finished with a touch of butter.', 80.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Cheese Naan', 'Soft naan stuffed with melted cheese and herbs.', 130.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Plain Naan', 'Classic leavened bread baked in the tandoor.', 60.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Missi Roti', 'Gram flour and wheat roti seasoned with spices.', 65.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Aloo Kulcha', 'Kulcha stuffed with spiced potato filling.', 120.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Onion Kulcha', 'Tandoori kulcha filled with seasoned onions.', 110.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 3, 'Roomali Roti', 'Thin, soft handkerchief-style flatbread.', 55.00, 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg', 1),
(1, 4, 'Veg Biryani', 'Basmati rice layered with vegetables, saffron, and spices.', 240.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Chicken Biryani', 'Fragrant basmati rice layered with spiced chicken.', 300.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Mutton Biryani', 'Rich biryani with tender mutton, saffron rice, and spices.', 420.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Jeera Rice', 'Basmati rice tempered with cumin and ghee.', 160.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Peas Pulao', 'Basmati rice cooked with green peas and whole spices.', 180.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Kashmiri Pulao', 'Mild pulao with nuts, fruits, saffron, and aromatic rice.', 220.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Steamed Basmati Rice', 'Long-grain basmati rice steamed until fluffy.', 130.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Egg Biryani', 'Spiced egg biryani layered with fragrant basmati rice.', 250.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Paneer Biryani', 'Paneer and rice cooked dum-style with saffron and spices.', 270.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 4, 'Kolkata Chicken Biryani', 'Kolkata-style biryani with chicken, potato, and egg.', 320.00, 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg', 1),
(1, 5, 'Gulab Jamun', 'Soft milk dumplings soaked in warm cardamom syrup.', 110.00, 'https://upload.wikimedia.org/wikipedia/commons/2/24/GULAB_JAMUN.jpg', 1),
(1, 5, 'Rasmalai', 'Cottage cheese dumplings served in saffron milk.', 140.00, 'https://upload.wikimedia.org/wikipedia/commons/2/24/GULAB_JAMUN.jpg', 1),
(1, 5, 'Kesar Kulfi', 'Dense Indian ice cream flavored with saffron and pistachio.', 130.00, 'https://upload.wikimedia.org/wikipedia/commons/6/6c/Kulfi.jpg', 1),
(1, 5, 'Gajar Halwa', 'Carrot pudding slow-cooked with milk, ghee, and nuts.', 150.00, 'https://upload.wikimedia.org/wikipedia/commons/2/24/GULAB_JAMUN.jpg', 1),
(1, 5, 'Phirni', 'Creamy rice pudding flavored with cardamom and rose.', 120.00, 'https://upload.wikimedia.org/wikipedia/commons/2/24/Phirni.jpg', 1),
(1, 5, 'Mishti Doi', 'Bengali sweet yogurt with caramel notes.', 100.00, 'https://upload.wikimedia.org/wikipedia/commons/2/24/GULAB_JAMUN.jpg', 1),
(1, 5, 'Rabri', 'Thickened sweet milk topped with nuts and saffron.', 160.00, 'https://upload.wikimedia.org/wikipedia/commons/2/24/GULAB_JAMUN.jpg', 1),
(1, 5, 'Jalebi with Rabri', 'Crisp syrupy jalebi served with creamy rabri.', 180.00, 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Juicy_Jalebi.jpg', 1),
(1, 5, 'Malpua', 'Indian pancake dessert served with cardamom syrup.', 150.00, 'https://upload.wikimedia.org/wikipedia/commons/d/dd/MalPua.JPG', 1),
(1, 5, 'Chocolate Sandesh', 'Bengali sandesh with a smooth chocolate finish.', 130.00, 'https://upload.wikimedia.org/wikipedia/commons/2/2a/Sandesh.JPG', 1),
(1, 6, 'Mango Lassi', 'Chilled yogurt drink blended with ripe mango.', 130.00, 'https://upload.wikimedia.org/wikipedia/commons/a/af/Mango_lassi.jpg', 1),
(1, 6, 'Masala Chai', 'Hot tea brewed with milk, ginger, cardamom, and spices.', 60.00, 'https://upload.wikimedia.org/wikipedia/commons/a/af/Mango_lassi.jpg', 1),
(1, 6, 'Sweet Lime Soda', 'Sparkling lime drink with a refreshing sweet finish.', 90.00, 'https://upload.wikimedia.org/wikipedia/commons/f/f8/Lime_soda_(46693944265).jpg', 1),
(1, 6, 'Fresh Lime Water', 'Classic lime cooler served chilled and fresh.', 70.00, 'https://upload.wikimedia.org/wikipedia/commons/7/7a/Fresh_Lime.JPG', 1),
(1, 6, 'Thandai', 'Festive milk drink with nuts, saffron, and gentle spices.', 140.00, 'https://upload.wikimedia.org/wikipedia/commons/9/96/Thandai.jpg', 1),
(1, 6, 'Cold Coffee', 'Creamy chilled coffee blended smooth.', 130.00, 'https://upload.wikimedia.org/wikipedia/commons/a/af/Mango_lassi.jpg', 1),
(1, 6, 'Jaljeera', 'Tangy cumin and mint cooler with Indian spices.', 80.00, 'https://upload.wikimedia.org/wikipedia/commons/a/af/Mango_lassi.jpg', 1),
(1, 6, 'Rose Milk', 'Chilled milk flavored with fragrant rose syrup.', 110.00, 'https://upload.wikimedia.org/wikipedia/commons/9/93/Rose_Milk.jpg', 1),
(1, 6, 'Buttermilk', 'Light spiced chaas with roasted cumin and mint.', 75.00, 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Buttermilk_and_lassi.jpg', 1),
(1, 6, 'Mineral Water', 'Sealed bottled mineral water.', 40.00, 'https://upload.wikimedia.org/wikipedia/commons/4/41/A_water_bottle.jpg', 1);

UPDATE Menu_Item
SET image_url = CASE item_name
    WHEN 'Paneer Tikka' THEN 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Paneer_tikka.jpg'
    WHEN 'Hara Bhara Kebab' THEN 'https://upload.wikimedia.org/wikipedia/commons/b/bb/Hara_bhara_kabab.JPG'
    WHEN 'Chicken Tikka' THEN 'https://upload.wikimedia.org/wikipedia/commons/7/73/Chicken_Tikka.jpg'
    WHEN 'Veg Spring Roll' THEN 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Spring_Rolls_(3357696061).jpg'
    WHEN 'Aloo Tikki Chaat' THEN 'https://upload.wikimedia.org/wikipedia/commons/8/85/Aloo_tikki.jpg'
    WHEN 'Fish Amritsari' THEN 'https://upload.wikimedia.org/wikipedia/commons/7/77/Amritsari_Fried_Fish.JPG'
    WHEN 'Tandoori Mushroom' THEN 'https://upload.wikimedia.org/wikipedia/commons/8/80/Tandoori_Mushroom.jpg'
    WHEN 'Crispy Corn Pepper' THEN 'https://upload.wikimedia.org/wikipedia/commons/b/be/Crispy_corn_made_by_me.jpg'
    WHEN 'Seekh Kebab' THEN 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Seekh_Kebab.JPG'
    WHEN 'Masala Papad' THEN 'https://upload.wikimedia.org/wikipedia/commons/2/2a/Masala_Papadum.jpg'
    WHEN 'Butter Chicken' THEN 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg'
    WHEN 'Paneer Butter Masala' THEN 'https://upload.wikimedia.org/wikipedia/commons/e/e1/Paneer_Butter_Masala.jpg'
    WHEN 'Dal Makhani' THEN 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Dal-Makhani.jpg'
    WHEN 'Kadai Paneer' THEN 'https://upload.wikimedia.org/wikipedia/commons/1/17/Paneer_Butter_Masala_4.jpg'
    WHEN 'Chicken Curry' THEN 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg'
    WHEN 'Chana Masala' THEN 'https://upload.wikimedia.org/wikipedia/commons/8/8e/Chana_masala.jpg'
    WHEN 'Mutton Rogan Josh' THEN 'https://upload.wikimedia.org/wikipedia/commons/e/ee/Rogan_Josh.JPG'
    WHEN 'Malai Kofta' THEN 'https://upload.wikimedia.org/wikipedia/commons/7/76/Malai_kofta.jpg'
    WHEN 'Veg Kolhapuri' THEN 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Malai_Kofta.jpg'
    WHEN 'Fish Curry' THEN 'https://upload.wikimedia.org/wikipedia/commons/2/2c/FISH_CURRY.jpg'
    WHEN 'Butter Naan' THEN 'https://upload.wikimedia.org/wikipedia/commons/5/50/Naan_with_butter_chicken.jpg'
    WHEN 'Garlic Naan' THEN 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg'
    WHEN 'Tandoori Roti' THEN 'https://upload.wikimedia.org/wikipedia/commons/e/ef/Naan_roti.jpg'
    WHEN 'Laccha Paratha' THEN 'https://upload.wikimedia.org/wikipedia/commons/0/00/Naan_2.jpg'
    WHEN 'Cheese Naan' THEN 'https://upload.wikimedia.org/wikipedia/commons/7/75/Naan_Bread.JPG'
    WHEN 'Plain Naan' THEN 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Naan_.jpg'
    WHEN 'Missi Roti' THEN 'https://upload.wikimedia.org/wikipedia/commons/e/ef/Naan_roti.jpg'
    WHEN 'Aloo Kulcha' THEN 'https://upload.wikimedia.org/wikipedia/commons/7/75/Naan_Bread.JPG'
    WHEN 'Onion Kulcha' THEN 'https://upload.wikimedia.org/wikipedia/commons/2/22/Naan_is_a_flatbread_found_in_mainly_of_Indian_subcontinent.jpg'
    WHEN 'Roomali Roti' THEN 'https://upload.wikimedia.org/wikipedia/commons/f/f3/Naan_cooking.JPG'
    WHEN 'Veg Biryani' THEN 'https://upload.wikimedia.org/wikipedia/commons/1/18/Veg-Biryani.jpg'
    WHEN 'Chicken Biryani' THEN 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chicken_Biryani.jpg'
    WHEN 'Mutton Biryani' THEN 'https://upload.wikimedia.org/wikipedia/commons/1/17/Chicken_Biryani_!!.jpg'
    WHEN 'Jeera Rice' THEN 'https://upload.wikimedia.org/wikipedia/commons/f/fd/Jeera_Rice.jpg'
    WHEN 'Peas Pulao' THEN 'https://upload.wikimedia.org/wikipedia/commons/c/cf/Pulao.png'
    WHEN 'Kashmiri Pulao' THEN 'https://upload.wikimedia.org/wikipedia/commons/c/cf/Pulao.png'
    WHEN 'Steamed Basmati Rice' THEN 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Jeera-rice.JPG'
    WHEN 'Egg Biryani' THEN 'https://upload.wikimedia.org/wikipedia/commons/4/4c/Chicken_Biryani_with_Boiled_Egg.jpg'
    WHEN 'Paneer Biryani' THEN 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Veg_Biryani.jpg'
    WHEN 'Kolkata Chicken Biryani' THEN 'https://upload.wikimedia.org/wikipedia/commons/9/9b/Chicken_Biryani_3.jpg'
    WHEN 'Gulab Jamun' THEN 'https://upload.wikimedia.org/wikipedia/commons/2/24/GULAB_JAMUN.jpg'
    WHEN 'Rasmalai' THEN 'https://upload.wikimedia.org/wikipedia/commons/d/d5/Ras-Malai.jpg'
    WHEN 'Kesar Kulfi' THEN 'https://upload.wikimedia.org/wikipedia/commons/6/6c/Kulfi.jpg'
    WHEN 'Gajar Halwa' THEN 'https://upload.wikimedia.org/wikipedia/commons/5/58/Gajar_halwa.JPG'
    WHEN 'Phirni' THEN 'https://upload.wikimedia.org/wikipedia/commons/2/24/Phirni.jpg'
    WHEN 'Mishti Doi' THEN 'https://upload.wikimedia.org/wikipedia/commons/3/34/Mishti_Doi.jpg'
    WHEN 'Rabri' THEN 'https://upload.wikimedia.org/wikipedia/commons/d/df/Ras_Malai.JPG'
    WHEN 'Jalebi with Rabri' THEN 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Juicy_Jalebi.jpg'
    WHEN 'Malpua' THEN 'https://upload.wikimedia.org/wikipedia/commons/d/dd/MalPua.JPG'
    WHEN 'Chocolate Sandesh' THEN 'https://upload.wikimedia.org/wikipedia/commons/2/2a/Sandesh.JPG'
    WHEN 'Mango Lassi' THEN 'https://upload.wikimedia.org/wikipedia/commons/a/af/Mango_lassi.jpg'
    WHEN 'Masala Chai' THEN 'https://upload.wikimedia.org/wikipedia/commons/0/04/Masala_Chai.JPG'
    WHEN 'Sweet Lime Soda' THEN 'https://upload.wikimedia.org/wikipedia/commons/f/f8/Lime_soda_(46693944265).jpg'
    WHEN 'Fresh Lime Water' THEN 'https://upload.wikimedia.org/wikipedia/commons/7/7a/Fresh_Lime.JPG'
    WHEN 'Thandai' THEN 'https://upload.wikimedia.org/wikipedia/commons/9/96/Thandai.jpg'
    WHEN 'Cold Coffee' THEN 'https://upload.wikimedia.org/wikipedia/commons/0/02/Cold_coffee.jpg'
    WHEN 'Jaljeera' THEN 'https://upload.wikimedia.org/wikipedia/commons/d/dc/Jaljeera.jpg'
    WHEN 'Rose Milk' THEN 'https://upload.wikimedia.org/wikipedia/commons/9/93/Rose_Milk.jpg'
    WHEN 'Buttermilk' THEN 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Buttermilk_and_lassi.jpg'
    WHEN 'Mineral Water' THEN 'https://upload.wikimedia.org/wikipedia/commons/4/41/A_water_bottle.jpg'
    ELSE image_url
END;


-- Sample data for Surplus_Item
INSERT INTO Surplus_Item (restaurant_id, menu_item_id, quantity_available, surplus_price, available_until, status) VALUES
(1, 2, 10, 120.00, '2026-04-12 21:00:00', 'Available'),
(2, 32, 5, 220.00, '2026-04-12 20:30:00', 'Available'),
(3, 41, 8, 75.00, '2026-04-12 20:45:00', 'Available');


-- Sample data for Orders
INSERT INTO Orders (customer_id, restaurant_id, order_type, total_amount, order_status) VALUES
(1, 1, 'Regular', 245.00, 'Confirmed'),
(2, 2, 'Surplus', 90.00, 'Pending');


-- Sample data for Order_Details
INSERT INTO Order_Details (order_id, menu_item_id, surplus_item_id, quantity, unit_price) VALUES
(1, 1, NULL, 1, 220.00),
(1, 2, NULL, 1, 25.00),
(2, NULL, 2, 1, 90.00);


-- Sample data for Payment
INSERT INTO Payment (order_id, amount_paid, payment_method, payment_status) VALUES
(1, 245.00, 'Cash on Delivery', 'Paid'),
(2, 90.00, 'UPI', 'Pending');





-- Taste of India full menu seed
-- Adds image support and creates exactly 6 categories with 10 items each.
USE smart_food_ordering;
ALTER TABLE Menu_Item
    ADD COLUMN IF NOT EXISTS image_url VARCHAR(500) NOT NULL DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg' AFTER price;

ALTER TABLE Menu_Item
    MODIFY image_url VARCHAR(500) NOT NULL DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/1/19/Butter-chicken.jpg';
DELETE FROM Surplus_Item;
DELETE FROM Menu_Item;
DELETE FROM Category;
ALTER TABLE Category AUTO_INCREMENT = 1;
ALTER TABLE Menu_Item AUTO_INCREMENT = 1;
INSERT INTO Category (restaurant_id, category_name) VALUES
(1, 'Starters'),
(1, 'Main Course'),
(1, 'Breads'),
(1, 'Rice & Biryani'),
(1, 'Desserts'),
(1, 'Beverages');
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



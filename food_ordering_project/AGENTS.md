# Project Instructions for Codex

## Project name
Taste of India

## Project type
PHP + MySQL + Bootstrap web project running on XAMPP.

## Root folder
The real working project folder is:
C:\xampp\htdocs\food_ordering_project

Always edit files in this project folder only.
Do not use any Desktop copy or alternate copy.

## Database
Database name:
smart_food_ordering

Important SQL files used in this project:
- database.sql
- extra_queries.sql
- subscription_update.sql
- taste_of_india_menu_seed.sql

## XAMPP / local setup
This project runs locally on XAMPP.
Apache and MySQL must be running.

Database connection file:
db/config.php

MySQL port may differ by device:
- use 3306 if MySQL is on default port
- use 3307 only if this device's XAMPP MySQL is configured to 3307

Before changing db/config.php, check the actual XAMPP MySQL port on this device.

## Project concept
This is not a multi-restaurant marketplace.
This project represents one restaurant brand:
Taste of India

The brand has multiple outlets.
Use the existing Restaurant table as outlet data.
Do not heavily rename backend tables unless necessary.
Prefer changing visible UI text to "Outlet / Outlets".

## Outlet concept
Current outlet structure:
- Taste of India - Park Street Outlet
  Outlet Manager: Rakesh Gupta
  Email: parkstreet@tasteofindia.com
  Phone: 9345678901
  Address: 18A Park Street, Kolkata, West Bengal 700071

- Taste of India - Salt Lake Outlet
  Outlet Manager: Sneha Roy
  Email: saltlake@tasteofindia.com
  Phone: 9456789012
  Address: City Centre 1, DC Block, Sector I, Bidhannagar, Kolkata, West Bengal 700064

- Taste of India - Gariahat Outlet
  Outlet Manager: Arindam Sen
  Email: gariahat@tasteofindia.com
  Phone: 9567890123
  Address: 45A Gariahat Road, Ballygunge, Kolkata, West Bengal 700019

All customer-facing wording should reflect one restaurant brand with multiple outlets.

## Branding
Brand name:
Taste of India

Do not use old branding like:
- Smart Food Ordering

Use outlet wording instead of marketplace wording wherever possible.

## Main customer pages
- index.php
- register.php
- login.php
- logout.php
- user_dashboard.php
- restaurants.php   (conceptually this is the outlets page)
- menu.php
- surplus_meals.php
- cart.php
- checkout.php
- my_orders.php
- subscription.php
- subscription_checkout.php (if present or to be created)

## Main admin pages
- admin/login.php
- admin/dashboard.php
- admin/restaurants.php
- admin/menu_items.php
- admin/surplus_items.php
- admin/orders.php
- admin/payments.php
- admin/subscriptions.php

## Styling
The project uses a premium warm theme:
- warm cream / beige background
- dark elegant navbar
- soft gold / amber accents
- rounded cards
- soft shadows
- polished startup-like UI

Keep the same theme consistent across customer pages and admin pages.

Prefer reusing shared CSS instead of creating many unnecessary stylesheets.

## Important project logic

### Customer flow
Customer should be able to:
- register
- login
- view outlets
- view menu for an outlet
- view surplus meals
- add items to cart
- checkout
- view my orders
- manage subscription
- logout

### Cart
Use PHP session cart:
$_SESSION['cart']

Do not break add-to-cart, remove-from-cart, or checkout flow.

### Checkout
Checkout must:
- require customer login
- use session cart
- calculate items total automatically
- show delivery fee
- show final total
- let user select order_type
- let user enter/select payment_method
- generate order automatically on submit
- insert into Orders
- insert into Order_Details
- insert into Payment
- clear cart after successful order

### Subscription logic
Users should NOT become subscribed automatically.

Correct subscription flow:
- subscription.php shows current subscription if active
- if not subscribed or expired, user should be able to choose a plan
- subscription_checkout.php (or equivalent flow) should handle payment for subscription
- only after payment should a Subscription row be inserted / activated

A user is subscribed only if:
- status = 'Active'
- and end_date >= CURDATE()

### Delivery fee logic
- non-subscribed users pay delivery fee
- subscribed users get delivery fee waived
- checkout page should clearly show:
  - items total
  - delivery fee
  - final total
- for subscribed users show a message like:
  "Delivery fee waived because you are a subscriber."
- for non-subscribed users show:
  - normal delivery fee added
  - Subscribe Now option/link to subscription.php or subscription_checkout.php

### Admin subscriptions
Admin must be able to see:
- which users are subscribed
- which users are not subscribed
- plan name
- price
- start_date
- end_date
- status

Use LEFT JOIN between Customer and Subscription if needed.

## Menu system
Menu categories should include:
- Starters
- Main Course
- Breads
- Rice & Biryani
- Desserts
- Beverages

Do not reintroduce food item images unless explicitly requested.
Current preference is no menu item images.

## Database notes
Keep existing database structure working.
Minimize destructive schema changes.
Prefer additive or UI-level changes when possible.

If changing SQL-related behavior:
- keep compatibility with phpMyAdmin / XAMPP MySQL
- keep beginner-friendly SQL
- avoid breaking existing imported data

## When making changes
- inspect the existing files first
- preserve working links
- preserve PHP session logic
- preserve database queries unless a fix is required
- preserve routing and file names unless explicitly asked to rename
- avoid unnecessary rewrites
- prefer minimal, safe edits
- do not introduce placeholder assets that break
- do not reintroduce food item images unless explicitly requested

## Before editing
For medium or large edits:
1. inspect current relevant files
2. identify which files need change
3. then implement only the needed changes

## If something is broken
Check these first:
- correct project folder
- Apache running
- MySQL running
- correct db/config.php port
- required SQL files imported
- session logic preserved

After creating AGENTS.md, do not change any other files.

<p align="center">
  <img src="https://img.icons8.com/3d-fluency/94/warehouse.png" alt="Stock Management" width="80"/>
</p>

<h1 align="center">📦 Stock Management System</h1>

<p align="center">
  A comprehensive inventory and stock management web application built with Laravel.<br/>
  Manage products, track purchases and sales, generate reports, and maintain complete control over your business inventory.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"/>
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"/>
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind"/>
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License"/>
</p>

---

## 📑 Table of Contents

- [✨ Features](#-features)
- [🛠 Tech Stack](#-tech-stack)
- [📋 Requirements](#-requirements)
- [🚀 Installation](#-installation)
- [⚙️ Configuration](#️-configuration)
- [📖 User Manual](#-user-manual)
  - [🔐 Authentication](#-authentication)
  - [👤 Default Accounts](#-default-accounts)
  - [🛡️ Role-Based Permissions](#️-role-based-permissions)
  - [📊 Dashboard](#-dashboard)
  - [📁 Master Data Management](#-master-data-management)
  - [🛒 Purchase Management](#-purchase-management)
  - [💰 Sales Management](#-sales-management)
  - [📈 Reports](#-reports)
  - [👥 User Management](#-user-management)
  - [⚙️ Profile Settings](#️-profile-settings)
  - [📥 Import & Export](#-import--export)
  - [🌐 Language Support](#-language-support)
- [🗄️ Database Schema](#️-database-schema)
- [🔌 API Reference](#-api-reference)
- [📄 License](#-license)

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 📊 **Dashboard** | Real-time overview of products, categories, suppliers, purchases, sales, profit, low-stock alerts, and recent activity |
| 📦 **Product Management** | Full CRUD with SKU tracking, stock levels, image uploads, category and unit assignment |
| 🏷️ **Category & Unit Management** | Organize products by categories and measurement units |
| 🤝 **Supplier & Customer Management** | Maintain supplier/customer records with contact details and transaction history |
| 🛒 **Purchase Management** | Multi-item invoice-based purchasing with automatic stock increment |
| 💰 **Sales Management** | Multi-item invoice-based sales with automatic stock decrement |
| 📈 **Reports** | Stock, purchase, sale, and profit reports with date range and category filtering |
| 📥 **Excel Import/Export** | Bulk import and export data via Excel (xlsx, xls, csv) with downloadable sample templates |
| 🛡️ **Role-Based Access Control** | Two-tier permission system (Admin/User) with backend middleware enforcement |
| 👥 **User Management** | Admin-only user CRUD with role assignment |
| 🌐 **Multilingual** | English and Bengali (বাংলা) language support |
| 🎨 **Responsive UI** | Built with Bootstrap 5 for a clean, modern interface |

---

## 🛠 Tech Stack

| Layer | Technology | Badge |
|-------|------------|-------|
| 🏗️ Framework | Laravel 10 | ![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=flat-square&logo=laravel&logoColor=white) |
| 💻 Language | PHP 8.1+ | ![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php&logoColor=white) |
| 🗄️ Database | MySQL 5.7+ | ![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white) |
| 🎨 Frontend | Bootstrap 5, Alpine.js 3 | ![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat-square&logo=bootstrap&logoColor=white) |
| ⚡ Build Tool | Vite 5 | ![Vite](https://img.shields.io/badge/Vite-5-646CFF?style=flat-square&logo=vite&logoColor=white) |
| 🔐 Auth | Laravel Breeze + Sanctum | ![Sanctum](https://img.shields.io/badge/Sanctum-Auth-FF2D20?style=flat-square&logo=laravel&logoColor=white) |
| 📊 Excel | Maatwebsite Excel 3.1 | ![Excel](https://img.shields.io/badge/Maatwebsite-Excel-217346?style=flat-square&logo=microsoftexcel&logoColor=white) |
| 📋 DataTables | Yajra DataTables 10 | ![DataTables](https://img.shields.io/badge/Yajra-DataTables-336791?style=flat-square) |

---

## 📋 Requirements

| Requirement | Version |
|-------------|---------|
| ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white) | >= 8.1 |
| ![Composer](https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white) | Latest |
| ![Node.js](https://img.shields.io/badge/Node.js-339933?style=flat-square&logo=nodedotjs&logoColor=white) | LTS (with npm) |
| ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white) | 5.7+ or MariaDB 10.3+ |
| 🖥️ Server | WAMP / XAMPP / Laravel Valet or any PHP environment |

---

## 🚀 Installation

### Step 1 — Clone the Repository

```bash
git clone <repository-url> stock-management
cd stock-management
```

### Step 2 — Install Dependencies

```bash
composer install
npm install
```

### Step 3 — Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### Step 4 — Configure Database

Open the `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stock_management
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5 — Run Migrations & Seed Data

```bash
php artisan migrate --seed
```

### Step 6 — Storage Link

```bash
php artisan storage:link
```

> Creates a symbolic link from `public/storage` to `storage/app/public` for product image uploads.

### Step 7 — Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### Step 8 — Start the Application

```bash
php artisan serve
```

> 🌐 Visit `http://localhost:8000` in your browser.

---

## ⚙️ Configuration

| Setting | File | Description |
|---------|------|-------------|
| 🏷️ App Name | `.env` | `APP_NAME="Stock Management"` |
| 🗄️ Database | `.env` | MySQL connection details |
| 📧 Mail | `.env` | SMTP settings for password reset emails |
| 📁 File Storage | `.env` | Default `public` disk for product images |
| 🐛 Debug Mode | `.env` | Set `APP_DEBUG=false` in production |

---

## 📖 User Manual

### 🔐 Authentication

#### 📝 Registration
1. Navigate to the application URL
2. Click **Register** on the login page
3. Fill in your **Name**, **Email**, and **Password**
4. Click **Register** to create your account

#### 🔑 Login
1. Enter your **Email** and **Password**
2. Optionally check **Remember me** to stay logged in
3. Click **Log in**

#### 🔄 Forgot Password
1. Click **Forgot your password?** on the login page
2. Enter your registered email address
3. Check your inbox for the password reset link
4. Click the link and set a new password

---

### 👤 Default Accounts

After running `php artisan migrate --seed`, the following accounts are available:

| 👤 Name | 📧 Email | 🔑 Password | 🛡️ Role |
|---------|----------|-------------|---------|
| Admin | `admin@admin.com` | `password` | 🔴 Admin |
| Rahim | `rahim@example.com` | `password` | 🔵 User |
| Karim | `karim@example.com` | `password` | 🔵 User |

> ⚠️ **Important:** Change these default passwords immediately in a production environment.

---

### 🛡️ Role-Based Permissions

The application enforces role-based access control at both the **route level** (middleware) and **UI level** (hidden buttons). Unauthorized access returns a `403 Forbidden` error.

#### 📋 Permission Matrix

| Feature | 🔴 Admin | 🔵 User |
|---------|:--------:|:-------:|
| **📊 Dashboard** | | |
| View dashboard | ✅ | ✅ |
| **🏷️ Categories** | | |
| View / List categories | ✅ | ✅ |
| Create / Edit / Delete | ✅ | ❌ |
| Import categories | ✅ | ❌ |
| Export categories | ✅ | ✅ |
| **📏 Units** | | |
| View / List units | ✅ | ✅ |
| Create / Edit / Delete | ✅ | ❌ |
| Import units | ✅ | ❌ |
| Export units | ✅ | ✅ |
| **📦 Products** | | |
| View / List products | ✅ | ✅ |
| View product details | ✅ | ✅ |
| Create / Edit / Delete | ✅ | ❌ |
| Import products | ✅ | ❌ |
| Export products | ✅ | ✅ |
| **🏭 Suppliers** | | |
| View / List suppliers | ✅ | ✅ |
| View supplier details | ✅ | ✅ |
| Create / Edit / Delete | ✅ | ❌ |
| Quick-add (from purchase form) | ✅ | ✅ |
| Import suppliers | ✅ | ❌ |
| Export suppliers | ✅ | ✅ |
| **🧑‍💼 Customers** | | |
| View / List customers | ✅ | ✅ |
| Create / Edit / Delete | ✅ | ❌ |
| Quick-add (from sale form) | ✅ | ✅ |
| Import customers | ✅ | ❌ |
| Export customers | ✅ | ✅ |
| **🛒 Purchases** | | |
| View / List purchases | ✅ | ✅ |
| View purchase details | ✅ | ✅ |
| Create new purchase | ✅ | ✅ |
| Edit / Delete purchase | ✅ | ❌ |
| Import purchases | ✅ | ❌ |
| Export purchases | ✅ | ✅ |
| **💰 Sales** | | |
| View / List sales | ✅ | ✅ |
| View sale details | ✅ | ✅ |
| Create new sale | ✅ | ✅ |
| Edit / Delete sale | ✅ | ❌ |
| Import sales | ✅ | ❌ |
| Export sales | ✅ | ✅ |
| **📈 Reports** | | |
| Stock report | ✅ | ✅ |
| Purchase report | ✅ | ✅ |
| Sale report | ✅ | ✅ |
| Profit report | ✅ | ✅ |
| **👥 User Management** | | |
| View / List users | ✅ | ❌ |
| Create / Edit / Delete users | ✅ | ❌ |
| Assign roles | ✅ | ❌ |
| **⚙️ Profile** | | |
| Edit own profile | ✅ | ✅ |
| Change own password | ✅ | ✅ |
| Delete own account | ✅ | ✅ |
| **🌐 Language** | | |
| Switch language | ✅ | ✅ |

#### 🔧 How It Works

```
┌─────────────────────────────────────────────────────────┐
│                    REQUEST FLOW                         │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  User Request ──▶ Auth Middleware ──▶ Role Middleware    │
│                        │                    │           │
│                   Logged in?          Is Admin?          │
│                   ┌────┴────┐        ┌────┴────┐       │
│                   │ No: 401 │        │ No: 403 │       │
│                   │ Yes: ✅  │        │ Yes: ✅  │       │
│                   └─────────┘        └─────────┘       │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

- 🔒 **Backend Enforcement**: A `role:admin` middleware protects all admin-only routes. Non-admin users receive a `403 Forbidden` response.
- 👁️ **UI Enforcement**: Admin-only buttons (Add, Edit, Delete, Import) are hidden from the interface for regular users.
- 📌 **Sidebar Navigation**: The "Users" menu item is only visible to admin users.

---

### 📊 Dashboard

The dashboard provides a snapshot of your business at a glance:

| Widget | Description |
|--------|-------------|
| 📦 Total Products | Number of products in the system |
| 🏷️ Total Categories | Number of product categories |
| 🏭 Total Suppliers | Number of registered suppliers |
| 🛒 Total Purchases | Cumulative purchase amount (৳) |
| 💰 Total Sales | Cumulative sales amount (৳) |
| 📈 Total Profit | Net profit (Total Sales - Total Purchases) |
| ⚠️ Low Stock Products | Products with quantity <= 5 (requires attention) |
| 🕐 Recent Purchases | Last 5 purchase transactions |
| 🕐 Recent Sales | Last 5 sale transactions |

---

### 📁 Master Data Management

> 💡 **Note:** All users can view and export master data. Only **🔴 Admin** users can create, edit, delete, and import.

#### 🏷️ Categories

Categories help organize your products (e.g., Electronics, Clothing, Food).

- 👁️ **View All**: Navigate to **Categories** from the sidebar. A DataTable lists all categories with product counts.
- ➕ **Add New** `🔴 Admin`: Click **Add Category** → enter **Name** and **Description** → click **Save**.
- ✏️ **Edit** `🔴 Admin`: Click the **Edit** button on any category row → modify details → click **Update**.
- 🗑️ **Delete** `🔴 Admin`: Click the **Delete** button → confirm the deletion.

> ⚠️ Deleting a category that has associated products may affect those products.

#### 📏 Units

Units define how products are measured (e.g., pcs, kg, liter, box).

- 👁️ **View All**: Navigate to **Units** from the sidebar.
- ➕ **Add New** `🔴 Admin`: Click **Add Unit** → enter the unit **Name** → click **Save**.
- ✏️🗑️ **Edit/Delete** `🔴 Admin`: Use the action buttons on each row.

#### 📦 Products

Products are the core of your inventory.

- 👁️ **View All**: Navigate to **Products** from the sidebar. The DataTable shows product name, SKU, category, stock level, buy/sell price, and status badges:
  - 🟢 **Green badge** — In Stock
  - 🟡 **Yellow badge** — Low Stock (quantity <= 5)
  - 🔴 **Red badge** — Out of Stock (quantity = 0)
- 🔍 **View Details**: Click the view button to see full details including purchase and sale history.
- ➕ **Add New Product** `🔴 Admin`:
  1. Click **Add Product**
  2. Fill in: **Name**, **SKU** (unique identifier), **Category**, **Unit**, **Buy Price**, **Sell Price**, **Quantity**, **Description** (optional), **Image** (optional, max 2MB)
  3. Click **Save**
- ✏️ **Edit** `🔴 Admin`: Click **Edit** on any product → update fields → click **Update**.
- 🗑️ **Delete** `🔴 Admin`: Click **Delete** → confirm.
- 🔎 **Filter by Stock Status**: Use the stock status filter to view only low stock, out of stock, or in stock products.

#### 🏭 Suppliers

Suppliers are your product vendors.

- 👁️ **View All**: Navigate to **Suppliers** from the sidebar.
- 🔍 **View Details**: Click a supplier name to see their details and purchase history.
- ➕ **Add New** `🔴 Admin`: Click **Add Supplier** → enter **Name**, **Email**, **Phone**, **Address** → click **Save**.
- ⚡ **Quick Add**: When creating a purchase, you can add a new supplier on the fly without leaving the purchase form (available to all users).
- ✏️🗑️ **Edit/Delete** `🔴 Admin`: Use action buttons on each row.

#### 🧑‍💼 Customers

Customers are your buyers.

- 👁️ **View All**: Navigate to **Customers** from the sidebar.
- ➕ **Add New** `🔴 Admin`: Click **Add Customer** → enter **Name**, **Email**, **Phone**, **Address** → click **Save**.
- ⚡ **Quick Add**: When creating a sale, add a new customer directly from the sale form (available to all users).
- ✏️🗑️ **Edit/Delete** `🔴 Admin`: Use action buttons on each row.

---

### 🛒 Purchase Management

Purchases track goods received from suppliers and automatically increase product stock.

#### ➕ Creating a Purchase

1. Navigate to **Purchases** → click **Add Purchase**
2. Select a **Supplier** (or quick-add a new one)
3. Set the **Purchase Date**
4. **Add Items**:
   - Select a **Product** from the dropdown
   - Enter **Quantity** and **Buy Price**
   - The line total is calculated automatically
   - Add multiple items as needed
5. Review the **Subtotal**
6. Enter a **Discount** amount (optional)
7. The **Total** is calculated as Subtotal - Discount
8. Enter the **Paid Amount**
9. The **Due Amount** is calculated as Total - Paid Amount
10. Add a **Note** (optional)
11. Click **Save**

> 📌 **Important:** When a purchase is saved, the stock quantity of each purchased product is automatically increased.

#### 🔢 Purchase Number Format

Purchase numbers are auto-generated in the format: `PUR-000001`, `PUR-000002`, etc.

#### ✏️ Editing a Purchase `🔴 Admin Only`

When editing a purchase, the system adjusts stock levels accordingly — previous quantities are reversed and new quantities are applied.

#### 🗑️ Deleting a Purchase `🔴 Admin Only`

Deleting a purchase reverses the stock increment — product quantities are decreased by the amounts in the deleted purchase.

---

### 💰 Sales Management

Sales track goods sold to customers and automatically decrease product stock.

#### ➕ Creating a Sale

1. Navigate to **Sales** → click **Add Sale**
2. Select a **Customer** (optional — you can also type a customer name directly)
3. Set the **Sale Date**
4. **Add Items**:
   - Select a **Product** from the dropdown
   - Enter **Quantity** and **Sell Price**
   - The line total is calculated automatically
   - Add multiple items as needed
5. Review the **Subtotal**
6. Enter a **Discount** amount (optional)
7. The **Total** is calculated as Subtotal - Discount
8. Enter the **Paid Amount**
9. The **Due Amount** is calculated as Total - Paid Amount
10. Add a **Note** (optional)
11. Click **Save**

> 📌 **Important:** When a sale is saved, the stock quantity of each sold product is automatically decreased. Products with zero stock cannot be sold.

#### 🔢 Invoice Number Format

Invoice numbers are auto-generated in the format: `INV-000001`, `INV-000002`, etc.

#### ✏️ Editing a Sale `🔴 Admin Only`

When editing a sale, stock levels are recalculated — previous quantities are restored and new quantities are deducted.

#### 🗑️ Deleting a Sale `🔴 Admin Only`

Deleting a sale reverses the stock decrement — product quantities are increased by the amounts in the deleted sale.

---

### 📈 Reports

Navigate to **Reports** from the sidebar to access the reporting module.

#### 📊 Stock Report

View current inventory levels across all products.

- 🔎 **Filters**: Category, Stock Status (Low Stock / Out of Stock / In Stock)
- 📐 **Metrics**: Total Stock Value (based on buy price), Total Sell Value (based on sell price)
- Displays each product with its current quantity, buy price, sell price, and calculated values

#### 🛒 Purchase Report

View all purchase transactions.

- 🔎 **Filters**: Date Range (From – To), Supplier
- 📐 **Metrics**: Total purchase amount for the filtered period
- Displays purchase number, supplier, item count, total amount, and date

#### 💰 Sale Report

View all sale transactions.

- 🔎 **Filters**: Date Range (From – To), Customer Name
- 📐 **Metrics**: Total sales amount for the filtered period
- Displays invoice number, customer, item count, total amount, and date

#### 💹 Profit Report

View overall business profitability.

- 🔎 **Filters**: Date Range (From – To)
- 📐 **Metrics**:
  - 🛒 Total Purchases (৳)
  - 💰 Total Sales (৳)
  - 📈 Net Profit (৳) = Total Sales - Total Purchases

---

### 👥 User Management

> 🔒 **Admin only** — This entire module is restricted to administrators. Regular users cannot access it and the menu item is hidden from their sidebar.

- 👁️ **View All Users**: Navigate to **Users** from the sidebar (admin only).
- ➕ **Add New User**: Click **Add User** → enter **Name**, **Email**, **Password**, and assign a **Role** (Admin or User) → click **Save**.
- ✏️ **Edit User**: Click **Edit** → update details and role → click **Update**.
- 🗑️ **Delete User**: Click **Delete** → confirm. You cannot delete your own account from this page.

#### 🏷️ Roles Summary

| Role | Badge | Description |
|------|-------|-------------|
| **Admin** | 🔴 | Full access to all features: CRUD on all modules, user management, import/export |
| **User** | 🔵 | View-only access to master data, can create purchases & sales, view reports, export data |

---

### ⚙️ Profile Settings

Click your name in the sidebar → **Profile** to access:

- 👤 **Update Profile Information** — Change your name and email
- 🔑 **Change Password** — Update your account password
- ❌ **Delete Account** — Permanently delete your account (requires password confirmation)

---

### 📥 Import & Export

All major data modules (Categories, Units, Products, Suppliers, Customers, Purchases, Sales) support Excel import/export.

#### 📤 Exporting Data `🔴 Admin & 🔵 User`

1. Navigate to the module (e.g., Products)
2. Click the **Export** button
3. An Excel file (.xlsx) will be downloaded containing all records

#### 📥 Importing Data `🔴 Admin Only`

1. Navigate to the module (e.g., Products)
2. Click the **Import** button (visible only to admins)
3. Select an Excel file (.xlsx, .xls, or .csv)
4. Click **Upload** to import the data

#### 📄 Sample Templates `🔴 Admin Only`

1. Click the **Sample** button on any module
2. A pre-formatted Excel template will be downloaded
3. Fill in your data following the template structure
4. Use this file to import your data

> 💡 **Tip:** Always download and review the sample template before preparing your import file to ensure correct column formatting.

---

### 🌐 Language Support

The application supports two languages:

| Language | Code | Flag |
|----------|------|------|
| English | `en` | 🇺🇸 |
| Bengali | `bn` | 🇧🇩 |

To switch languages:
1. Look for the language switcher in the sidebar
2. Select your preferred language
3. The interface will update immediately
4. Your language preference is saved to your user profile

---

## 🗄️ Database Schema

### 🔗 Entity Relationship Overview

```
┌────────────┐
│ categories │──┐
└────────────┘  │    ┌──────────┐     ┌────────────────┐     ┌───────────┐     ┌───────────┐
                ├──▶ │ products │──▶──│ purchase_items  │──▶──│ purchases │──▶──│ suppliers │
┌────────────┐  │    └──────────┘     └────────────────┘     └───────────┘     └───────────┘
│   units    │──┘         │
└────────────┘            │           ┌────────────────┐     ┌───────────┐     ┌───────────┐
                          └────▶──────│  sale_items     │──▶──│   sales   │──▶──│ customers │
                                      └────────────────┘     └───────────┘     └───────────┘
```

### 📋 Tables

| Table | Description |
|-------|-------------|
| 👤 `users` | User accounts with roles and language preferences |
| 🏷️ `categories` | Product categories |
| 📏 `units` | Measurement units |
| 📦 `products` | Product catalog with stock tracking |
| 🏭 `suppliers` | Supplier contact information |
| 🧑‍💼 `customers` | Customer contact information |
| 🛒 `purchases` | Purchase invoice headers |
| 📋 `purchase_items` | Purchase invoice line items |
| 💰 `sales` | Sale invoice headers |
| 📋 `sale_items` | Sale invoice line items |

### 🔑 Key Fields

**📦 Products**
- `sku` — Unique product identifier
- `buy_price` / `sell_price` — Pricing information
- `quantity` — Current stock level
- `category_id` / `unit_id` — Foreign keys to categories and units

**🛒 Purchases**
- `purchase_no` — Auto-generated (`PUR-XXXXXX`)
- `subtotal`, `discount`, `total_price`, `paid_amount`, `due_amount` — Financial tracking

**💰 Sales**
- `invoice_no` — Auto-generated (`INV-XXXXXX`)
- `customer_id` — Optional (supports anonymous sales)
- `subtotal`, `discount`, `total_price`, `paid_amount`, `due_amount` — Financial tracking

---

## 🔌 API Reference

### 🔐 Authentication

The application uses Laravel Sanctum for API token authentication.

```http
GET /api/user
Authorization: Bearer {token}
```

### 🗺️ Web Routes Summary

All routes require authentication. Routes marked with 🔴 require the `role:admin` middleware.

| Method | URI | Description | Access |
|--------|-----|-------------|--------|
| `GET` | `/dashboard` | Dashboard overview | 🟢 All |
| `GET` | `/categories` | List categories | 🟢 All |
| `POST` | `/categories` | Create category | 🔴 Admin |
| `PUT` | `/categories/{id}` | Update category | 🔴 Admin |
| `DELETE` | `/categories/{id}` | Delete category | 🔴 Admin |
| `GET` | `/units` | List units | 🟢 All |
| `POST` | `/units` | Create unit | 🔴 Admin |
| `PUT` | `/units/{id}` | Update unit | 🔴 Admin |
| `DELETE` | `/units/{id}` | Delete unit | 🔴 Admin |
| `GET` | `/products` | List products | 🟢 All |
| `GET` | `/products/{id}` | View product details | 🟢 All |
| `POST` | `/products` | Create product | 🔴 Admin |
| `PUT` | `/products/{id}` | Update product | 🔴 Admin |
| `DELETE` | `/products/{id}` | Delete product | 🔴 Admin |
| `GET` | `/suppliers` | List suppliers | 🟢 All |
| `GET` | `/suppliers/{id}` | View supplier details | 🟢 All |
| `POST` | `/suppliers` | Create supplier | 🔴 Admin |
| `PUT` | `/suppliers/{id}` | Update supplier | 🔴 Admin |
| `DELETE` | `/suppliers/{id}` | Delete supplier | 🔴 Admin |
| `POST` | `/suppliers-quick` | Quick-add supplier (AJAX) | 🟢 All |
| `GET` | `/customers` | List customers | 🟢 All |
| `POST` | `/customers` | Create customer | 🔴 Admin |
| `PUT` | `/customers/{id}` | Update customer | 🔴 Admin |
| `DELETE` | `/customers/{id}` | Delete customer | 🔴 Admin |
| `POST` | `/customers-quick` | Quick-add customer (AJAX) | 🟢 All |
| `GET` | `/purchases` | List purchases | 🟢 All |
| `GET` | `/purchases/{id}` | View purchase details | 🟢 All |
| `POST` | `/purchases` | Create purchase | 🟢 All |
| `PUT` | `/purchases/{id}` | Update purchase | 🔴 Admin |
| `DELETE` | `/purchases/{id}` | Delete purchase | 🔴 Admin |
| `GET` | `/sales` | List sales | 🟢 All |
| `GET` | `/sales/{id}` | View sale details | 🟢 All |
| `POST` | `/sales` | Create sale | 🟢 All |
| `PUT` | `/sales/{id}` | Update sale | 🔴 Admin |
| `DELETE` | `/sales/{id}` | Delete sale | 🔴 Admin |
| `RESOURCE` | `/users` | User CRUD | 🔴 Admin |
| `GET` | `/reports` | Reports index | 🟢 All |
| `GET` | `/reports/stock` | Stock report | 🟢 All |
| `GET` | `/reports/purchase` | Purchase report | 🟢 All |
| `GET` | `/reports/sale` | Sale report | 🟢 All |
| `GET` | `/reports/profit` | Profit report | 🟢 All |
| `GET` | `/{module}-export` | Export data to Excel | 🟢 All |
| `POST` | `/{module}-import` | Import data from Excel | 🔴 Admin |
| `GET` | `/{module}-sample` | Download sample template | 🔴 Admin |
| `GET` | `/language/{lang}` | Switch language (en/bn) | 🟢 All |

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">
  Made with ❤️ using <strong>Laravel</strong>
</p>

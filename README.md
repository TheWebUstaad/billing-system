# 🛒 Point of Sale (POS) System

A modern, feature-rich Point of Sale system built with CodeIgniter 3 and Bootstrap 5. Perfect for small to medium retail businesses with full Urdu language support.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

## ✨ Features

### 🏪 **Core Functions**
- **Bill Management** - Create, edit, view, and delete bills
- **Customer Management** - Add, edit, view, and delete customers
- **Inventory Management** - Manage products with title, price, and stock
- **PDF Generation** - Professional bill receipts with TCPDF
- **Settings** - Configure business name, currency, and contact details

### 📊 **Dashboard**
- **Basic Stats** - Total bills count and today's bills
- **Quick Actions** - Fast access to main functions
- **Real-time Clock** - Current time display
- **Daily Sales** - Today's total revenue

### 🔧 **System Features**
- **Authentication** - Admin login system
- **Responsive Design** - Bootstrap 5 responsive interface
- **Local Assets** - All CSS/JS files stored locally
- **Urdu Support** - RTL text display for Urdu content
- **Data Validation** - Form validation and error handling
- **Safe Deletion** - Confirmation dialogs with SweetAlert2

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP/WAMP (for local development)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/pos-system.git
   cd pos-system
   ```

2. **Import the database**
   ```bash
   mysql -u root -p < database.sql
   ```

3. **Configure database connection**
   ```php
   // application/config/database.php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'your_username', 
       'password' => 'your_password',
       'database' => 'pos_system'
   );
   ```

4. **Set base URL**
   ```php
   // application/config/config.php
   $config['base_url'] = 'http://localhost/pos-system/';
   ```

5. **Access the system**
   - Open browser: `http://localhost/pos-system/`
   - Default login: `admin` / `admin123`

## 📱 Available Pages & Functions

### **Dashboard** (`/dashboard`)
- View total bills and today's bills count
- Quick action buttons for main functions
- Real-time clock display

### **Billing** (`/billing`)
- Create new bills with customer and item details
- View all bills with pagination and filtering
- Edit existing bills
- Delete bills with confirmation
- Export bills to PDF
- Generate PDF receipts

### **Customer Management** (`/customer`)
- Add new customers (name and phone)
- View all customers
- Edit customer information
- Delete customers (with bill check)

### **Inventory** (`/inventory`)
- Add new products/items
- View all inventory items
- Edit item details (title, price, stock)
- Export inventory to PDF

### **Settings** (`/settings`)
- Configure business name and address
- Set currency symbol
- Update contact information

### **Authentication** (`/auth`)
- Admin login/logout
- Session management

## 🛠️ Technical Stack

### **Backend**
- **Framework**: CodeIgniter 3.1.13
- **Language**: PHP 7.4+
- **Database**: MySQL 5.7+
- **PDF Generation**: TCPDF Library

### **Frontend**
- **CSS Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.0
- **JavaScript**: jQuery 3.6.0
- **DataTables**: For advanced table features
- **SweetAlert2**: For confirmation dialogs
- **Toastr**: For notifications
- **Select2**: For enhanced dropdowns

### **Database Tables**
```sql
- customers (id, name, phone, address, created_at, updated_at)
- inventory (id, title, price, stock, sku, description, created_at, updated_at)
- bills (id, bill_number, customer_id, total_amount, created_at, updated_at)
- bill_items (id, bill_id, item_id, quantity, unit_price, total_price)
- settings (id, setting_key, setting_value, created_at, updated_at)
```

## 🔧 Configuration

### **System Settings**
Available settings in the Settings page:
- Business Name
- Business Address
- Currency Symbol
- Contact Phone
- Contact Email

### **Database Migration Files**
- `database.sql` - Main database structure
- `update_bills_table.sql` - Bill table updates
- `update_customers_table.sql` - Customer table updates
- `update_inventory_table.sql` - Inventory table updates
- `update_settings.sql` - Settings table updates

## 🚨 Security Features

- **SQL Injection Protection** - CodeIgniter Active Record
- **XSS Filtering** - Built-in security helpers
- **Session Security** - Secure admin session handling
- **Input Validation** - Form validation on all inputs
- **Foreign Key Constraints** - Database referential integrity

## 📋 System Requirements

### **Minimum Requirements**
- PHP 7.4+ with extensions:
  - MySQL/MySQLi
  - GD Library (for PDF generation)
  - mbstring
  - curl
- MySQL 5.7+
- Apache 2.4+ or Nginx 1.18+
- 512MB RAM
- 100MB disk space

## 👨‍💻 Developer

**Developed by [Websaaz Solutions](https://www.facebook.com/websaazsolution/)**

- 🌐 Website: [Facebook Page](https://www.facebook.com/websaazsolution/)
- 💼 Services: Web Development, POS Systems, E-commerce Solutions

## 📞 Support

For support and queries:
1. Create an issue on GitHub
2. Contact through [Websaaz Solutions Facebook Page](https://www.facebook.com/websaazsolution/)

## 🗂️ Project Structure

```
pos-system/
├── application/
│   ├── controllers/
│   │   ├── Auth.php           # Login/logout
│   │   ├── Billing.php        # Bill management
│   │   ├── Customer.php       # Customer management
│   │   ├── Dashboard.php      # Dashboard page
│   │   ├── Inventory.php      # Product management
│   │   ├── Pos.php           # POS functions
│   │   └── Settings.php      # System settings
│   ├── models/
│   │   ├── Admin_model.php    # Admin authentication
│   │   ├── Billing_model.php  # Bill operations
│   │   ├── Customer_model.php # Customer operations
│   │   ├── Inventory_model.php# Product operations
│   │   └── Settings_model.php # Settings operations
│   ├── views/
│   │   ├── auth/             # Login page
│   │   ├── billing/          # Bill pages
│   │   ├── customer/         # Customer pages
│   │   ├── dashboard/        # Dashboard page
│   │   ├── inventory/        # Inventory pages
│   │   ├── settings/         # Settings page
│   │   └── templates/        # Header/footer
│   ├── libraries/
│   │   └── Pdf.php          # PDF generation
│   └── config/              # Configuration files
├── assets/
│   ├── css/                 # Local stylesheets
│   ├── js/                  # Local JavaScript
│   └── fonts/               # Local font files
├── system/                  # CodeIgniter system
├── database.sql             # Database structure
└── README.md               # This file
```

## 🔄 Current Version: 1.0.0

### **Available Features**
- ✅ Complete bill management (create, edit, view, delete)
- ✅ Customer management with foreign key protection
- ✅ Inventory management with stock tracking
- ✅ PDF bill generation and export
- ✅ Dashboard with basic statistics
- ✅ Admin authentication system
- ✅ Responsive design for all devices
- ✅ Local assets (no internet dependency)
- ✅ Urdu language support with RTL
- ✅ SweetAlert confirmations for deletions
- ✅ Form validation and error handling

---

⭐ **If you find this project helpful, please give it a star!** ⭐

**Built with ❤️ for small businesses in Pakistan** # billing-system

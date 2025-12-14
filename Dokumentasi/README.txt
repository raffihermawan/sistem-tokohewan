================================================================================
SISTEM INFORMASI PETSHOP - PETSHOP MANAGEMENT SYSTEM
PHP Native + MySQL | Bootstrap 5 | Role-Based Access
================================================================================

DAFTAR FILE & FOLDER:
Lihat file DOKUMENTASI.txt untuk struktur lengkap & penjelasan detail semua file.

INSTALASI SINGKAT:
================================================================================

1. SETUP DATABASE
   - Buka phpMyAdmin (http://localhost/phpmyadmin/)
   - Create database baru atau import langsung
   - Import file: sql/petshop.sql
   - Database "petshop" akan terbuat otomatis dengan semua table

2. SETUP CONFIG
   - Edit file: config.php
   - Pastikan koneksi database sesuai:
     * DB_HOST: 127.0.0.1 (default localhost)
     * DB_NAME: petshop (sesuaikan nama database)
     * DB_USER: root (sesuaikan user MySQL)
     * DB_PASS: "" (kosong untuk default XAMPP)

3. BUAT ADMIN DEFAULT
   - Buka browser: http://localhost/sistem-tokohewan/create_admin.php
   - Tunggu pesan "Default admin created"
   - Jangan jalankan lagi (admin sudah ada)

4. LOGIN
   - Buka: http://localhost/sistem-tokohewan/
   - Email: admin@petshop.local
   - Password: admin123

DEFAULT CREDENTIALS:
================================================================================
Email: admin@petshop.local
Password: admin123
Role: Admin

FITUR UTAMA:
================================================================================

AUTHENTICATION & SECURITY:
✓ Password hashing dengan password_hash() & verification
✓ Role-based access control (Admin, Kasir, Owner)
✓ SQL Injection prevention (prepared statements)
✓ Output escaping & input sanitization
✓ Session management & login requirement

DASHBOARD (Role-specific):
✓ Admin Dashboard: Total customers, pets, users, sales
✓ Kasir Dashboard: Today transactions, revenue, customers
✓ Owner Dashboard: Revenue, inventory value, transactions

MANAGEMENT MODULES:
✓ Customers: Create, Read, Update, Delete, View
✓ Pets: Create, Read, Update, Delete, View + stock tracking
✓ Suppliers: Create, Read, Update, Delete, View
✓ Users: Create, Read, Update, Delete (admin only)

SALES TRANSACTION:
✓ Create sale dengan multiple items
✓ Auto calculation: qty × price = subtotal
✓ Auto total: sum semua subtotal
✓ Stock automatic update setelah sale
✓ Invoice generation
✓ Printable invoice (auto print dialog)
✓ Inventory history logging

INVENTORY MANAGEMENT:
✓ Stock monitor (view semua pets + current stock)
✓ Add stock (input qty + note)
✓ Reduce stock (input qty + note)
✓ History tracking (semua perubahan stock tercatat)

REPORTS:
✓ Sales Report: Filter by date, show total revenue
✓ Stock Report: All pets, calculate total inventory value
✓ Customer Report: Total transactions & spending per customer

API ENDPOINTS (JSON):
✓ /api/search.php?q=keyword → search pets & customers
✓ /api/get_pet.php?id=1 → get pet details
✓ /api/get_customer.php?id=1 → get customer details

USER INTERFACE:
✓ Responsive Bootstrap 5 design
✓ Dark sidebar navigation (role-aware)
✓ Professional dashboard cards & KPI display
✓ Dynamic form validation
✓ Table pagination ready
✓ Print-friendly pages

STRUKTUR FOLDER:
================================================================================
sistem-tokohewan/
├─ sql/petshop.sql ..................... Database schema & sample data
├─ config.php .......................... Database connection config
├─ init.php ............................ Bootstrap file (load all modules)
├─ index.php ........................... Root redirect handler
├─ create_admin.php .................... Admin generator script
├─ README.txt .......................... File ini
├─ DOKUMENTASI.txt ..................... Full documentation (Indo)
│
├─ assets/ ............................. Static files
│  ├─ css/style.css .................... Custom styling
│  ├─ js/script.js ..................... Helper functions
│  ├─ images/logo.txt .................. Logo placeholder
│  └─ uploads/ ......................... For user file uploads
│
├─ auth/ ............................... Authentication
│  ├─ login.php ........................ Login form
│  ├─ register.php ..................... User registration
│  └─ logout.php ....................... Logout handler
│
├─ core/ ............................... Core modules
│  ├─ session.php ...................... Session management
│  ├─ role.php ......................... Role middleware
│  ├─ security.php ..................... Sanitization functions
│  └─ helpers.php ...................... Helper functions
│
├─ templates/ .......................... Reusable templates
│  ├─ header.php ....................... Page header & bootstrap import
│  ├─ footer.php ....................... Page footer & scripts
│  ├─ sidebar.php ...................... Navigation menu
│  └─ topbar.php ....................... Top navigation bar
│
├─ dashboard/ .......................... Dashboard pages
│  ├─ index.php ........................ Generic dashboard
│  ├─ admin.php ........................ Admin dashboard
│  ├─ kasir.php ........................ Kasir dashboard
│  └─ owner.php ........................ Owner dashboard
│
├─ customers/ .......................... Customer management
├─ pets/ ............................... Pet management
├─ suppliers/ .......................... Supplier management
├─ users/ .............................. User management
├─ sales/ .............................. Sales & invoicing
├─ inventory/ .......................... Stock management
├─ api/ ................................ JSON API endpoints
└─ reports/ ............................ Report pages

MENGGUNAKAN SISTEM:
================================================================================

ADMIN:
- Manage users (create, edit, delete)
- View admin dashboard dengan KPI
- Akses semua menu
- Create/manage customers, pets, suppliers

KASIR:
- Create & view sales transactions
- Create invoices & print
- Manage customers & pets
- View kasir dashboard
- Tidak bisa manage users

OWNER:
- View reports & analytics
- Monitor inventory value
- View owner dashboard
- Read-only access ke semua data

MEMBUAT SALE:
1. Menu Sales → New Sale
2. Pilih customer (optional)
3. Add items: pilih pet, qty akan otomatis hitung total
4. Click "Process Sale"
5. Sistem akan update stock otomatis
6. View invoice atau print

MANAGE STOCK:
1. Menu Inventory
2. Tab "Add Stock" untuk tambah stock
3. Tab "Reduce Stock" untuk kurangi stock
4. Tab "History" untuk melihat log semua perubahan
5. Note akan otomatis dicatat

MEMBUAT LAPORAN:
1. Menu Reports
2. Pilih jenis laporan: Sales, Stock, atau Customer
3. Filter by date (jika ada)
4. Data akan ditampilkan dalam table
5. Bisa print dari browser (Ctrl+P)

TIPS & TROUBLESHOOTING:
================================================================================

Database Error?
- Pastikan MySQL service running
- Cek config.php (host, database name, user, password)
- Cek phpmyadmin bahwa database sudah di-import

Login gagal?
- Pastikan database sudah di-import
- Pastikan create_admin.php sudah dijalankan
- Coba gunakan default: admin@petshop.local / admin123

Page not found?
- Pastikan folder struktur sesuai
- Cek path di config.php (BASE_URL)
- Cek webserver berjalan

Syntax error?
- Cek PHP version (min PHP 7.4)
- Cek semua <?php dan ?> tags tertutup
- Cek database encoding utf8mb4

CUSTOMIZATION:
================================================================================

Mengganti logo:
- Ganti assets/images/logo.png (size: 200x60px recommended)
- Atau edit templates/sidebar.php

Mengganti warna:
- Edit assets/css/style.css
- Atau langsung di templates (class="bg-primary", etc)

Menambah field database:
- Edit sql/petshop.sql
- Add kolom baru di table
- Update form di halaman CRUD

Menambah role baru:
- Edit sql/petshop.sql (enum values di users table)
- Update core/role.php
- Create dashboard halaman baru
- Add menu di templates/sidebar.php

BACKUP & RESTORE:
================================================================================

Backup Database:
1. phpMyAdmin → Select database "petshop"
2. Export → Download as SQL file

Restore Database:
1. phpMyAdmin → Import → Select SQL file
2. Database akan di-restore otomatis

PRODUCTION CHECKLIST:
================================================================================

□ Change database password di config.php
□ Remove create_admin.php (atau protect with IP)
□ Add error logging (jangan show error ke user)
□ Setup proper file permissions (chmod 755 folders, 644 files)
□ Enable HTTPS/SSL
□ Add rate limiting untuk API
□ Add CSRF token protection
□ Implement proper session timeout
□ Add audit logging (who did what & when)
□ Regular database backups
□ Test disaster recovery procedure
□ Setup monitoring & alerts

SUPPORT & DOCUMENTATION:
================================================================================

Full documentation: DOKUMENTASI.txt
Bug report: Check ini jika ada error pada halaman
Help: Review code comments di setiap file

KONEKSI DATABASE (config.php):
================================================================================

define('DB_HOST', '127.0.0.1');        // MySQL Host
define('DB_NAME', 'petshop');           // Database name
define('DB_USER', 'root');              // MySQL user
define('DB_PASS', '');                  // MySQL password
define('BASE_URL', '/sistem-tokohewan'); // Application base URL

PERSYARATAN:
================================================================================
- PHP >= 7.4 (lebih baik 8.0+)
- MySQL >= 5.7 atau MariaDB
- Composer (optional, tidak dipakai di versi ini)
- Web browser modern (Chrome, Firefox, Safari, Edge)

CREATED BY:
GitHub Copilot | December 2024

LISENSI:
Boilerplate code untuk keperluan bisnis Anda.
Feel free to customize & modify sesuai kebutuhan.

================================================================================

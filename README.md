# 📑 Tender Management System (TMS)

A complete **Tender Management System** built using **PHP, MySQL, HTML, CSS, and JavaScript**.  
This system helps organizations manage tenders, companies, vendors, users, documents, reports, and approvals efficiently with role-based access control.

---

## 🚀 Features Overview

### 🔐 Authentication & Authorization
- Secure login & logout system
- Password hashing
- Session-based authentication
- Role-Based Access Control (RBAC)

### 👥 User Management
- Add, edit, delete users
- User roles:
  - Admin
  - Auditor
  - Reviewer
  - Tender Creator
  - Vendor
- Account status control (Active / Inactive / Suspended)
- Profile management

### 🏢 Company Management
- Add tender companies
- **Duplicate company name prevention**
- Company description support
- Company listing & management

### 📄 Tender Management
- Create and manage tenders
- Assign tenders to companies
- Tender status tracking
- Document upload & management
- Tender deadlines & notifications

### 📊 Dashboard
- Total tenders
- Active tenders
- Total companies
- Registered vendors
- Recent activities
- Quick navigation widgets

### 📑 Reports Module
- Tender reports
- Company-wise tender reports
- Vendor participation reports
- Date-wise filtering
- Export ready (PDF/Excel ready structure)

### 🧾 Audit & Logs
- User activity logs
- Tender action logs
- Login history
- System event tracking

### 🎨 UI/UX
- Modern responsive UI
- Fixed sidebar (150px width, icon-based)
- Glassmorphism design
- Light / Dark mode support
- Clean admin panel layout

---

## 🛠️ Technology Stack

| Layer | Technology |
|------|------------|
| Backend | PHP (Procedural / MySQLi) |
| Database | MySQL |
| Frontend | HTML5, CSS3, JavaScript |
| UI Design | Custom CSS (Glassmorphism) |
| Security | Prepared statements, RBAC |

---

## 📂 Project Structure

tender-management-system/
├── config/
│   ├── database.php
│   ├── database_create.sql
│   ├── auth.php
│   └── system_settings.php   ← helper file
├── assets/
│   ├── css/
│   │   ├── auth.css
│   │   ├── dashboard.css
│   │   ├── companies.css
│   │   ├── tenders.css
│   │   ├── search.css
│   │   ├── includes.css
│   │   ├── system.css
│   │   ├── profile.css
│   │   ├── includes.css
│   │   ├── reports.css
│   │   └── style.css
│   └── js/
│   │   ├── auth.js
│   │   ├── dashboard.js
│   │   ├── companies.js
│   │   ├── tenders.js
│   │   ├── search.js
│   │   ├── includes.js
│   │   ├── system.js
│   │   ├── profile.js
│   │   ├── includes.js
│   │   ├── reports.js 
│       └── main.js
├── uploads/
│   └── tender_documents/
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── dashboard/
│   └── dashboard.php
├── companies/
│   ├── add_company.php
│   ├── edit_company.php
│   ├── delete_company.php
│   └── company_list.php
├── tenders/
│   ├── add_tender.php
│   ├── edit_tender.php
│   ├── delete_tender.php
│   ├── tender_management.php
│   ├── view_tender_list_page.php
│   └── view_all_tender_list.php
├── search/
│   ├── global_search.php
│   ├── view_search_result.php
│   └── search_history.php
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── access.php
vendors/
├── add_vendor.php
├── edit_vendor.php
├── delete_vendor.php
├── vendor_list.php
├── vendor_view.php

├── reports/
│   ├── tender_report.php
│   ├── vendor_report.php
│   ├── user_report.php
│   ├── financial_report.php
│   ├── audit_report.php
│   └── custom_report.php
├── system/
│   ├── system_information.php
│   ├── system_settings_save.php
│   ├── system_settings_reset.php
│   └── system_setting.php
├── profile/
│   ├── user_profile_information.php
│   ├── user_profile_settings.php
│   └── user_profile_save.php
├── you_not_access_this_page.php
├── index.php
└── README.md


| File / Folder                       | Admin | Auditor | Reviewer | Tender Creator | Vendor | Notes                                             |
| ----------------------------------- | ----- | ------- | -------- | -------------- | ------ | ------------------------------------------------- |
| `index.php`                         | ✅     | ✅       | ✅        | ✅              | ✅      | Login page redirect                               |
| `auth/login.php`                    | ✅     | ✅       | ✅        | ✅              | ✅      | Public access for login                           |
| `auth/register.php`                 | ✅     | ❌       | ❌        | ❌              | ❌      | Only Admin can create users, or self-registration |
| `auth/logout.php`                   | ✅     | ✅       | ✅        | ✅              | ✅      | Everyone logged in can logout                     |
| `dashboard/dashboard.php`           | ✅     | ✅       | ✅        | ✅              | ✅      | Dashboard visibility based on role                |
| `companies/add_company.php`         | ✅     | ❌       | ❌        | ❌              | ❌      | Only Admin                                        |
| `companies/edit_company.php`        | ✅     | ❌       | ❌        | ❌              | ❌      | Only Admin                                        |
| `companies/delete_company.php`      | ✅     | ❌       | ❌        | ❌              | ❌      | Only Admin                                        |
| `companies/company_list.php`        | ✅     | ✅       | ✅        | ✅              | ❌      | Vendors may not see company list                  |
| `tenders/add_tender.php`            | ✅     | ❌       | ❌        | ✅              | ❌      | Tender Creator & Admin                            |
| `tenders/edit_tender.php`           | ✅     | ❌       | ❌        | ✅              | ❌      | Tender Creator & Admin                            |
| `tenders/delete_tender.php`         | ✅     | ❌       | ❌        | ❌              | ❌      | Only Admin                                        |
| `tenders/tender_management.php`     | ✅     | ✅       | ✅        | ✅              | ❌      | Admin + Tender Creator + Reviewer                 |
| `tenders/view_tender_list_page.php` | ✅     | ✅       | ✅        | ✅              | ✅      | All can view tenders                              |
| `tenders/view_all_tender_list.php`  | ✅     | ✅       | ✅        | ✅              | ✅      | All can view tenders                              |
| `search/global_search.php`          | ✅     | ✅       | ✅        | ✅              | ✅      | Everyone can search                               |
| `search/view_search_result.php`     | ✅     | ✅       | ✅        | ✅              | ✅      | Everyone can view search results                  |
| `search/search_history.php`         | ✅     | ✅       | ❌        | ❌              | ❌      | Admin + Auditor only                              |
| `includes/header.php`               | ✅     | ✅       | ✅        | ✅              | ✅      | Needed for all pages                              |
| `includes/footer.php`               | ✅     | ✅       | ✅        | ✅              | ✅      | Needed for all pages                              |
| `includes/access.php`               | ✅     | ✅       | ✅        | ✅              | ✅      | RBAC check helper                                 |
| `uploads/tender_documents/`         | ✅     | ✅       | ✅        | ✅              | ✅      | Access controlled by tender page                  |

Summary by Role
1. Admin

Full access to everything

Can manage users, companies, tenders, search, history

2. Auditor

Read-only: dashboard, tender lists, search, search history

Cannot create/edit/delete tenders or companies

3. Reviewer

Can view tenders, tender management table

Can review/evaluate tenders

Cannot create companies, users, or delete anything

4. Tender Creator

Can add/edit tenders

Can view tender management pages

Cannot delete companies, tenders, or view search history

5. Vendor

Can view tender lists, global search, view search results

Cannot add/edit/delete anything

Cannot see company list in some cases


---

## 🧩 Database Highlights

### `users` Table
- id (Primary Key)
- full_name
- username (Unique)
- email (Unique)
- password (Hashed)
- role_name
- account_status
- last_login

### `tender_companies` Table
- id (Primary Key)
- company_name (**Unique**)
- description
- created_at

---

## 🔒 Security Measures

- SQL Injection protection (Prepared Statements recommended)
- Password hashing (`password_hash`)
- Session validation
- Role-based page access (`checkRole()` helper)
- Input sanitization

---

## ⚙️ Installation Guide

### 1️⃣ Clone or Download
```bash
git clone https://github.com/your-repo/tender-management-system.git

2️⃣ Setup Database

Create database: tender_management_system

Import database.sql into MySQL

3️⃣ Configure Database

Edit:
config/database.php

$conn = mysqli_connect("localhost", "root", "", "tender_management_system");

4️⃣ Run Project

Place project in htdocs (XAMPP)

Open browser:

http://localhost/tender-management-system


📈 Future Enhancements

Email notifications

PDF & Excel export

Advanced analytics

REST API support

File versioning

Multi-language support

🤝 Contribution

Contributions are welcome!
Please fork the repository and submit a pull request.


📞 Support

For support or customization, contact:
📧 support@tendermanagementsystem.com

⭐ Acknowledgement

Developed with ❤️ for efficient tender handling and enterprise-grade management.


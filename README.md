````md
# Ecommerce Platform – Ideartics

An e-commerce platform developed with **Yii2 Framework**, focused on user management, distributor approval, and automatic generation of PDF contracts.

This project is part of my **professional portfolio** and demonstrates strong backend development skills, MVC architecture, security best practices, and real production deployment.

---

## 🌐 Live Project

The application is deployed and available at:

👉 https://ideartics.com/ecommerce/web/

---

## 🧩 Project Overview

The system allows administrators to manage users and approve them as **official distributors**, automatically generating a **personalized PDF contract** for each approved user.

The main goals of this project are:

- Clean and maintainable code
- Secure backend logic
- Proper use of Yii2 MVC architecture
- Real-world production setup

---

## 🛠️ Tech Stack

- **PHP 7.x**
- **Yii2 Framework**
- **MySQL**
- **mPDF** (PDF generation)
- HTML5 / CSS3
- JavaScript
- Apache / Nginx
- Linux Server

---

## ✨ Key Features

- User management (CRUD)
- Secure password update
- Distributor approval workflow
- Dynamic PDF contract generation
- Secure password hashing
- Admin panel
- MVC-based architecture

---

## 📄 PDF Contract Generation

From the **Users** module, administrators can generate a PDF contract containing:

- First name and last name
- Identification number
- User code
- Distributor approval statement
- Issue date

The PDF is generated dynamically using **mPDF** and opens in a new browser tab.

---

## ⚙️ Database Configuration

Example of `config/db.php` (sample credentials):

```php
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=ecommerce',
    'username' => 'db_user',
    'password' => 'db_password',
    'charset' => 'utf8',
];
```
````

> ⚠️ **Note:**
> Real database credentials are not included in the repository for security reasons.

---

## 🚀 Local Setup

1. Clone the repository:

   ```bash
   git clone <repository-url>
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Configure the database:

   ```
   config/db.php
   ```

4. Set required permissions:

   ```bash
   chmod -R 775 runtime web/assets
   ```

5. Access the application:

   ```
   http://localhost/ecommerce/web
   ```

---

## 🔐 Security

- Passwords are stored using secure hashing (`Yii::$app->security`)
- No plain-text passwords are stored
- PDF temporary files are handled outside the `vendor` directory

---

## 👩‍💻 Author

**Diana Flórez**
Systems Engineer
Full Stack Web & Mobile Developer
Specialized in Yii2, PHP, JavaScript, and MVC architecture

---

## 📬 Contact

This project is available for technical evaluation and professional review.
For more information, please get in touch.

```

```

# GiveHope: System Documentation

## 1. System Overview
**GiveHope** is a robust, web-based donation platform developed using the Laravel 12 framework. The platform automates the creation of fundraising campaigns, secure digital donations, and withdrawal management. It incorporates secure integrations with localized payment gateways including M-Pesa and Paynecta, ensuring transparency and accountability for both donors and campaigners.

---

## 2. Technology Stack
- **Backend Framework:** Laravel 12 (PHP 8.2+)
- **Frontend Assets:** Vite, TailwindCSS v3, Alpine.js
- **Database:** Relational Database (MySQL / SQLite / TiDB) accessed via Eloquent ORM
- **Payment Gateways:** M-Pesa (via C2B/STK callbacks and B2C for withdrawals), Paynecta

---

## 3. System Architecture & Features

### 3.1. Core Entities (Models)
The system is built around six primary Eloquent Models ensuring normalized data relationships:
- **User:** Manages authentication and roles (Standard User vs. Admin / Staff).
- **Campaign:** Represents a fundraising goal. Contains attributes like title, description, goal amount, image paths, and verification status.
- **CampaignUpdate:** Allows organizers to post status updates and news regarding a specific campaign.
- **Donation:** Tracks individual financial contributions linked to a campaign. It records the amount, payer email, anonymity preference, and transaction status (pending/success).
- **Withdrawal:** Manages requests by campaigns to disburse accumulated funds out of the platform.
- **ContactMessage:** Captures inquiries and support requests from the public site.

### 3.2. User Workflows
- **Public / Donors:**
  - Browse available, verified campaigns on the home page.
  - Make donations seamlessly via M-Pesa or Paynecta.
  - View the impact and overall metrics of the GiveHope platform.
  - Send messages through the contact form.
- **Registered Donors / Campaigners:**
  - Access a personalized dashboard (`/dashboard`) summarizing their donation history and totals.
  - Manage profile settings securely.

### 3.3. Administrator Workflows
Administrators access a protected suite of tools within the `/admin/*` routing prefix (guarded by the `admin` middleware).
- **Dashboard:** High-level metrics of platform performance.
- **Campaign Management:** Create, edit, verify, and delete campaigns. Administrators also have the authority to post campaign updates.
- **Donation Management:** View all incoming transactional states and export donation records for auditing.
- **Withdrawal Management:** Inspect requested payouts and formally approve withdrawals (integrated with M-Pesa B2C).
- **Staff Management:** Assign platform management capabilities to multiple staff users.
- **Message Management:** Read and address contact messages submitted by public users.

---

## 4. API & External Integrations

### 4.1. M-Pesa Integration
- **Incoming Donations (C2B):** Webhooks are configured at `/api/mpesa/callback` and `/mpesa/callback` to securely receive confirmation payloads from Safaricom. The `DonationController` matches these to pending donations and upgrades the status to `success` asynchronously.
- **Disbursements (B2C):** M-Pesa B2C logic handles approved withdrawals returning result codes to `/api/mpesa/b2c/result` and timeouts to `/api/mpesa/b2c/timeout`.

### 4.2. Paynecta Integration
- Webhooks are configured at `/api/paynecta/callback` and `/paynecta/callback` to confirm third-party processed payments.

---

## 5. Security Measures
- **Authentication & Authorization:** Standard Laravel Auth scaffolding paired with specific middleware (`auth`, `admin`) to strictly segment public and administrative functions.
- **API Security:** API callback endpoints validate payloads to prevent spoofed 'success' requests from artificially inflating campaign totals.
- **Rate-Limiting:** Routes like `/donate` utilize the `throttle:10,1` middleware to mitigate spam and automated submission attacks.
- **Password Integrity:** Bcrypt hashing relies upon strict iteration counts configured by the environment variables.

---

## 6. Directory Structure Overview
- `app/Models/`: Contains the Eloquent ORM definitions (User, Campaign, Donation, etc.).
- `app/Http/Controllers/`: Contains the business logic splitting responsibilities across `CampaignController`, `DonationController`, `AdminController`, and callback controllers.
- `routes/web.php`: Primary mapping for frontend web requests and external gateway webhooks.
- `resources/views/`: Blade templates customized with Tailwind CSS representing the user interface.

---

*This document was exclusively generated based on the source code and configuration layout of the GiveHope web application layer.*

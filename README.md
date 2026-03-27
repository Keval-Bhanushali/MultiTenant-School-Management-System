
# AuraCampus: Multi-Tenant School Management System

> **AuraCampus** is an ultra-premium, SaaS-based, multi-tenant school management platform designed for modern K-12 and higher education institutions. It features a 4D glassmorphism UI/UX, advanced ERP modules, mobile readiness, and robust role-based access control.

## Features

- Multi-tenant architecture (single database, tenant_id driven)
- Role-based access (Superadmin, Admin, Staff, Teacher, Student, Parent, Alumni)
- Cashless Campus (Wallets, NFC/QR transactions)
- Notices & Communication (polymorphic, multilingual, WhatsApp/email integration)
- Document Vault (secure uploads: Aadhaar, PAN, marksheets)
- Calendar & Recurring Tasks (exam timetables, cron jobs)
- Dynamic Finance & HR (payroll, fee payment with Stripe/Razorpay)
- Predictive Analytics (AI early warning for at-risk students)
- Alumni Network & Placement
- AI Attendance (Face Detection, Bluetooth proximity)
- Automated AI Grading & Lesson Generation
- Gamification (House Points leaderboard)
- Real-time GPS & WebRTC (bus tracking, live classes)
- Mobile API endpoints (Sanctum, Camera, Bluetooth, GPS)
- Ultra-premium 4D glassmorphism UI (Tailwind CSS, Vite, Chart.js, Heroicons, tsparticles)

## Tech Stack

- **Backend:** Laravel 12 (PHP), MongoDB
- **Frontend:** Blade, Tailwind CSS, Vite, Chart.js, Heroicons
- **Mobile:** Capacitor-ready, API endpoints for native features
- **Payments:** Razorpay

## Database Structure (MongoDB)

- `tenants`: id, domain, name, settings, subscription_plan
- `users`: id, tenant_id, role_id, permissions, ...
- `wallets`, `transactions`: student balances, NFC/QR
- `notices`: polymorphic, multilingual
- `documents`: user_id, type, file_path
- `schedules`, `recurring_tasks`: exam timetables, cron jobs

## Role-Based Module Permissions

- Each school can assign module permissions to roles/users.
- Permissions are stored as an array in the user/role document (e.g., `permissions: ["attendance", "finance", ...]`).
- Blade and controller checks ensure only allowed modules are visible/accessible.

## Setup & Development

1. Clone the repo and install dependencies:
	```bash
	git clone <repo-url>
	cd multi-tenant-school-management-system
	composer install
	npm install && npm run dev
	```
2. Configure your `.env` for MongoDB, mail, and payment gateways.
3. Run the server:
	```bash
	php artisan serve
	```
4. (Optional) For mobile: Wrap in Capacitor shell and use provided API endpoints.

## License

This project is open-sourced under the MIT license.

# 🚗 Car Online Sale System (COSS) — Premium Edition

A highly modernized, full-stack automotive marketplace designed to simulate a real-world, high-end car dealership experience. Built with robust PHP, highly-structured CSS, JavaScript, and a relational MySQL architecture.

---

## 📌 Project Overview
COSS is a robust, dynamic platform where Buyers and Sellers can interact seamlessly. Recently completely overhauled to incorporate a premium visual design language, the system now features structured Live Messaging, comprehensive User Profiles, and an advanced cryptographic File Upload Engine capable of natively parsing modern mobile image formats.

---

## ✨ Premium Upgrades & Core Features

### 🎨 The "Digital Curator" Design System
- **Editorial Aesthetics:** Utilizes a highly structured, minimalist layout inspired by premium physical automotive showrooms.
- **Interactive UI Components:** Smooth backdrop filters, glassmorphism `navbar.php` techniques, crisp hover states, and advanced CSS grid/flex structuring.
- **Cinematic Car Details:** Rebuilt product listing interfaces (`car-details.php`) highlighting edge-to-edge photography, verified seller badges, and dynamic quick-spec matrices.
- **Landscape Gallery:** Featured listings now utilize a cinematic 3:2 landscape aspect ratio to showcase vehicle aesthetics at their best.

### 🧑‍💼 User Profiles & Public Trust ⭐️
- **Custom Uploadable Avatars:** Real-time uploadable profile pictures linking user identity across the entire marketplace.
- **Aggregated 5-Star Reputation Engine:** Feedback and review ratings are captured numerically and automatically averaged, displaying verified seller trust scores and review timelines directly on their public profile.
- **Role-Based Permissions:** Feedback and rating mechanisms are strictly enforced—only verified Buyers can leave reviews for Sellers, ensuring platform integrity.
- **Dual-Mode Profile Dashboard:** An integrated `profile.php` gateway that intelligently switches between an active "Editor Mode" (for managing personal contact & bio details) and a "Public Showcase Portfolio" (when viewed by visiting buyers).

### 💬 Threaded Live Messaging & Transactions
- **Secure Messaging Engine:** Internal messaging (`messages.php`) bypasses outdated email workflows. Cleanly organizes conversations into threads by user and vehicle.
- **Direct Transaction Management:** Sellers can mark vehicles as **SOLD** directly within the chat thread. 
- **Smart Listing Hiding:** Upon marking a car as sold, sellers are prompted with a smart option to immediately hide the listing from the public marketplace (Homepage/Search) while keeping it archived on their private profiles for record-keeping.
- **Real-time Status Sync:** The marketplace automatically reflects "SOLD" or "AVAILABLE" status across all views instantly upon transaction.

### 📸 Next-Generation File Handling
- **Apple HEIC & WebP Universal Support:** Advanced server logic using PHP `finfo` intelligently detects, hashes, and processes iPhone HEIC format files natively without forcing users to digitally pre-convert images on external tools.
- **Interactive Drop-Zone UX:** Custom JS Drag-and-Drop mechanics seamlessly replacing rigid legacy OS file inputs across the seller listing views and profile portals.

---

## 📂 Revamped Architecture

```text
api/            → Secure processing endpoints (logout, profile_upload, send_message, messages_poll)
assets/         → Centralized vault for modular CSS, JS, and categorized image storage (cars/ & profiles/)
config/         → Core DB connectivity and dynamic programmatic schema builders (create_tables.php)
controllers/    → Business logic isolation (Index, Car, Search, Messages, Feedback)
includes/       → Reusable modular components (navbar, footer, html headers)
views/          → Clean template files for separation of concerns
*.php           → Entry points/Routes (index, search, cars, messages, etc.)
```

---

## 🚀 How to Run the Project Locally

1. Install a local PHP/MySQL environment (e.g., XAMPP, MAMP).
2. Clone this repository tightly into your native `htdocs` server directory (ideally named `/coss`).
3. Boot up Apache and MySQL processes.
4. **Auto-Setup:** No manual SQL dumps required! Just run `http://localhost/coss/config/create_tables.php` once in your browser to immediately synthesize the relational table architecture and schemas.
5. **Launch:** Navigate to `http://localhost/coss/index.php`.

*(Note: File upload limits in XAMPP may need to be slightly expanded to process raw 10MB+ Apple HEIC photos cleanly, please refer to the included `.htaccess` configuration).*

---

## 🔐 Built-in Security

- **Database Integrity:** Automatic schema migration ensures all necessary columns exist on every deployment.
- **File Security:** Cryptographic SHA-1 File System rewriting to avoid malicious code execution.
- **Form Protection:** Global 32-Byte Session CSRF Token protection injected onto all POST forms.
- **SQL Sanitization:** Complete Prepared Statement mapping blocking SQL-Injection.

---

## 🎯 Author
**Bhupinder Singh**  
Bachelor of Information Technology  
*Full-Stack Web Development Enthusiast*  

Open to internship and collaboration opportunities! If you like the architecture of this project, feel free to fork or star the repository ⭐

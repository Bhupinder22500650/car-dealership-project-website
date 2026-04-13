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

### 🧑‍💼 User Profiles & Public Trust ⭐️
- **Custom Uploadable Avatars:** Real-time uploadable profile pictures linking user identity across the entire marketplace.
- **Aggregated 5-Star Reputation Engine:** Feedback and review ratings are captured numerically and automatically averaged, displaying verified seller trust scores and review timelines directly on their public profile.
- **Dual-Mode Profile Dashboard:** An integrated `profile.php` gateway that intelligently switches between an active "Editor Mode" (for managing personal contact & bio details) and a "Public Showcase Portfolio" (when viewed by visiting buyers).

### 💬 Threaded Live Messaging Center
- Built a secure internal messaging engine (`messages.php`) bypassing outdated direct email workflows.
- Cleanly organizes incoming/outgoing messages into grouped threads associated with specific users and specific vehicles.
- Intelligently populates Dynamic Avatars, allowing buyers and sellers to click directly on faces in-chat to view each other's credentials.

### 📸 Next-Generation File Handling
- **Apple HEIC & WebP Universal Support:** Advanced server logic using PHP `finfo` intelligently detects, hashes, and processes iPhone HEIC format files natively without forcing users to digitally pre-convert images on external tools.
- **Interactive Drop-Zone UX:** Custom JS Drag-and-Drop mechanics seamlessly replacing rigid legacy OS file inputs across the seller listing views and profile portals.

---

## 📂 Revamped Cloud Architecture

```text
api/            → Secure processing endpoints (logout, profile_upload, send_message, upload_handler)
assets/         → Centralized vault for modular CSS, JS, and categorized image storage (cars/ & profiles/)
config/         → Core DB connectivity and dynamic programmatic schema builders (create_tables.php)
includes/       → Reusable modular components (navbar, footer, html headers)
*.php           → Core Frontend Views (index, search, cars, car-details, messages, profile, feedback)
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

- Cryptographic SHA-1 File System rewriting to avoid malicious code execution.
- Global 32-Byte Session CSRF Token protection injected onto all POST forms.
- Complete Prepared Statement mapping blocking SQL-Injection.

---

## 🎯 Author
**Bhupinder Singh**  
Bachelor of Information Technology  
*Full-Stack Web Development Enthusiast*  

Open to internship and collaboration opportunities! If you like the architecture of this project, feel free to fork or star the repository ⭐

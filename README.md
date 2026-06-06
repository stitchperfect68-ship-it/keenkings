# Keenkings Media — Portfolio Website

**Photography · Videography · Graphic Design · Lusaka, Zambia · Est. 2016**

A full-stack Laravel 11 portfolio website with a complete admin panel for managing all front-end content.

---

## 🚀 Quick Setup (5 steps)

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (optional, for Vite assets)

---

### Step 1 — Install Dependencies

```bash
composer install
```

---

### Step 2 — Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Then edit `.env` and set your database credentials:

```env
DB_DATABASE=keenkings_media
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

### Step 3 — Create Database

In MySQL:
```sql
CREATE DATABASE keenkings_media CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Step 4 — Run Migrations & Seed

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

The seeder creates:
- ✅ Default admin user
- ✅ 3 hero slides
- ✅ About content
- ✅ 4 stats (8 yrs, 500+ projects, 200+ clients, 15+ awards)
- ✅ 6 services
- ✅ 4 testimonials
- ✅ 24 portfolio items across all categories

---

### Step 5 — Start the Server

```bash
php artisan serve
```

Open **http://localhost:8000**

---

## 🔐 Admin Panel

**URL:** http://localhost:8000/admin

**Default credentials:**
| Field | Value |
|-------|-------|
| Email | `admin@keenkingsmedia.com` |
| Password | `keenkings2016` |

> ⚠️ Change the password after first login via the database or by adding a profile page.

---

## 📋 Admin Panel Features

| Section | Features |
|---------|----------|
| **Dashboard** | Stats overview, recent portfolio, recent enquiries |
| **Hero Slides** | Add/edit/delete slides, upload images or use URLs, toggle active/hidden, sort order |
| **About** | Edit all about section text, main & accent images, founding year, pillars |
| **Stats Bar** | Add/edit/delete counter stats (e.g. "500+ Projects Done") |
| **Services** | Full CRUD — icon, title, description, bullet items, active toggle |
| **Testimonials** | Full CRUD — quote, name, role, sort order, active toggle |
| **Portfolio** | Full CRUD — parent category, sub-category, title, grid size, image upload/URL, video URL, bulk delete, visibility toggle, filters |
| **Enquiries** | View all contact form submissions, update status (new/read/replied/archived), reply via email |

---

## 🗂 Portfolio Categories

### Photography
Graduation · Wedding · Chilanga-Mulilo · Indoor · Outdoor · Studio · Corporate · Creative

### Videography
Wedding · Corporate · Creative · Nature · Time-Lapse · Product · Fashion

### Graphics
Logo Design · Brochure Layout · Web Banner · Social Media Post · Infographic · Packaging Design

### Grid Sizes
| Value | Appearance |
|-------|-----------|
| *(empty)* | 1×1 Square |
| `wide` | 2×1 Landscape |
| `tall` | 1×2 Portrait |
| `feature` | 2×2 Feature block |

---

## 📁 Project Structure

```
keenkings-media/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin panel controllers
│   │   │   ├── HomeController.php
│   │   │   ├── PortfolioController.php
│   │   │   └── ContactController.php
│   │   └── Middleware/
│   │       └── AdminAuthenticate.php
│   ├── Models/                 # Eloquent models
│   └── Providers/
├── config/                     # Laravel config files
├── database/
│   ├── migrations/             # 8 migration files
│   └── seeders/
│       └── DatabaseSeeder.php  # Default data seeder
├── public/
│   ├── css/
│   │   ├── zoomin.css         # Frontend styles
│   │   └── admin.css          # Admin panel styles
│   ├── js/
│   │   ├── zoomin.js          # Frontend JS
│   │   └── admin.js           # Admin JS
│   └── index.php
├── resources/views/
│   ├── layouts/app.blade.php  # Public layout
│   ├── pages/                 # Home & portfolio pages
│   └── admin/                 # All admin views
│       ├── layouts/app.blade.php
│       └── pages/             # Dashboard, hero, about, services,
│                              # testimonials, portfolio, enquiries
├── routes/
│   └── web.php                # All routes
├── storage/
├── .env.example
├── composer.json
└── README.md
```

---

## 🎨 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.2, Laravel 11 |
| Database | MySQL 8.0 |
| Frontend CSS | Custom (no frameworks) — CSS variables, dark/light themes |
| Frontend JS | Vanilla JS — cursor, slider, lightbox, filter, reveal animations |
| Icons | Feather Icons (CDN) |
| Fonts | Cormorant Garamond + Outfit + Space Mono (Google Fonts) |
| Images | Uploaded to `storage/app/public` or external URLs |

---

## 🌐 Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/` | Homepage |
| GET | `/portfolio` | Portfolio page with filters |
| POST | `/contact` | Contact form submission |
| GET | `/admin` → `/admin/login` | Admin login |
| GET | `/admin/dashboard` | Admin dashboard |
| CRUD | `/admin/hero` | Hero slides management |
| GET/PUT | `/admin/about` | About content management |
| CRUD | `/admin/services` | Services management |
| CRUD | `/admin/testimonials` | Testimonials management |
| CRUD | `/admin/portfolio` | Portfolio items management |
| CRUD | `/admin/enquiries` | Contact enquiries |

---

## 🖼 Image Uploads

Uploaded images are stored in `storage/app/public/` (in subdirectories `portfolio/`, `hero/`, `about/`).

After running `php artisan storage:link`, they're accessible at `/storage/...`.

You can also use external image URLs (Unsplash, etc.) directly in the admin panel — no upload needed.

---

## 🔧 Customisation

- **Contact info** (phone, email, address): edit `resources/views/layouts/app.blade.php` footer and `resources/views/pages/home.blade.php` contact section
- **Site name / tagline**: update via the Admin → About section
- **Social links**: `resources/views/layouts/app.blade.php` footer
- **Colour scheme**: CSS variables in `public/css/zoomin.css` (`:root` block)
- **Admin password**: `database/seeders/DatabaseSeeder.php` or update via `php artisan tinker`

---

## 📝 Changing Admin Password

```bash
php artisan tinker
>>> \App\Models\AdminUser::first()->update(['password' => bcrypt('your_new_password')]);
```

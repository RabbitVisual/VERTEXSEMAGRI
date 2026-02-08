# Jules Agent Instructions & Project Documentation

This document serves as the **SINGLE SOURCE OF TRUTH** for the Jules Agent working on the **VERTEXSEMAGRI** project.

**CRITICAL RULE:** This project is **100% LOCAL-FIRST**. No CDNs, no external links for assets. All fonts, icons, and scripts must be loaded from local resources.

---

## 1. Technology Stack
*   **Backend:** Laravel 12 (Modules via `nwidart/laravel-modules`)
*   **Frontend:** Blade Templates + Alpine.js + Tailwind CSS **v4.1**
*   **Build Tool:** Vite
*   **Database:** SQLite (Default for Dev) / MySQL
*   **Icons:** Font Awesome 7.1 Pro (**Local Only** - `resources/fw-pro`)
*   **Fonts:** Inter & Poppins (**Local Only** - `resources/fonts`)

---

## 2. Environment Setup
To set up the environment, the agent must:
1.  Copy `.env.example` to `.env`.
2.  Run `composer install`.
3.  Run `npm install`.
4.  Run `php artisan key:generate`.
5.  Run `php artisan migrate --seed`.

---

## 3. Frontend Development Rules

### A. Icons (Font Awesome 7.1 Pro)
**NEVER** use CDN links for Font Awesome.
**ALWAYS** use the `<x-icon>` Blade component or the local CSS classes.

**Usage:**
```blade
<!-- Recommended: Universal Component -->
<x-icon name="user" />                  <!-- Default: Duotone -->
<x-icon name="house" style="solid" />   <!-- Solid Style -->
<x-icon name="check" style="thin" />    <!-- Thin Style (New in FA 7) -->

<!-- By Module Default -->
<x-icon module="Agua" /> <!-- Renders the default icon for the Agua module -->
```

*   **Location:** `resources/fw-pro`
*   **Config:** `config/icons.php` (Maps modules to default icons)

### B. Typography (Local Fonts)
**NEVER** use Google Fonts CDNs.
The project uses **Inter** (UI) and **Poppins** (Headings/Emphasis) loaded locally.

*   **Inter files:** `resources/fonts/inter-v20-latin-*.woff2`
*   **Poppins files:** `resources/fonts/poppins-v24-latin-*.woff2`
*   **CSS definition:** `resources/css/fonts.css`

### C. Styling (Tailwind CSS v4.1)
This project uses **Tailwind CSS v4.1**.
*   **Config:** Configuration is done via CSS variables in `resources/css/app.css` inside the `@theme` block.
*   **Dark Mode:** Native Tailwind v4 dark mode is enabled (`html.dark`).

**Build Commands:**
*   `npm run dev`: Start Vite dev server.
*   `npm run build`: Build production assets.

---

## 4. Module System
The project is modular. New features should optionally be created as Modules.
*   **Path:** `Modules/`
*   **Command:** `php artisan module:make <Name>`

---

## 5. Workflow Validation
Before submitting changes:
1.  **Verify Assets:** Ensure no 404s for fonts/icons in the browser console.
2.  **Run Tests:** `php artisan test`.
3.  **Build:** Run `npm run build` to ensure the manifest is generated correctly.

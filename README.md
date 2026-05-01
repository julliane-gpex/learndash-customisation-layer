# LearnDash Customisation Layer

> Internal development reference for LearnDash customisation at GPEx.

A structured approach for customising LearnDash UI and behaviour without modifying core plugin files.

This repository defines a reusable and scalable configuration layer using WordPress hooks and modular PHP files, allowing safe and maintainable extensions across projects.

---

## 🎯 Overview

This approach isolates all LearnDash customisations within the theme, ensuring:

- ✔ Compatibility with LearnDash updates  
- ✔ Separation of concerns (UI vs behaviour)  
- ✔ Reusability across multiple projects  

---

## 📁 Directory Structure
public/wp-content/themes/hello-elementor/custom-configurations/learndash/

├── ui-hooks.php
├── behaviour.php


---

## 📦 File Responsibilities

### 🧩 ui-hooks.php

Handles UI-related customisations using WordPress and LearnDash hooks.

Used for:
- Injecting UI elements  
- Modifying existing components  
- Removing default elements  
- Applying styling and frontend adjustments (via injected CSS/JS when needed)  

---

### 🧠 behaviour.php

Handles functional logic and behaviour customisation.

Includes:
- SCORM handling  
- Completion flow control  
- Mark Complete logic  
- Conditional behaviour overrides  

---

## ⚙️ How It Works

All custom files are loaded through the theme’s `functions.php`:

```php
// Parent Theme
require_once get_template_directory() . '/custom-configurations/learndash/ui-hooks.php';
require_once get_template_directory() . '/custom-configurations/learndash/behaviour.php';

// Child Theme
require_once get_stylesheet_directory() . '/custom-configurations/learndash/ui-hooks.php';
require_once get_stylesheet_directory() . '/custom-configurations/learndash/behaviour.php';

ui-hooks.php   → UI modifications (hooks, layout, visual adjustments)
behaviour.php  → logic and behaviour control

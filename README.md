# 🚀 AdminDash - Modern PHP & MySQL User Management System

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

Un panel de administración moderno, seguro y adaptable para la gestión integral de usuarios y roles. Diseñado con una interfaz intuitiva (UI/UX), métricas en tiempo real, filtrado dinámico y estándares de seguridad avanzados.

---

## 📸 Demo Preview

| Dashboard Principal & Métricas |
| :---: |
| ![AdminDash Preview](img/dashboard.png) |
| *Vista general del panel con KPIs, gestión de usuarios y búsqueda dinámica en tiempo real.* |

---

## ✨ Características Principales (Key Features)

* ** Autenticación y Control de Acceso:** Sistema de Login/Logout seguro basado en sesiones nativas de PHP.
* ** Encriptación de Contraseñas:** Algoritmo `Bcrypt` mediante `password_hash()` y `password_verify()`.
* ** Seguridad SQL:** Consultas preparadas con `PDO` para evitar vulnerabilidades de Inyección SQL (SQLi).
* ** Búsqueda Dinámica:** Filtro de registros en tiempo real mediante JavaScript sin recargar la página.
* ** Muestreo de Métricas (KPIs):** Indicadores superiores con el cómputo dinámico de usuarios totales, administradores y roles estándar.
* ** Notificaciones Interactivas:** Integración con **SweetAlert2** para modales de confirmación de borrado y alertas tipo Toast para estados de guardado/edición.
* ** Gestión de Roles (RBAC):** Asignación y control visual de permisos (`Admin` / `Usuario`).
* ** Diseño Responsivo & UI Premium:** Maquetación con **Bootstrap 5**, **FontAwesome 6** y tipografía **Plus Jakarta Sans**.

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
| :--- | :--- |
| **Backend** | PHP 8+ (PDO Engine) |
| **Database** | MySQL / MariaDB |
| **Frontend UI** | Bootstrap 5.3, FontAwesome 6, Custom CSS |
| **Interactividad** | Vanilla JavaScript (ES6+), SweetAlert2 |

---

## ⚡ Guía de Instalación Local

### Requisitos Previos
* Servidor local como **XAMPP**, **WAMP** o **Laragon** (PHP 8.0+ y MySQL).

### Pasos de Configuración

1. **Clonar o descargar el repositorio:**
   ```bash
   git clone [https://github.com/tu-usuario/admin-dash-php.git](https://github.com/tu-usuario/admin-dash-php.git)

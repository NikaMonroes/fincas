# 🏡 Booking Fincas

**Booking Fincas** es una aplicación web desarrollada en PHP bajo el patrón MVC que permite la reserva y gestión de fincas turísticas de forma eficiente, amigable y moderna.

---

## 🚀 Tecnologías utilizadas

- **PHP** (estructura MVC desde cero)
- **MySQL** para persistencia de datos
- **HTML, CSS y Bootstrap 5** para un frontend responsivo
- **JavaScript** y **SweetAlert2** para interacción dinámica
- **Composer** para gestión de dependencias
- **PHPMailer vía API REST** para recuperación de contraseña y confirmación de reservas
- **WhatsApp Link API** para contacto directo entre usuarios y administración

---

## 🎯 Objetivos del proyecto

- Implementar arquitectura MVC desde cero para mejor organización y escalabilidad
- Crear y proteger un sistema de usuarios con roles (`Administrador`, `Editor`, `Visitante`)
- Construir interfaces limpias e intuitivas con Bootstrap
- Incorporar funcionalidades completas de CRUD para fincas y reservas
- Automatizar correos clave en el proceso de recuperación y confirmación de reserva
- Desarrollar una **API REST interna** autenticada por token para modularizar las funciones administrativas
- Facilitar exportaciones en PDF, CSV y Excel desde el panel administrativo

---

## 🧪 Módulos principales

| Módulo        | Funcionalidad                                                                 |
|---------------|-------------------------------------------------------------------------------|
| 👤 Usuarios    | Registro, login, roles y recuperación de contraseña via correo electrónico   |
| 🏡 Fincas      | CRUD completo (incluye imágenes, servicios con emojis, visualización por cards o tabla) |
| 📅 Reservas    | CRUD administrativo + confirmación por correo + validación de fechas         |
| 📨 Notificaciones | Envío automático de correos y generación de enlaces WhatsApp para contacto directo |
| 📊 Panel Admin | Exportaciones, filtros por zona/destino, métricas básicas                   |

---

## 🛠️ Instalación (modo local)

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/NikaMonroes/fincas.git

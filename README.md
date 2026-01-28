<p align="center">
  <h1 align="center">Larabook 🟦</h1>
  <p align="center">
    <strong>La red social que extrañabas. La tecnología que necesitas.</strong>
  </p>
  <p align="center">
    Un clon "pixel-perfect" de Facebook (Era Dorada ~2012) construido con el poder moderno de <strong>Laravel 11</strong>.
  </p>
</p>

---

## 📖 Sobre el proyecto

**Larabook** es un viaje en el tiempo. Es un intento de recrear la experiencia de usuario de la red social más famosa del mundo en su momento cumbre (2011-2013), cuando el *Timeline* era nuevo y los juegos Flash dominaban el mundo.

A diferencia del código espagueti de aquella época, Larabook está construido sobre una arquitectura robusta y moderna, demostrando que se puede tener estética retro con rendimiento actual.

### 🤖 Humano + IA
Este proyecto es un experimento de desarrollo asistido.
- **Concepto y Dirección:** JJDCT
- **Código y Arquitectura:** Generado con **Google Gemini** 🧠✨.

## 🚀 Funcionalidades (Estado Actual)

- **Autenticación Retro:**
  - Pantallas de Login y Registro idénticas a las de 2012.
  - Correos de verificación y recuperación de contraseña estilizados (HTML clásico).
  - Medidas de seguridad modernas (Bcrypt, CSRF protection) bajo una interfaz vintage.

- **Perfiles de Usuario:**
  - Portada (Cover Photo) y Foto de Perfil.
  - Navegación de pestañas (Biografía, Información, Amigos).
  - Botones de acción dinámicos (+1 Agregar a mis amigos, Mensaje, etc.).

- **Sistema de Amistad:**
  - Enviar solicitudes de amistad.
  - Estados: Pendiente, Aceptado, Bloqueado.
  - Lógica de visualización de botones según el estado de la relación.

- **Chat & Mensajería:**
  - **Chat Dock:** Ventana flotante en la esquina inferior para chats rápidos.
  - **Inbox Completo:** Interfaz dedicada `/messages` con diseño de doble panel.

- **Muro (Timeline):**
  - Publicación de estados.
  - Comentarios y "Me gusta" (En desarrollo).

- **Juegos (Canvas):**
  - Soporte para Iframe de juegos.
  - SDK simulado (`larabook.js`) para comunicación entre el juego y la plataforma.

## 🛠️ Stack Tecnológico

Aunque parece 2012, bajo el capó es pura potencia moderna:

- **Backend:** PHP 8.2+ / Laravel 11
- **Base de Datos:** SQLite (Configuración por defecto), MySQL compatible.
- **Frontend:** Blade Templates + Tailwind CSS (¡Sí, usamos Tailwind para recrear CSS antiguo!).
- **Javascript:** Vanilla JS & Alpine.js.

## 💻 Instalación Local

¿Quieres viajar al 2012 en tu propia máquina? Sigue estos pasos:

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/jjdct/larabook.git](https://github.com/jjdct/larabook.git)
   cd larabook
   ```

2. **Instalar dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Configurar entorno:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Nota: Configura tu base de datos en el archivo .env (por defecto usa SQLite).

4. Base de datos:
   ```bash
   php artisan migrate
   ```

5. **Frontend (Opcional si ya están compilados, pero recomendado):**
   ```bash
   npm install
   npm run dev
   ```
6. **¡Encender la máquina del tiempo!**
   ```bash
   php artisan serve
   ```
Visita http://localhost:8000 y regístrate.

⚠️ **Disclaimer**
Este proyecto es estrictamente educacional y de portafolio. No está afiliado con Meta/Facebook. No uses tu contraseña real de otras redes sociales al registrarte.

<p align="center"> Creado con ❤️ y mucha nostalgia por <a href="https://github.com/jjdct">@jjdct</a> y Gemini. </p>
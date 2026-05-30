# 🛡️ Aplicación Web Vulnerable con Fines Educativos

Este proyecto fue desarrollado como parte del **Máster en Ciberseguridad**. Consiste en una aplicación web diseñada intencionalmente con fallos de seguridad críticos para estudiar, explotar y comprender vulnerabilidades comunes en el desarrollo web y bases de datos basadas en PHP y SQLite.

## ⚠️ Aviso Legal (Disclaimer)

> **IMPORTANTE:** Este proyecto se ha creado exclusivamente con fines educativos, de aprendizaje y auditoría de seguridad. El autor no se hace responsable del uso indebido de los conceptos o el código aquí expuestos. No despliegues esta aplicación en servidores de producción expuestos al internet público.

## 🛠️ Tecnologías y Herramientas

* **Entorno de Desarrollo:** Visual Studio
* **Lenguaje Backend:** PHP (Servidor integrado)
* **Base de Datos:** SQLite (Gestionada con DB Browser for SQLite)
* **Frontend:** HTML5, CSS3 y JavaScript

## 💣 Vulnerabilidades Implementadas

El proyecto simula escenarios vulnerables basados en el estándar OWASP:

* **Inyección SQL (SQLi):** Consultas PHP inseguras que permiten manipular la base de datos SQLite para evadir accesos o extraer tablas de usuarios.
* **Cross-Site Scripting (XSS):** Falta de sanitización en los campos de entrada de texto que permite la ejecución de scripts maliciosos.
* **Gestión de Autenticación Deficiente:** Almacenamiento inseguro de credenciales dentro del archivo de la base de datos `.db`.

## 📦 Instalación y Despliegue Local

Para montar el entorno de pruebas en tu máquina local, sigue estos pasos:

1. Clona este repositorio en tu equipo:
   ```bash
   git clone https://github.com
   ```
2. Abre la carpeta del proyecto en **Visual Studio**.
3. Asegúrate de tener la base de datos `.db` (creada en SQLiteBrowser) en el directorio correspondiente.
4. Inicia el servidor local de PHP desde la terminal de Visual Studio ejecutando:
   ```bash
   php -S localhost:8000
   ```
5. Abre tu navegador web e ingresa a la siguiente dirección para interactuar con la app:
   ```text
   http://localhost:8000
   ```

## ✒️ Autor

* Roberto Ostolaza - https://github.com/ostolazatepe07-lab - https://www.linkedin.com/in/roberto-ostolaza-tepe-17aa713a1

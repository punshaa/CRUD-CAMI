# 🚀 Portafolio Camila - Sistema de Portafolio Profesional

Un sistema de gestión de portafolio moderno y profesional desarrollado con **PHP**, **MySQL** y **Bootstrap 5.3.3**. Diseñado con un esquema de color verde oscuro elegante y funcionalidades CRUD completas.

## ✨ Características Principales

- 🎨 **Diseño Moderno**: Interfaz profesional con Bootstrap 5.3.3 y tema verde oscuro
- 🔐 **Sistema de Autenticación**: Login seguro con sesiones
- 📝 **CRUD Completo**: Crear, leer, actualizar y eliminar proyectos
- 🖼️ **Gestión de Imágenes**: Subida y validación de imágenes para proyectos
- 📱 **Responsive**: Diseño adaptable a todos los dispositivos
- ⚡ **Animaciones Suaves**: Transiciones elegantes y efectos visuales
- 🛡️ **Seguridad**: Validación de datos y protección contra inyecciones SQL

## 🎨 Diseño y UI/UX

### Paleta de Colores
- **Verde Primario**: `#1a4d3a` - Para elementos principales
- **Verde Secundario**: `#2e7d32` - Para acentos y hover
- **Verde Claro**: `#4caf50` - Para botones de acción
- **Fondos**: Gradientes suaves en tonos verdes
- **Texto**: Esquema de colores optimizado para legibilidad

### Componentes Destacados
- **Navbar Fixed**: Navegación fija con degradado
- **Tarjetas de Proyecto**: Diseño tipo card con efectos hover
- **Formularios**: Estilos personalizados con validación visual
- **Animaciones**: Efectos fade-in y transiciones suaves
- **Estado Vacío**: Pantalla amigable cuando no hay proyectos

## 📋 Funcionalidades

### Dashboard Principal (`index.php`)
- Vista de todos los proyectos en grid responsive
- Filtros y búsqueda (futura implementación)
- Estadísticas del portafolio
- Navegación intuitiva

### Gestión de Proyectos
- **Agregar** (`add.php`): Formulario completo con validación
- **Editar** (`edit.php`): Actualización con vista previa
- **Eliminar** (`delete.php`): Confirmación y limpieza de archivos
- **Validación**: Campos requeridos y tipos de archivo

### Autenticación
- **Login** (`login.php`): Diseño moderno con validación
- **Logout** (`logout.php`): Cierre de sesión seguro
- **Protección**: Middleware de autenticación

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Frontend**: Bootstrap 5.3.3, HTML5, CSS3, JavaScript ES6
- **Iconos**: Font Awesome 6.5.1
- **Fuentes**: Google Fonts (Inter)
- **Servidor**: Apache/Nginx + PHP

## ⚙️ Instalación

### Requisitos Previos
- XAMPP, WAMP o servidor similar
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Navegador web moderno

### Pasos de Instalación

1. **Clonar/Descargar el proyecto**
   ```bash
   git clone [url-del-repositorio]
   cd CRUD
   ```

2. **Configurar la base de datos**
   ```sql
   -- Ejecutar el script en MySQL
   mysql -u root -p < css/sql/script.sql
   ```

3. **Configurar conexión**
   - Abrir `db.php`
   - Ajustar credenciales de base de datos si es necesario

4. **Configurar servidor web**
   - Colocar archivos en directorio web (htdocs para XAMPP)
   - Asegurar que el directorio `uploads/` tiene permisos de escritura

5. **Acceder al sistema**
   - URL: `http://localhost/CRUD-CAMI/`
   - Usuario: `camila`
   - Contraseña: `123`

## 📁 Estructura del Proyecto

```
CRUD/
├── index.php           # Dashboard principal
├── login.php          # Página de login
├── add.php            # Agregar proyectos
├── edit.php           # Editar proyectos
├── delete.php         # Eliminar proyectos
├── logout.php         # Cerrar sesión
├── auth.php           # Middleware de autenticación
├── db.php             # Configuración de base de datos
├── css/
│   ├── style.css      # Estilos personalizados
│   └── sql/
│       └── script.sql # Script de base de datos
├── uploads/           # Imágenes de proyectos
└── README.md          # Documentación
```

## 🎯 Uso del Sistema

### Inicio de Sesión
1. Acceder a `login.php`
2. Usar credenciales por defecto o crear usuario
3. Redirigir al dashboard

### Gestión de Proyectos
1. **Ver proyectos**: Dashboard principal con grid responsive
2. **Agregar proyecto**: Botón "Nuevo Proyecto" → formulario completo
3. **Editar proyecto**: Menú desplegable en tarjeta → formulario de edición
4. **Eliminar proyecto**: Confirmación → eliminación segura

### Características de los Formularios
- Validación en tiempo real
- Preview de imágenes
- Contador de caracteres
- Mensajes de error/éxito
- Campos requeridos marcados

## 🔧 Personalización

### Cambiar Colores
Editar variables CSS en `css/style.css`:
```css
:root {
  --primary-green: #1a4d3a;
  --secondary-green: #2e7d32;
  /* ... más variables */
}
```

### Agregar Campos
1. Modificar estructura de base de datos
2. Actualizar formularios (add.php, edit.php)
3. Ajustar queries SQL
4. Actualizar vista del dashboard

### Configurar Uploads
Ajustar configuración en los archivos de formulario:
- Tipos de archivo permitidos
- Tamaño máximo
- Directorio de destino

## 🐛 Solución de Problemas

### Problemas Comunes

**Error de conexión a base de datos**
- Verificar credenciales en `db.php`
- Asegurar que MySQL está ejecutándose
- Comprobar nombre de base de datos

**Imágenes no se suben**
- Verificar permisos del directorio `uploads/`
- Comprobar configuración PHP (upload_max_filesize)
- Validar tipos de archivo permitidos

**Estilos no cargan**
- Verificar ruta de archivos CSS
- Limpiar caché del navegador
- Comprobar enlaces CDN

## 🚀 Mejoras Futuras

- [ ] Sistema de usuarios múltiples
- [ ] Categorías para proyectos
- [ ] Sistema de tags
- [ ] Búsqueda y filtros avanzados
- [ ] API REST
- [ ] Panel de administración
- [ ] Estadísticas y analytics
- [ ] Sistema de comentarios
- [ ] Integración con redes sociales
- [ ] Tema oscuro/claro

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo `LICENSE` para más detalles.

## 👨‍💻 Desarrollador

**Portafolio Camila**
- Sistema desarrollado con ❤️ y ☕
- Enfoque en UX/UI moderno y funcionalidad robusta

---
ayuda de chat gpt para estructurar la pagina , como colocar la barra de arriba donde estan los botones , tambien me ayudo a colocar los colores que yo queria y con algunos errores que tuve con las columnas 
 Juego de Lotería v1.1

Proyecto de mejora del juego de lotería

 Cambios realizados en v1.1

 1. Mejora de Interfaz
- Diseño moderno con gradientes y animaciones
- Interfaz responsiva para dispositivos móviles
- Iconos y mejores visuales
- Pantallas diferenciadas para resultados (Ganaste, Perdiste, Game Over)

 2.  Modificación del Puntaje Inicial
- Puntaje inicial modificado de 1000 a 2000
- Cambios en `controller.php` línea 10
- Cambios en `view.php` línea 12

 Subida a GitHub
```bash
# Inicializar repositorio
git init
git add .
git commit -m "Juego de Lotería v1.1 - Mejoras UI y puntaje inicial"
git branch -M main
git remote add origin https://github.com/tu-usuario/juego-loteria.git
git push -u origin main
```

Link del repositorio: (https://github.com/luis5-5/juego-loteria.git)

 4. PHP Lint (Análisis Estático)
```bash
# Ejecutar PHP Lint
php php_lint.php
```
Resultado:  Sin errores críticos encontrados

 5. Pruebas Unitarias
```bash
# Ejecutar pruebas del método jugar()
php test_jugar.php
```

Pruebas incluidas:
- Test 1: Puntaje inicial es 2000
- Test 2: Victoria suma 200 puntos
- Test 3: Derrota resta 10 puntos
- Test 4: Puntaje nunca es negativo
- Test 5: Generación correcta de números aleatorios
- Test 6: Game Over cuando puntaje = 0

 6. Empaquetado (v1.1)
``bash
# Crear archivo ZIP con el proyecto
tar -czf juego-loteria-v1.1.tar.gz .
```
o usando el Explorador de Windows:
- Clic derecho en carpeta → "Enviar a" → "Carpeta comprimida"

 7. Despliegue en Apache
```bash
# Copiar archivos a htdocs (Windows XAMPP)
xcopy /E /I . "C:\xampp\htdocs\juego-loteria\"

# O en Linux
sudo cp -r . /var/www/html/juego-loteria/

# Acceder en navegador
http://localhost/juego-loteria/
```

 8. Usando Docker (Opcional - Alternativa moderna)
```dockerfile
# Dockerfile
FROM php:7.4-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
```

Construir y ejecutar:
```bash
docker build -t juego-loteria .
docker run -p 80:80 juego-loteria
```

Estructura del Proyecto
```
juego-loteria/
├── index.php           # Punto de entrada principal
├── controller.php      # Lógica del controlador
├── model.php          # Modelo de datos
├── view.php           # Vista (HTML)
├── style.css          # Estilos
├── test_jugar.php     # Pruebas unitarias
├── php_lint.php       # Herramienta de análisis
├── juego.sql          # Script de base de datos
├── .gitignore         # Archivos a ignorar en Git
├── README.md          # Este archivo
└── imagenes/          # Carpeta de imágenes
    ├── 1.jpg
    ├── 2.jpg
    └── 3.jpg
```

 Configuración de Base de Datos

```sql
CREATE TABLE puntajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    puntaje INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Importar con:
```bash
mysql -u root juego < juego.sql
```

Requisitos
- PHP >= 7.4
- MySQL >= 5.7
- Apache (o servidor web compatible)
- (Opcional) Docker

Notas Importantes

1. Configuración de sesiones: `session_start()` debe estar al inicio de `controller.php`
2. Conexión a BD: Actualizar credenciales en `model.php` si es necesario
3. Rutas de imágenes: Verificar que la carpeta `imagenes/` contenga las imágenes necesarias
4. Permisos: Asegurar permisos de escritura en la carpeta del proyecto

Grupo de Trabajo
Luis Alfonso Mosquera Nene
Emmanuel Muñoz dorado - 2453791

Fecha de Entrega
17 de mayo de 2026

 🔗 Recursos Utilizados
- Git:[https://git-scm.com/](https://git-scm.com/)
- Docker: [https://www.docker.com/](https://www.docker.com/)
- PHP: [https://www.php.net/](https://www.php.net/)


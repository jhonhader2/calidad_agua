# Contexto del proyecto `calidad_agua`

## Objetivo
Aplicación web en PHP para registrar y evaluar mediciones de calidad de agua usando el índice IRCA, con visualización histórica, gráfica de tendencia y reporte PDF.

## Problema que resuelve
Permite consolidar tomas de muestras (4 valores por medición), calcular el nivel de riesgo y facilitar seguimiento operativo para decisiones sobre calidad del agua.

## Alcance funcional
- Registro de mediciones (`muestra1`, `muestra2`, `muestra3`, `muestra4`).
- Cálculo de promedio y clasificación de riesgo.
- Listado histórico de registros.
- Edición y eliminación de registros.
- Gráfica de riesgo promedio acumulado (Chart.js).
- Impresión de reporte PDF por toma.

## Reglas de negocio (IRCA)
- `0 < x <= 5` -> **Sin Riesgo**
- `5 < x <= 14` -> **Bajo**
- `14 < x <= 35` -> **Medio**
- `35 < x <= 80` -> **Alto**
- `80 < x <= 100` -> **Inviable Sanitariamente**

## Arquitectura actual
- **Backend:** PHP procedural + MySQLi
- **Frontend:** HTML + Bootstrap + Chart.js
- **Persistencia:** MariaDB/MySQL
- **Reportes:** FPDF

## Estructura principal
- `index.php`: dashboard principal (formulario, tabla, gráfica, mensajes UX).
- `conexion.php`: conexión DB, timezone por defecto (`America/Bogota`, `-05:00`).
- `funciones.php`: lógica de negocio (`promedio`, `evaluarRiesgo`).
- `guardar.php`: inserta/actualiza y calcula resultados.
- `editar.php`: carga formulario de edición.
- `eliminar.php`: elimina registro por `id`.
- `dataChart.php`: endpoint JSON para gráfica.
- `imprimirReporte.php` + `mysql_table.php`: generación de PDF.
- `sql/calidad_agua.sql`: script de creación de base, uso y tabla.

## Modelo de datos
Tabla `datos`:
- `id` BIGINT PK AUTO_INCREMENT
- `muestra1..muestra4` DOUBLE NOT NULL
- `fecha_muestra` TIMESTAMP DEFAULT CURRENT_TIMESTAMP

## Estado de calidad actual
- Manejo de error de BD controlado (sin fatales al usuario final).
- UI más limpia y responsive.
- Zona horaria consistente para Colombia.
- Limpieza de warnings de estilo/linter en archivos clave.

## Riesgos técnicos pendientes (prioridad auditoría)
1. Consultas SQL dinámicas aún presentes en algunas rutas (recomendado: `mysqli_prepare`).
2. Falta centralización de manejo de errores/transacciones para operaciones críticas.
3. Validación de entrada mejorable con reglas homogéneas por capa.
4. Endurecer salida y logging para evitar filtración de detalles internos.

## Recomendación siguiente (corto plazo)
Migrar CRUD a consultas preparadas y encapsular acceso a datos en funciones reutilizables para mejorar seguridad, mantenibilidad y trazabilidad.

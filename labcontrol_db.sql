-- ═══════════════════════════════════════════════════════════════
-- LabControl — Base de Datos Completa
-- TECNM Campus Teziutlán
-- Para importar en MySQL Workbench
-- ═══════════════════════════════════════════════════════════════

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS `LaboratorioReserva`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `LaboratorioReserva`;

-- ═══════════════════════════════════════════════════════════════
-- ESTRUCTURA DE TABLAS
-- ═══════════════════════════════════════════════════════════════

-- ── Roles ────────────────────────────────────────────────────
CREATE TABLE `roles` (
  `id_rol` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `descripcion` VARCHAR(150) DEFAULT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── Usuarios ─────────────────────────────────────────────────
CREATE TABLE `usuarios` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `id_rol` INT(11) NOT NULL,
  `estado` ENUM('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fecha_creacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`),
  KEY `fk_usuario_rol` (`id_rol`),
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── Laboratorios ─────────────────────────────────────────────
CREATE TABLE `laboratorios` (
  `id_laboratorio` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `ubicacion` VARCHAR(150) DEFAULT NULL,
  `capacidad` INT(11) NOT NULL,
  `descripcion` TEXT DEFAULT NULL,
  `estado` ENUM('DISPONIBLE','MANTENIMIENTO','INACTIVO') DEFAULT 'DISPONIBLE',
  PRIMARY KEY (`id_laboratorio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── Reservas ─────────────────────────────────────────────────
CREATE TABLE `reservas` (
  `id_reserva` INT(11) NOT NULL AUTO_INCREMENT,
  `id_laboratorio` INT(11) NOT NULL,
  `id_maestro` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `semestre` VARCHAR(20) DEFAULT NULL,
  `carrera` VARCHAR(150) DEFAULT NULL,
  `total_alumnos` INT(5) DEFAULT 0,
  `estado` ENUM('PENDIENTE','APROBADA','RECHAZADA','CANCELADA') DEFAULT 'PENDIENTE',
  `aprobado_por` INT(11) DEFAULT NULL,
  `fecha_aprobacion` DATETIME DEFAULT NULL,
  `fecha_creacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id_reserva`),
  KEY `fk_reserva_maestro` (`id_maestro`),
  KEY `fk_reserva_aprobado` (`aprobado_por`),
  KEY `idx_fecha_reserva` (`fecha`),
  KEY `idx_estado_reserva` (`estado`),
  KEY `idx_laboratorio_fecha` (`id_laboratorio`,`fecha`),
  CONSTRAINT `fk_reserva_aprobado` FOREIGN KEY (`aprobado_por`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_reserva_laboratorio` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorios` (`id_laboratorio`) ON UPDATE CASCADE,
  CONSTRAINT `fk_reserva_maestro` FOREIGN KEY (`id_maestro`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── Prácticas ────────────────────────────────────────────────
CREATE TABLE `practicas` (
  `id_practica` INT(11) NOT NULL AUTO_INCREMENT,
  `id_reserva` INT(11) NOT NULL,
  `contenido` TEXT NOT NULL,
  `requerimientos` TEXT DEFAULT NULL,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id_practica`),
  KEY `fk_practica_reserva` (`id_reserva`),
  CONSTRAINT `fk_practica_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── Reportes Generados ───────────────────────────────────────
CREATE TABLE `reportes_generados` (
  `id_reporte` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo_reporte` VARCHAR(100) DEFAULT NULL,
  `generado_por` INT(11) DEFAULT NULL,
  `fecha_generacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `parametros` TEXT DEFAULT NULL,
  PRIMARY KEY (`id_reporte`),
  KEY `fk_reporte_usuario` (`generado_por`),
  CONSTRAINT `fk_reporte_usuario` FOREIGN KEY (`generado_por`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── Horarios Bloqueados ──────────────────────────────────────
CREATE TABLE `horarios_bloqueados` (
  `id_bloqueo` INT(11) NOT NULL AUTO_INCREMENT,
  `id_laboratorio` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `motivo` VARCHAR(150) DEFAULT NULL,
  PRIMARY KEY (`id_bloqueo`),
  KEY `fk_bloqueo_laboratorio` (`id_laboratorio`),
  CONSTRAINT `fk_bloqueo_laboratorio` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorios` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── Migrations (CodeIgniter) ─────────────────────────────────
CREATE TABLE `migrations` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` VARCHAR(255) NOT NULL,
  `class` VARCHAR(255) NOT NULL,
  `group` VARCHAR(255) NOT NULL,
  `namespace` VARCHAR(255) NOT NULL,
  `time` INT(11) NOT NULL,
  `batch` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ═══════════════════════════════════════════════════════════════
-- DATOS INICIALES
-- ═══════════════════════════════════════════════════════════════

-- ── Roles ────────────────────────────────────────────────────
INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`) VALUES
(1, 'JEFE', 'Aprueba y revisa reservas'),
(2, 'MAESTRO', 'Solicita laboratorios y registra practicas'),
(3, 'ADMIN', 'Administrador general del sistema'),
(4, 'ALUMNO', 'Visualiza calendario');

-- ── Usuarios ─────────────────────────────────────────────────
-- Contraseñas hasheadas con SHA-256:
--   admin@labcontrol.com    → Admin123!
--   maestro@labcontrol.com  → Maestro123!
--   jefe@labcontrol.com     → Jefe123!
--   L23TE0055@...           → 123456
INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `password`, `id_rol`, `estado`, `fecha_creacion`) VALUES
(1, 'Administrador General', 'admin@labcontrol.com', '3eb3fe66b31e3b4d10fa70b5cad49c7112294af6ae4e476a1c405155d45aa121', 3, 'ACTIVO', '2026-02-24 22:30:14'),
(2, 'Prof. García', 'maestro@labcontrol.com', 'a1fafdb41d25e58e55d5134d9d9983d3ef4b7cc2bc38d3acc9741638b85355bf', 2, 'ACTIVO', '2026-02-24 22:30:14'),
(4, 'Jefe de Carrera', 'jefe@labcontrol.com', '0f39f1279f6d94227815f888245534889e914c2ee9d5de7fedc2820fb51aa8f0', 1, 'ACTIVO', '2026-02-25 20:11:22'),
(5, 'Profersora Veronica', 'L23TE0055@Teziutlan.tecnm.mx', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 2, 'ACTIVO', '2026-02-25 20:29:28');

-- ── Laboratorios ─────────────────────────────────────────────
INSERT INTO `laboratorios` (`id_laboratorio`, `nombre`, `ubicacion`, `capacidad`, `descripcion`, `estado`) VALUES
(1, 'Lab. Redes', 'Edificio A, Planta 2', 30, 'Laboratorio de redes y telecomunicaciones', 'DISPONIBLE'),
(2, 'Lab. Programación', 'Edificio B, Planta 1', 25, 'Laboratorio de programación y desarrollo de software', 'DISPONIBLE');

-- ── Migration record ─────────────────────────────────────────
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-02-26-042543', 'App\\Database\\Migrations\\AddReservaExtraFields', 'default', 'App', 1740544000, 1);

-- Test data for development
INSERT INTO facultads (id, nombre_facultad, created_at, updated_at) VALUES 
(1, 'Facultad de Ingeniería y Arquitectura', NOW(), NOW()),
(2, 'Facultad de Ciencias de la Salud', NOW(), NOW()),
(3, 'Facultad de Ciencias Empresariales', NOW(), NOW()),
(4, 'Facultad de Teología', NOW(), NOW()),
(5, 'Facultad de Ciencias Humanas y Educación', NOW(), NOW());

INSERT INTO carreras (id, nombre_carrera, facultad_id, created_at, updated_at) VALUES 
(1, 'Ingeniería de Sistemas', 1, NOW(), NOW()),
(2, 'Ingeniería Civil', 1, NOW(), NOW()),
(3, 'Arquitectura', 1, NOW(), NOW()),
(4, 'Medicina', 2, NOW(), NOW()),
(5, 'Enfermería', 2, NOW(), NOW()),
(6, 'Administración', 3, NOW(), NOW()),
(7, 'Contabilidad', 3, NOW(), NOW()),
(8, 'Teología', 4, NOW(), NOW()),
(9, 'Educación', 5, NOW(), NOW()),
(10, 'Psicología', 5, NOW(), NOW());

INSERT INTO entidads (id, nombre_entidad, logo, ubicacion, contacto, created_at, updated_at) VALUES 
(1, 'Ministerio de Educación', NULL, 'Lima, Perú', 'contacto@minedu.gob.pe', NOW(), NOW()),
(2, 'Hospital Nacional Dos de Mayo', NULL, 'Lima, Perú', 'administracion@hdm.gob.pe', NOW(), NOW()),
(3, 'Corporación ABC', NULL, 'Lima, Perú', 'convenios@abc.com.pe', NOW(), NOW()),
(4, 'Universidad Nacional Mayor de San Marcos', NULL, 'Lima, Perú', 'convenios@unmsm.edu.pe', NOW(), NOW()),
(5, 'Instituto Nacional de Investigación', NULL, 'Lima, Perú', 'info@ini.gob.pe', NOW(), NOW());

INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES 
(1, 'Administrador del Sistema', 'admin@upeu.edu.pe', NOW(), '$2a$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW()),
(2, 'Coordinador de Convenios', 'coordinador@upeu.edu.pe', NOW(), '$2a$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW());

INSERT INTO convenios (id, nombre_convenio, descripcion, fecha_inicio, fecha_fin, estado, alcance, convenio_creador, convenio_id_entidad, facultad_id, carrera_id, ambito_1, ambito_2, ambito_3, created_at, updated_at) VALUES 
(1, 'Convenio de Prácticas Profesionales - MINSA', 'Convenio marco para prácticas profesionales de estudiantes de ciencias de la salud', '2024-01-15', '2026-01-15', 'VIGENTE', 'FACULTAD', 1, 2, 2, NULL, 'PRACTICAS_PROFESIONALES', 'EDUCACION_CONTINUA', NULL, NOW(), NOW()),
(2, 'Convenio de Investigación Colaborativa', 'Desarrollo conjunto de proyectos de investigación en ingeniería', '2024-03-01', '2025-03-01', 'VIGENTE', 'CARRERA', 2, 4, 1, 1, 'INVESTIGACION', 'TRANSFERENCIA_TECNOLOGICA', 'INNOVACION', NOW(), NOW()),
(3, 'Convenio de Capacitación Empresarial', 'Programas de capacitación para empleados de la corporación', '2023-06-01', '2024-12-31', 'POR_VENCER', 'UNIVERSIDAD', 1, 3, NULL, NULL, 'CAPACITACION', 'EDUCACION_CONTINUA', 'DESARROLLO_PROYECTOS', NOW(), NOW());

INSERT INTO documento_convenios (id, nombre_archivo, tipo_documento, fecha_subida, hora_subida, convenio_id, ruta, created_at, updated_at) VALUES 
(1, 'Convenio_MINSA_2024.pdf', 'PDF', '2024-01-15', '10:30:00', 1, 'documentos/convenios/1/Convenio_MINSA_2024.pdf', NOW(), NOW()),
(2, 'Anexo_A_Investigacion.pdf', 'PDF', '2024-03-01', '14:15:00', 2, 'documentos/convenios/2/Anexo_A_Investigacion.pdf', NOW(), NOW()),
(3, 'Cronograma_Capacitacion.pdf', 'PDF', '2023-06-01', '09:45:00', 3, 'documentos/convenios/3/Cronograma_Capacitacion.pdf', NOW(), NOW());
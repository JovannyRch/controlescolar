CREATE TABLE tipo_usuario(
	id_tipo_usuario integer NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50),
    descripcion varchar(50),
	tipo integer,
	PRIMARY KEY(id_tipo_usuario)
);

CREATE TABLE usuarios(
	id_usuario integer NOT NULL AUTO_INCREMENT,
    id_tipo_usuario integer,
    nombre VARCHAR (50),
	apellido_paterno VARCHAR (100),	
    apellido_materno VARCHAR (100),
	telefono VARCHAR (15),
	email VARCHAR (50),
	cod_postal integer,
	direccion VARCHAR (255),
	localidad VARCHAR (100),
	pais VARCHAR (50),
	fecha_alta DATE,
	fecha_nacimiento DATE,
	PRIMARY KEY(id_usuario),
	FOREIGN KEY(id_tipo_usuario) REFERENCES tipo_usuario(id_tipo_usuario)
);

CREATE TABLE usuario_acceso(
	id_usuario_acceso integer AUTO_INCREMENT,
	id_usuario integer,
	login varchar(50),
	password varchar(50),
	PRIMARY KEY(id_usuario_acceso),
	FOREIGN KEY(id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

INSERT INTO tipo_usuario(nombre,descripcion,tipo) VALUES('ADMINISTRATIVO','',1);
INSERT INTO tipo_usuario(nombre,descripcion,tipo) VALUES('PROFESOR','',2);
INSERT INTO tipo_usuario(nombre,descripcion,tipo) VALUES('PADRE','',3);
INSERT INTO tipo_usuario(nombre,descripcion,tipo) VALUES('ALUMNO','',4);


INSERT INTO usuarios(id_tipo_usuario,nombre,apellido_paterno,apellido_materno,telefono,email,cod_postal,direccion,localidad,pais)
VALUES(1,'Jovanny','Ramírez','Chimal','7121397374','jovannyrch@gmail.com',50424,'SN cerca del kinder Tierra y Libertad','San Francisco Tepeolulco','México');

INSERT INTO usuario_acceso(id_usuario,login,password) VALUES (1,'jovannyrch','1234');


INSERT INTO usuarios(id_tipo_usuario,nombre,apellido_paterno,apellido_materno,telefono,email,cod_postal,direccion,localidad,pais)
VALUES(2,'Profesor 1','...','...','7121397374','jovannyrch@gmail.com',50424,'SN cerca del kinder Tierra y Libertad','San Francisco Tepeolulco','México');

INSERT INTO usuario_acceso(id_usuario,login,password) VALUES (2,'profe1','1234');


INSERT INTO usuarios(id_tipo_usuario,nombre,apellido_paterno,apellido_materno,telefono,email,cod_postal,direccion,localidad,pais)
VALUES(2,'Profesor 2','...','...','7121397374','jovannyrch@gmail.com',50424,'SN cerca del kinder Tierra y Libertad','San Francisco Tepeolulco','México');

INSERT INTO usuario_acceso(id_usuario,login,password) VALUES (3,'profe2','1234');




INSERT INTO usuarios(id_tipo_usuario,nombre,apellido_paterno,apellido_materno,telefono,email,cod_postal,direccion,localidad,pais)
VALUES(3,'Padre 1','...','...','7121397374','jovannyrch@gmail.com',50424,'SN cerca del kinder Tierra y Libertad','San Francisco Tepeolulco','México');

INSERT INTO usuario_acceso(id_usuario,login,password) VALUES (4,'padre1','1234');


INSERT INTO usuarios(id_tipo_usuario,nombre,apellido_paterno,apellido_materno,telefono,email,cod_postal,direccion,localidad,pais)
VALUES(3,'Padre 2','...','...','7121397374','jovannyrch@gmail.com',50424,'SN cerca del kinder Tierra y Libertad','San Francisco Tepeolulco','México');

INSERT INTO usuario_acceso(id_usuario,login,password) VALUES (5,'padre2','1234');



INSERT INTO usuarios(id_tipo_usuario,nombre,apellido_paterno,apellido_materno,telefono,email,cod_postal,direccion,localidad,pais)
VALUES(4,'Alumno 1','...','...','7121397374','jovannyrch@gmail.com',50424,'SN cerca del kinder Tierra y Libertad','San Francisco Tepeolulco','México');

INSERT INTO usuario_acceso(id_usuario,login,password) VALUES (6,'alumno1','1234');


INSERT INTO usuarios(id_tipo_usuario,nombre,apellido_paterno,apellido_materno,telefono,email,cod_postal,direccion,localidad,pais)
VALUES(4,'Alumno 2','...','...','7121397374','jovannyrch@gmail.com',50424,'SN cerca del kinder Tierra y Libertad','San Francisco Tepeolulco','México');

INSERT INTO usuario_acceso(id_usuario,login,password) VALUES (7,'alumno2','1234');


 CREATE TABLE curso(
	id_curso integer AUTO-INCREMENT NOT NULL PRIMARY KEY,
	nombre varchar(50),
	descripcion varchar(255)
);

 CREATE TABLE asignatura(
	id_asignatura integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	id_curso integer,
	nombre varchar(100),
	descripcion text,
	FOREIGN KEY(id_curso) REFERENCES curso(id_curso) ON DELETE CASCADE
);


 CREATE TABLE convocatorias(
	id_convocatoria integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	convocatoria varchar(50),
	activo bit
);

 CREATE TABLE aula(
	id_aula integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nombre varchar(50),
	descripcion varchar(255)
);

create table evaluaciones(
	id_evaluacion integer AUTO_INCREMENT not null PRIMARY KEY,
	nombre varchar(50)
);

insert into evaluaciones(nombre) values("PRIMERA EVALUACIÓN PARCIAL");
insert into evaluaciones(nombre) values("SEGUNDA EVALUACIÓN PARCIAL");
insert into evaluaciones(nombre) values("TERCERA EVALUACIÓN PARCIAL");
insert into evaluaciones(nombre) values("EVALUACIÓN FINAL");
insert into evaluaciones(nombre) values("EVALUACIÓN EXTRAORDINARIA");





CREATE TABLE calificaciones(
	id_calificacion integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	id_asignatura integer,
	id_convocatoria integer,
	id_grupo integer,
	id_profesor integer,
	id_alumno integer,
	id_evaluacion integer,
	id_curso integer,
	calificacion DECIMAL,
	FOREIGN KEY(id_convocatoria) REFERENCES convocatorias(id_convocatoria) ON DELETE CASCADE,
	FOREIGN KEY(id_grupo) REFERENCES grupos(id_grupo) ON DELETE CASCADE,
	FOREIGN KEY(id_curso) REFERENCES curso(id_curso) ON DELETE CASCADE,
	FOREIGN KEY(id_alumno) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY(id_profesor) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY(id_asignatura) REFERENCES asignatura(id_asignatura) ON DELETE CASCADE,
	FOREIGN KEY(id_evaluacion) REFERENCES evaluaciones(id_evaluacion) ON DELETE CASCADE
);


create table posts(
	id_post int AUTO_INCREMENT PRIMARY KEY,	
	titulo varchar(100),
	cuerpo text,
	imagen varchar(200)
);

 CREATE TABLE hijos(
	id_hijos integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	id_padre integer,
	id_hijo integer,
	FOREIGN KEY(id_padre) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY(id_hijo) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

CREATE TABLE grupos(
	id_grupo integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	id_curso integer,
	nombre varchar(50),
	descripcion varchar(255),
	FOREIGN KEY(id_curso) REFERENCES curso(id_curso) ON DELETE CASCADE
);

 CREATE TABLE prioridad(
	id_prioridad integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nombre varchar(10)
);

INSERT INTO prioridad(nombre) VALUE('BAJA');
INSERT INTO prioridad(nombre) VALUE('NORMAL');
INSERT INTO prioridad(nombre) VALUE('ALTA');
INSERT INTO prioridad(nombre) VALUE('URGENTE');

 CREATE TABLE mensajes(
	id_mensaje integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	id_remitente integer,
	id_destinatario integer,
	asunto varchar(100),
	texto varchar(255),
	fecha_hora datetime,
	id_prioridad integer,
	leido bit,
	FOREIGN KEY(id_remitente) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY(id_destinatario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY(id_prioridad) REFERENCES prioridad(id_prioridad) ON DELETE CASCADE
);


CREATE TABLE inscripciones(
	id_inscripcion  integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	id_alumno integer,
	id_curso integer,
	id_convocatoria integer,
	id_grupo integer,
	FOREIGN KEY(id_alumno) REFERENCES usuarios(id_usuario),
	FOREIGN KEY(id_grupo) REFERENCES grupos(id_grupo),
	FOREIGN KEY(id_curso) REFERENCES curso(id_curso),
	FOREIGN KEY(id_convocatoria) REFERENCES convocatorias(id_convocatoria)
	);

CREATE table profesores_materias(
	id_profesores_materias integer AUTO_INCREMENT PRIMARY KEY,
	id_profesor integer,
	id_asignatura integer,
	FOREIGN KEY(id_profesor) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY(id_asignatura) REFERENCES asignatura(id_asignatura) ON DELETE CASCADE
);


CREATE TABLE profesores_materias_grupos(
	id_profesores_materias_grupos integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
	id_grupo INTEGER,
	id_profesores_materias INTEGER,
	FOREIGN KEY(id_grupo) REFERENCES grupos(id_grupo) ON DELETE CASCADE,
	FOREIGN KEY(id_profesores_materias) REFERENCES profesores_materias(id_profesores_materias) ON DELETE CASCADE
);




create or replace table pagos(
	-- jovannyrch@gmail.com
	id integer AUTO_INCREMENT PRIMARY KEY,
	id_convocatoria integer not null,
	FOREIGN KEY (id_convocatoria) REFERENCES convocatorias(id_convocatoria),
	id_alumno integer not null,
	FOREIGN KEY(id_alumno) REFERENCES usuarios(id_usuario),
	fecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	monto float NOT NULL
);

CREATE OR REPLACE TABLE licenciaturas(
	-- jovannyrch@gmail.com
	id integer AUTO_INCREMENT PRIMARY KEY NOT NULL,
	nombre varchar(60)
);

CREATE OR REPLACE TABLE planteles(
	-- jovannyrch@gmail.com
	id integer AUTO_INCREMENT PRIMARY KEY NOT NULL,
	nombre varchar(60),
	telefono varchar(15),
	correo varchar(40)
);



create or replace table datos_alumnos(
	-- jovannyrch@gmail.com
	id integer AUTO_INCREMENT PRIMARY KEY,
	matricula integer not null,
	id_alumno integer not null,
	FOREIGN KEY(id_alumno) REFERENCES usuarios(id_usuario),
	status TINYINT DEFAULT 1,
	id_ultimo_periodo integer not null,
	FOREIGN KEY (id_ultimo_periodo) REFERENCES convocatorias(id_convocatoria),
	id_periodo_ingreso integer not null,
	FOREIGN KEY (id_periodo_ingreso) REFERENCES convocatorias(id_convocatoria),
	turno varchar(10),
	id_plantel integer not null,
	FOREIGN KEY(id_plantel) REFERENCES planteles(id),
	id_licenciatura integer not null,
	FOREIGN KEY(id_licenciatura) REFERENCES licenciaturas(id),
	status_pago varchar(15),
	tot_mensualidades_x_pagar integer DEFAULT 4,
	cant_mensualidades_x_pagar integer,
	costo_mensualidad float,
	costo_final_periodo float
);




CREATE OR REPLACE VIEW datos_alumno_completos  
AS SELECT *, (SELECT p.nombre plantel from planteles p where p.id = datos_alumnos.id_plantel), 
(SELECT l.nombre licenciatura from licenciaturas l where l.id = datos_alumnos.id_licenciatura) from datos_alumnos;

CREATE OR REPLACE VIEW alumnos  
AS SELECT * from usuarios inner join datos_alumno_completos 
on usuarios.id_usuario = datos_alumno_completos.id_alumno  where usuarios.id_tipo_usuario = 4;
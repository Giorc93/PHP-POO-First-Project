CREATE DATABASE tienda_master;
USE tienda_master;

CREATE TABLE usuarios(
id                      int(255) auto_increment not null,
nombre                  varchar (100) not null,
apellidos               varchar (200),
email                   varchar (200) not null,
password                varchar (200) not null,
rol                     varchar (20) 
imagen                  varchar (255),
CONSTRAINT pk_usuarios PRIMARY KEY (id),
CONSTRAINT uq_email UNIQUE (email)
)ENGINE=InnoDB;

INSERT INTO usuarios VALUES (null, 'Admin', 'Admin', 'admin@admin.com', 'admin123', 'Administrador', 'null');

CREATE TABLE categorias(
id                      int(255) auto_increment not null,
nombre                  varchar(100) not null,
CONSTRAINT pk_categorias PRIMARY KEY (id),
)ENGINE=InnoDB;

INSERT INTO categorias VALUES (null, 'Básicas');
INSERT INTO categorias VALUES (null, 'Polos');
INSERT INTO categorias VALUES (null, 'Cuello V');
INSERT INTO categorias VALUES (null, 'Gráficos');
INSERT INTO categorias VALUES (null, 'Raglan');
INSERT INTO categorias VALUES (null, 'Slogans');
INSERT INTO categorias VALUES (null, 'Henley');
INSERT INTO categorias VALUES (null, 'Color Block');

CREATE TABLE productos(
id                      int(255) auto_increment not null,
categoria_id            int(255) not null,
nombre                  varchar(100),
descripcion             TEXT,
precio                  float(100, 2) not null,
stock                   int(255) not null,
oferta                  varchar(2),
fecha                   date not null,
imagen                  varchar(255),
CONSTRAINT pk_productos PRIMARY KEY (id),
CONSTRAINT fk_producto_categoria FOREIGN KEY (categoria_id) REFERENCES categorias (id)
)ENGINE=InnoDB;

CREATE TABLE pedidos(
id                      int(255) auto_increment not null,
usuario_id              int(255) not null,
departamento            varchar(255) not null,
municipio               varchar(255) not null,
direccion               varchar(255) not null,
total                   float(100, 2) not null,
estado                  varchar(255) not null,
fecha                   date not null,
hora                    time not null,
CONSTRAINT pk_pedidos PRIMARY KEY (id),
CONSTRAINT fk_pedido_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id)  /*on delete cascade Borra todos los datos relacionados del usuario al eliminarlo.*/
)ENGINE=InnoDB;


CREATE TABLE lineas_pedido(
id                      int(255) not null,
pedido_id               int(255) not null,
producto_id             int(255) not null,
unidades                int(255) not null,
CONSTRAINT pk_lineas_pedidos PRIMARY KEY (id),
CONSTRAINT fk_lineas_pedidos_pedidos FOREIGN KEY (pedido_id) REFERENCES pedidos (id),
CONSTRAINT fk_lineas_pedidos_productos FOREIGN KEY (producto_id) REFERENCES productos (id)
)ENGINE=InnoDB;


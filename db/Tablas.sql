-- Borrado de tablas
drop table Clinicas CASCADE CONSTRAINTS;
drop table Pacientes CASCADE CONSTRAINTS;
drop table Facturas CASCADE CONSTRAINTS;
drop table Encargos CASCADE CONSTRAINTS;
drop table Materiales CASCADE CONSTRAINTS;
drop table Productos CASCADE CONSTRAINTS;
drop table Proveedores CASCADE CONSTRAINTS;
drop table Pedidos CASCADE CONSTRAINTS;
DROP TABLE USUARIOS;

-- Creaci�n de tablas
CREATE TABLE USUARIOS (
	NOMBRE VARCHAR2(25) NOT NULL,
	APELLIDOS VARCHAR2(75),
	EMAIL VARCHAR2(75) NOT NULL UNIQUE,
    USUARIO VARCHAR2(30) NOT NULL UNIQUE,
	PASS VARCHAR2(75) NOT NULL,
	PERFIL VARCHAR2(10) CHECK ( PERFIL IN ('clinica','proveedor') ) NOT NULL,
	OID_USUARIO INTEGER NOT NULL,
	PRIMARY KEY (OID_USUARIO) );
--Clinicas
CREATE TABLE Clinicas(
    OID_C NUMBER NOT NULL,
    Nombre varchar2(30),
    Localización varchar2(40),
    Tlf_Contacto varchar2(9),
    Moroso char(1) check(Moroso in('S','N')),
    Nombre_Dueño varchar2(15),
    Num_Colegiado varchar2(4),
    PRIMARY KEY(OID_C)
);

--pacientes
CREATE TABLE Pacientes(
    OID_PC NUMBER NOT NULL,
    DNI varchar2(9) NOT NULL UNIQUE,
    Fecha_Nacimiento date,
    E_Sexo varchar2(1) check(E_Sexo in ('H', 'M')),
    OID_C NUMBER,
    PRIMARY KEY(OID_PC),
    FOREIGN KEY(OID_C) REFERENCES Clinicas ON DELETE CASCADE
);
    
--facturas
CREATE TABLE Facturas(
    OID_F NUMBER NOT NULL,
    Fecha_Cobro date,
    Fecha_Vencimiento date,
    Fecha_Factura date,
    Precio_total number(7,2) CHECK (precio_total > 0),
    PRIMARY KEY (OID_F)
);

--encargos
CREATE TABLE Encargos(
    OID_E NUMBER NOT NULL,
    Fecha_Entrada date default SYSDATE,
    Fecha_Entrega date,
    Acciones varchar(50),
    OID_PC NUMBER,
    OID_F NUMBER,
    PRIMARY KEY (OID_E),
    FOREIGN KEY (OID_PC) REFERENCES Pacientes ON DELETE SET NULL,
    FOREIGN KEY (OID_F) REFERENCES Facturas ON DELETE SET NULL
);

--proveedores
CREATE TABLE Proveedores(
    OID_PR NUMBER NOT NULL,
    Nombre varchar(30) NOT NULL UNIQUE,
    Localización varchar(30),
    Tlf_Contacto varchar(9),
    PRIMARY KEY (OID_PR)
);

--materiales
CREATE table materiales(
    OID_M        NUMBER NOT NULL,
    nombre        varchar2(30) NOT NULL,
    categoria    varchar2(30) NOT NULL check (categoria in ('Alambre','Dientes','Empress','Ferula','Metal Ceramica','Metal',
        'Resina','Revestimiento','Ceramica Zirconio')),
    stock        int CHECK (stock >= 0),
    stock_min    int CHECK (stock_min >= 0),
    stock_critico int CHECK (stock_critico >= 0),
    unidad        varchar2(20),
    Primary Key(OID_M)
);

--pedidos
CREATE TABLE Pedidos(
    OID_PD NUMBER NOT NULL,
    Fecha_Solicitud date DEFAULT SYSDATE,
    Fecha_entrega date,
    cantidad number,
    OID_PR NUMBER,
    OID_M NUMBER,
    OID_F NUMBER,
    PRIMARY KEY(OID_PD),
    FOREIGN KEY(OID_PR) REFERENCES Proveedores ON DELETE CASCADE,
    Foreign key(OID_M) references materiales ON DELETE SET NULL,
    FOREIGN KEY(OID_F) REFERENCES Facturas ON DELETE SET NULL
);

--productos
Create table Productos(
    OID_P        NUMBER NOT NULL,
    nombre        varchar2(30),
    precio        number(7,2) CHECK (precio > 0),
    cantidad number,
    OID_M NUMBER,
    OID_E NUMBER,
    Primary Key(OID_P),
    Foreign key(OID_M) references materiales ON DELETE SET NULL,
    Foreign Key(OID_E) references Encargos ON DELETE SET NULL
);

    




    
    
    
    
    
    
    
    
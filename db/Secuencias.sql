
--SECUENCIAS
CREATE SEQUENCE SEC_USUARIOS_OID
START WITH 1 INCREMENT BY 1 NOMAXVALUE;

--OID_C (Clinicas)
CREATE SEQUENCE SEC_Clinicas
INCREMENT BY 1
START WITH 1
MAXVALUE 9999;

--OID_E (encargos)
CREATE SEQUENCE SEC_Encargos
INCREMENT BY 1
START WITH 1
MAXVALUE 9999;

--OID_F (Facturas)
CREATE SEQUENCE SEC_Facturas
INCREMENT BY 1
START WITH 1
MAXVALUE 9999;

--OID_M (materiales)
CREATE SEQUENCE SEC_Materiales
INCREMENT BY 1
START WITH 1
MAXVALUE 9999;

--OID_PC (pacientes)
CREATE SEQUENCE SEC_Pacientes
INCREMENT BY 1
START WITH 1
MAXVALUE 9999;

--OID_PD (pedidos)
CREATE SEQUENCE SEC_Pedidos
INCREMENT BY 1
START WITH 1
MAXVALUE 9999;

--OID_P (productos)
CREATE SEQUENCE SEC_Productos
INCREMENT BY 1
START WITH 1
MAXVALUE 9999;

--OID_PR (proveedores)
CREATE SEQUENCE SEC_Proveedores
INCREMENT BY 1
START WITH 1
MAXVALUE 9999;

--Triggers asociados a secuencias
--OID_C (Clinicas)
CREATE OR REPLACE TRIGGER TR_SEC_Clinicas
BEFORE INSERT ON Clinicas
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_CLINICAS.nextval INTO valorSec FROM DUAL;
:NEW.OID_C := valorSec;
END;
/

--OID_E (encargos)
CREATE OR REPLACE TRIGGER TR_SEC_Encargos
BEFORE INSERT ON Encargos
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_Encargos.nextval INTO valorSec FROM DUAL;
:NEW.OID_E := valorSec;
END;
/

--OID_F (Facturas)
CREATE OR REPLACE TRIGGER TR_SEC_Facturas
BEFORE INSERT ON Facturas
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_FACTURAS.nextval INTO valorSec FROM DUAL;
:NEW.OID_F := valorSec;
END;
/

--OID_M (materiales)
CREATE OR REPLACE TRIGGER TR_SEC_Materiales
BEFORE INSERT ON Materiales
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_MATERIALES.nextval INTO valorSec FROM DUAL;
:NEW.OID_M := valorSec;
END;
/

--OID_PC (pacientes)
CREATE OR REPLACE TRIGGER TR_SEC_Pacientes
BEFORE INSERT ON Pacientes
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_PACIENTES.nextval INTO valorSec FROM DUAL;
:NEW.OID_PC := valorSec;
END;
/

--OID_PD (pedidos)
CREATE OR REPLACE TRIGGER TR_SEC_Pedidos
BEFORE INSERT ON Pedidos
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_PEDIDOS.nextval INTO valorSec FROM DUAL;
:NEW.OID_PD := valorSec;
END;
/

--OID_P (productos)
CREATE OR REPLACE TRIGGER TR_SEC_Productos
BEFORE INSERT ON Productos
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_PRODUCTOS.nextval INTO valorSec FROM DUAL;
:NEW.OID_P := valorSec;
END;
/

--OID_PR (proveedores)
CREATE OR REPLACE TRIGGER TR_SEC_Proveedores
BEFORE INSERT ON Proveedores
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_PROVEEDORES.nextval INTO valorSec FROM DUAL;
:NEW.OID_PR := valorSec;
END;
/

--OID USUARIOS
CREATE OR REPLACE TRIGGER TR_SEC_Usuarios
BEFORE INSERT ON USUARIOS
FOR EACH ROW
DECLARE
 valorSec NUMBER :=0;
BEGIN
 SELECT SEC_USUARIOS_OID.nextval INTO valorSec FROM DUAL;
:NEW.OID_USUARIO := valorSec;
END;
/

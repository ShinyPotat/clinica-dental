--CREAR
CREATE OR REPLACE PROCEDURE INSERTAR_USUARIO 
  (P_NOM IN USUARIOS.NOMBRE%TYPE,
   P_APE IN USUARIOS.APELLIDOS%TYPE,
   P_EMAIL IN USUARIOS.EMAIL%TYPE,
   P_USUARIO IN USUARIOS.USUARIO%TYPE,
   P_PASS IN USUARIOS.PASS%TYPE,
   P_PERFIL IN USUARIOS.PERFIL%TYPE
   ) IS
BEGIN
  INSERT INTO USUARIOS(NOMBRE,APELLIDOS,EMAIL,USUARIO,PASS,PERFIL)
  VALUES (P_NOM,P_APE,P_EMAIL,P_USUARIO,P_PASS,P_PERFIL);
END;
/


--insertar clinica
CREATE OR REPLACE PROCEDURE crear_clinica (
    w_nombre IN Clinicas.nombre%TYPE,
    w_localización IN Clinicas.localización%TYPE,
    w_tlf_contacto IN Clinicas.tlf_contacto%TYPE,
    w_moroso IN Clinicas.moroso%TYPE,
    w_nombre_dueño IN Clinicas.nombre_dueño%TYPE,
    w_num_colegiado IN Clinicas.num_colegiado%TYPE
) IS
BEGIN
INSERT INTO Clinicas (nombre,localización,tlf_contacto,moroso,nombre_dueño,num_colegiado)
VALUES (w_nombre,w_localización,w_tlf_contacto,w_moroso,w_nombre_dueño,w_num_colegiado);
COMMIT;
END crear_clinica;
/

--insertar paciente
CREATE OR REPLACE PROCEDURE crear_paciente (
    w_dni IN pacientes.dni%TYPE,
    w_fecha_nacimiento IN pacientes.fecha_nacimiento%TYPE,
    w_e_sexo IN pacientes.e_sexo%TYPE,
    w_oid_c IN pacientes.oid_c%TYPE
) IS
BEGIN
INSERT INTO Pacientes (dni,fecha_nacimiento,e_sexo,oid_c)
VALUES (w_dni,w_fecha_nacimiento,w_e_sexo,w_oid_c);
COMMIT;
END crear_paciente;
/

--insertar factura
CREATE OR REPLACE PROCEDURE crear_factura (
    w_fecha_cobro IN facturas.fecha_cobro%TYPE,
    w_fecha_vencimiento IN facturas.fecha_vencimiento%TYPE,
    w_fecha_factura IN facturas.fecha_factura%TYPE,
    w_precio_total IN facturas.precio_total%TYPE
) IS
BEGIN
INSERT INTO Facturas (fecha_cobro,fecha_vencimiento,fecha_factura,precio_total)
VALUES (w_fecha_cobro,w_fecha_vencimiento,w_fecha_factura,w_precio_total);
COMMIT;
END crear_factura;
/

--insertar encargo
CREATE OR REPLACE PROCEDURE crear_encargo (
    w_fecha_entrada IN encargos.fecha_entrada%TYPE,
    w_fecha_entrega IN encargos.fecha_entrega%TYPE,
    w_acciones IN encargos.Acciones%TYPE,
    w_oid_pc IN encargos.OID_PC%TYPE,
    w_oid_f IN encargos.OID_F%TYPE
    
) IS
BEGIN 
INSERT INTO Encargos (fecha_entrada,fecha_entrega,Acciones,OID_PC,OID_F)
VALUES (w_fecha_entrada,w_fecha_entrega,w_acciones,w_oid_pc,w_oid_f);
COMMIT;
END crear_encargo;
/

--insertar proveedor
CREATE OR REPLACE PROCEDURE crear_proveedor (
    w_nombre IN proveedores.nombre%TYPE,
    w_localización IN proveedores.localización%TYPE,
    w_tlf_contacto IN proveedores.tlf_contacto%TYPE
) IS
BEGIN
INSERT INTO Proveedores (nombre,localización,tlf_contacto)
VALUES (w_nombre,w_localización,w_tlf_contacto);
COMMIT;
END crear_proveedor;
/

--insertar pedido
CREATE OR REPLACE PROCEDURE crear_pedido (
    w_fecha_solicitud IN pedidos.fecha_solicitud%TYPE,
    w_fecha_entrega IN pedidos.fecha_entrega%TYPE,
    w_oid_pr IN pedidos.oid_pr%TYPE,
    w_oid_f IN pedidos.oid_f%TYPE
) IS
BEGIN
INSERT INTO Pedidos (fecha_solicitud,fecha_entrega,oid_pr,oid_f)
VALUES (w_fecha_solicitud,w_fecha_entrega,w_oid_pr,w_oid_f);
COMMIT;
END crear_pedido;
/

--insertar material
CREATE OR REPLACE PROCEDURE crear_material (
    w_nombre IN materiales.nombre%TYPE,
    w_categoria IN materiales.categoria%TYPE,
    w_stock IN materiales.stock%TYPE,
    w_stock_min IN materiales.stock_min%TYPE,
    w_stock_critico IN materiales.stock_critico%TYPE,
    w_unidad IN materiales.unidad%TYPE
) IS
BEGIN 
INSERT INTO Materiales (nombre,categoria,stock,stock_min,stock_critico,unidad)
VALUES (w_nombre,w_categoria,w_stock,w_stock_min,w_stock_critico,w_unidad);
COMMIT;
END crear_material;
/

--insertar linea pedido
CREATE OR REPLACE PROCEDURE crear_linea (
    w_cantidad IN linea_pedido.cantidad%TYPE,
    w_coste IN linea_pedido.coste%TYPE,
    w_oid_pd IN linea_pedido.oid_pd%TYPE,
    w_oid_m IN linea_pedido.oid_m%TYPE
) IS
BEGIN
INSERT INTO Linea_Pedido (cantidad,coste,oid_pd,oid_m)
VALUES (w_cantidad,w_coste,w_oid_pd,w_oid_m);
COMMIT;
END crear_linea;
/

--insertar producto
CREATE OR REPLACE PROCEDURE crear_producto(
    w_nombre IN productos.nombre%TYPE,
    w_precio IN productos.precio%TYPE,
    w_oid_e IN productos.oid_e%TYPE
) IS
BEGIN
INSERT INTO Productos (nombre,precio,oid_e)
VALUES (w_nombre,w_precio,w_oid_e);
COMMIT;
END crear_producto;
/

--insertar requiere
CREATE OR REPLACE PROCEDURE crear_requiere (
    w_cantidad IN requiere.cantidad%TYPE,
    w_oid_p IN requiere.oid_p%TYPE,
    w_oid_m IN requiere.oid_m%TYPE
) IS
BEGIN
INSERT INTO Requiere (cantidad,oid_p,oid_m)
VALUES (w_cantidad,w_oid_p,w_oid_m);
COMMIT;
END crear_requiere;
/

--ELIMINAR
--eliminar linea de la tabla clinicas
CREATE OR REPLACE PROCEDURE eliminar_clinica (
    w_oid_c IN clinicas.oid_c%TYPE
) IS
BEGIN
DELETE FROM Clinicas WHERE oid_c = w_oid_c;
COMMIT;
END eliminar_clinica;
/

--eliminar linea de la tabla pacientes
CREATE OR REPLACE PROCEDURE eliminar_paciente (
    w_oid_pc IN pacientes.oid_pc%TYPE
) IS
BEGIN
DELETE FROM Pacientes WHERE oid_pc = w_oid_pc;
COMMIT;
END eliminar_paciente;
/

--eliminar linea de la tabla facturas
CREATE OR REPLACE PROCEDURE eliminar_factura (
    w_oid_f IN facturas.oid_f%TYPE
) IS
BEGIN
DELETE FROM Facturas WHERE oid_f = w_oid_f;
COMMIT;
END eliminar_factura;
/

--eliminar linea de la tabla encargos
CREATE OR REPLACE PROCEDURE eliminar_encargo (
    w_oid_e IN encargos.oid_e%TYPE
) IS
BEGIN
DELETE FROM Encargos WHERE oid_e = w_oid_e;
COMMIT;
END eliminar_encargo;
/

--eliminar linea de la tabla proveedores
CREATE OR REPLACE PROCEDURE eliminar_proveedor (
    w_oid_pr IN proveedores.oid_pr%TYPE
) IS
BEGIN
DELETE FROM Proveedores WHERE oid_pr = w_oid_pr;
COMMIT;
END eliminar_proveedor;
/

--eliminar linea de la tabla pedidos
CREATE OR REPLACE PROCEDURE eliminar_pedido (
    w_oid_pd IN pedidos.oid_pd%TYPE
) IS
BEGIN
DELETE FROM Pedidos WHERE oid_pd = w_oid_pd;
COMMIT;
END eliminar_pedido;
/

--eliminar linea de la tabla materiales
CREATE OR REPLACE PROCEDURE eliminar_material (
    w_oid_m IN materiales.oid_m%TYPE
) IS 
BEGIN
DELETE FROM Materiales WHERE oid_m = w_oid_m;
COMMIT;
END eliminar_material;
/

--eliminar linea de la tabla linea de pedido
CREATE OR REPLACE PROCEDURE eliminar_linea (
    w_oid_lp IN linea_pedido.oid_lp%TYPE
) IS
BEGIN
DELETE FROM Linea_pedido WHERE oid_lp = w_oid_lp;
COMMIT;
END eliminar_linea;
/

--eliminar linea de la tabla productos
CREATE OR REPLACE PROCEDURE eliminar_producto (
    w_oid_p IN productos.oid_p%TYPE
) IS
BEGIN
DELETE FROM Productos WHERE oid_p = w_oid_p;
COMMIT;
END eliminar_producto;
/

--eliminar linea de la tabla requiere
CREATE OR REPLACE PROCEDURE eliminar_requiere (
    w_oid_r IN requiere.oid_r%TYPE
) IS
BEGIN
DELETE FROM Requiere WHERE oid_r = w_oid_r;
COMMIT;
END eliminar_requiere;
/ 

--REGLAS DE NEGOCIO
--RN_03
CREATE OR REPLACE PROCEDURE RN_03
IS
    CURSOR C IS
        Select OID_C from clinicas natural join pacientes natural join encargos natural join facturas F where F.fecha_cobro is null and F.Fecha_vencimiento < SYSDATE ;
    w_moroso C%ROWTYPE;
BEGIN
    OPEN C;
    FETCH C into w_moroso;
    While C%Found Loop UPDATE Clinicas SET moroso = 'S' WHERE OID_C = w_moroso.OID_C;
    FETCH C INTO w_moroso;
    END LOOP;
    CLOSE C;
END;
/

--RN_01
CREATE OR REPLACE PROCEDURE RN_01
IS  
    CURSOR C IS SELECT * FROM Encargos ORDER BY fecha_entrega;
    w_encargo encargos%ROWTYPE;
BEGIN   
    OPEN C;
	FETCH C INTO w_encargo;
	DBMS_Output.put_line(RPAD('OID_E',10)||RPAD('Fecha_Entrada',20)||RPAD('Fecha_Entrega',17)||RPAD('OID_PC', 10)||RPAD('OID_F',10));
	WHILE C%Found LOOP DBMS_Output.put_line(RPAD(w_encargo.oid_e,10)
    ||RPAD(w_encargo.fecha_entrada,20)||RPAD(w_encargo.fecha_entrega,17)||RPAD(w_encargo.oid_pc, 10)||RPAD(w_encargo.oid_f,10));
	FETCH C INTO w_encargo;
    END LOOP;
	Close C;
END;
/

--Modificar material
CREATE OR REPLACE PROCEDURE Modifica_material(
    w_oid_m IN materiales.oid_m%TYPE,
    w_stock IN materiales.stock%TYPE,
    w_stock_min IN materiales.stock_min%TYPE,
    w_stock_critico IN materiales.stock_critico%TYPE
)IS
BEGIN
    UPDATE Materiales SET stock=w_stock WHERE oid_m=w_oid_m;
    UPDATE Materiales SET stock_min=w_stock_min WHERE oid_m=w_oid_m;
    UPDATE Materiales SET stock_critico=w_stock_critico WHERE oid_m=w_oid_m;
END;
/

--Modificar clinica
CREATE OR REPLACE PROCEDURE modifica_clinica(
    w_oid_c IN clinicas.oid_c%TYPE,
    w_nombre IN clinicas.nombre%TYPE,
    w_localización IN clinicas.localización%TYPE,
    w_tlf_contacto IN clinicas.tlf_contacto%TYPE,
    w_nombre_dueño IN clinicas.nombre_dueño%TYPE,
    w_num_colegiado IN clinicas.num_colegiado%TYPE
)IS
BEGIN
    UPDATE clinicas SET nombre=w_nombre WHERE oid_c=w_oid_c;
    UPDATE clinicas SET localización=w_localización WHERE oid_c=w_oid_c;
    UPDATE clinicas SET tlf_contacto=w_tlf_contacto WHERE oid_c=w_oid_c;
    UPDATE clinicas SET nombre_dueño=w_nombre_dueño WHERE oid_c=w_oid_c;
    UPDATE clinicas SET num_colegiado=w_num_colegiado WHERE oid_c=w_oid_c;
END;
/

--Modificar factura
CREATE OR REPLACE PROCEDURE modifica_factura(
    w_oid_f IN Facturas.oid_f%TYPE,
    w_fecha_cobro IN Facturas.fecha_cobro%TYPE,
    w_fecha_vencimiento IN Facturas.fecha_vencimiento%TYPE,
    w_fecha_factura IN Facturas.fecha_factura%TYPE,
    w_precio_total IN Facturas.precio_total%TYPE
)IS
BEGIN
    UPDATE Facturas SET fecha_cobro=w_fecha_cobro WHERE oid_f=w_oid_f;
    UPDATE Facturas SET fecha_vencimiento=w_fecha_vencimiento WHERE oid_f=w_oid_f;
    UPDATE Facturas SET fecha_factura=w_fecha_factura WHERE oid_f=w_oid_f;
    UPDATE Facturas SET precio_total=w_precio_total WHERE oid_f=w_oid_f;
END;
/

--Modificar proveedores
CREATE OR REPLACE PROCEDURE modifica_proveedor(
    w_oid_pr IN Proveedores.oid_pr%TYPE,
    w_nombre IN Proveedores.nombre%TYPE,
    w_localización IN Proveedores.localización%TYPE,
    w_tlf_contacto IN Proveedores.tlf_contacto%TYPE
)IS
BEGIN
    UPDATE Proveedores SET nombre=w_nombre WHERE oid_pr=w_oid_pr;
    UPDATE Proveedores SET localización=w_localización WHERE oid_pr=w_oid_pr;
    UPDATE Proveedores SET tlf_contacto=w_tlf_contacto WHERE oid_pr=w_oid_pr;
END;
/

--Modificar paciente
CREATE OR REPLACE PROCEDURE modifica_paciente(
    w_oid_pc IN Pacientes.oid_pc%TYPE,
    w_dni IN Pacientes.dni%TYPE,
    w_fecha_nacimiento IN Pacientes.fecha_nacimiento%TYPE,
    w_sexo IN Pacientes.e_sexo%TYPE
)IS
BEGIN
    UPDATE Pacientes SET dni=w_dni WHERE oid_pc=w_oid_pc;
    UPDATE Pacientes SET fecha_nacimiento=w_fecha_nacimiento WHERE oid_pc=w_oid_pc;
    UPDATE Pacientes SET e_sexo=w_sexo WHERE oid_pc=w_oid_pc;
END;
/

--Modificar encargo
CREATE OR REPLACE PROCEDURE modifica_encargo(
    w_oid_e IN encargos.oid_e%TYPE,
    w_fecha_entrada IN encargos.fecha_entrada%TYPE,
    w_fecha_entrega IN encargos.fecha_entrega%TYPE,
    w_Acciones IN encargos.Acciones%TYPE
)IS
BEGIN
    UPDATE encargos SET fecha_entrada=w_fecha_entrada WHERE oid_e=w_oid_e;
    UPDATE encargos SET fecha_entrega=w_fecha_entrega WHERE oid_e=w_oid_e;
    UPDATE encargos SET Acciones=w_Acciones WHERE oid_e=w_oid_e;
END;
/

--Modificar pedido
CREATE OR REPLACE PROCEDURE modifica_pedido(
    w_oid_pd IN pedidos.oid_pd%TYPE,
    w_fecha_solicitud IN pedidos.fecha_solicitud%TYPE,
    w_fecha_entrega IN pedidos.fecha_entrega%TYPE
)IS
BEGIN
    UPDATE pedidos SET fecha_solicitud=w_fecha_solicitud WHERE oid_pd=w_oid_pd;
    UPDATE pedidos SET fecha_entrega=w_fecha_entrega WHERE oid_pd=w_oid_pd;
END;
/

--Modificar producto
CREATE OR REPLACE PROCEDURE modifica_producto(
    w_oid_p IN Productos.oid_p%TYPE,
    w_nombre IN Productos.nombre%TYPE,
    w_precio IN Productos.precio%TYPE
)IS
BEGIN
    UPDATE Productos SET nombre=w_nombre WHERE oid_p=w_oid_p;
    UPDATE Productos SET precio=w_precio WHERE oid_p=w_oid_p;
END;
/

--FUNCION ASSERT_EQUALS
CREATE OR REPLACE FUNCTION ASSERT_EQUALS(
    salida BOOLEAN,
    salida_esperada BOOLEAN
)   RETURN VARCHAR2 AS
BEGIN
    IF (salida = salida_esperada) THEN
        RETURN 'EXITO';
    ELSE
        RETURN 'FALLO';
    END IF;
END ASSERT_EQUALS;


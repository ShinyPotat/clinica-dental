--BORRAR DISPARADORES
DROP TRIGGER RN_02;

--CREAR DISPARADORES
--RN_02
CREATE OR REPLACE TRIGGER RN_02 
    AFTER INSERT OR UPDATE OF stock ON materiales
    FOR EACH ROW
BEGIN
    IF :NEW.stock < :OLD.stock_min OR :NEW.stock < :OLD.stock_critico 
    THEN
        IF :NEW.stock < :OLD.stock_critico
        THEN DBMS_OUTPUT.PUT_LINE('EL STOCK ESTÁ POR DEBAJO DEL STOCK CRÍTICO.');
        ELSIF :NEW.stock < :OLD.stock_min
        THEN DBMS_OUTPUT.PUT_LINE('EL STOCK ESTÁ POR DEBAJO DEL STOCK MÍNIMO.');
        END IF;
    END IF;
END;
/

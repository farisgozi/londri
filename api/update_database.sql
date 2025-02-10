-- Update transaksi table to handle zero dates
SET SQL_MODE = '';
SET SESSION sql_mode = '';

-- Modify tgl_bayar column to allow zero dates
ALTER TABLE transaksi MODIFY COLUMN tgl_bayar date DEFAULT NULL;

-- Add trigger to handle tgl_bayar
DELIMITER //
CREATE TRIGGER before_insert_transaksi
BEFORE INSERT ON transaksi
FOR EACH ROW
BEGIN
    IF NEW.dibayar = 'dibayar' THEN
        SET NEW.tgl_bayar = CURRENT_DATE;
    ELSE
        SET NEW.tgl_bayar = NULL;
    END IF;
END//
DELIMITER ;
-- Add discount and tax columns to transaksi table
ALTER TABLE transaksi
ADD COLUMN diskon DECIMAL(5,2) DEFAULT 0.00,
ADD COLUMN pajak DECIMAL(5,2) DEFAULT 0.00;

-- Update existing records to have 0 discount and tax
UPDATE transaksi SET diskon = 0.00, pajak = 0.00 WHERE diskon IS NULL;
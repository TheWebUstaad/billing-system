-- Add payment tracking fields to bills table
ALTER TABLE bills 
ADD COLUMN payment_status ENUM('paid', 'pending', 'partial') DEFAULT 'paid',
ADD COLUMN paid_amount DECIMAL(10,2) DEFAULT 0.00; 
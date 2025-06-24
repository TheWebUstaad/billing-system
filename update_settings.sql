-- Insert settings if they don't exist
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
('shop_name', 'My Shop'),
('address', '123 Main Street'),
('phone', '123-456-7890'),
('email', 'shop@example.com'),
('currency_symbol', '₹'),
('footer_text', 'Thank you for shopping with us!');

-- Update existing settings to have default values if they are NULL
UPDATE settings SET setting_value = 'My Shop' WHERE setting_key = 'shop_name' AND (setting_value IS NULL OR setting_value = '');
UPDATE settings SET setting_value = '₹' WHERE setting_key = 'currency_symbol' AND (setting_value IS NULL OR setting_value = ''); 
-- Add updated_at column to bills table for edit functionality
ALTER TABLE bills 
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;

-- Update existing records to have proper updated_at values
UPDATE bills SET updated_at = created_at WHERE updated_at IS NULL; 
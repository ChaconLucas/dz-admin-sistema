-- =====================================================
-- CONVERTER TABELAS PARA UTF8MB4 (encoding correto)
-- Execute este SQL no phpMyAdmin para corrigir encoding
-- =====================================================

-- 1. Converter home_settings
ALTER TABLE home_settings 
    CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Converter home_banners
ALTER TABLE home_banners 
    CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 3. Converter home_featured_products
ALTER TABLE home_featured_products 
    CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 4. Verificar conversão
SELECT 
    TABLE_NAME, 
    TABLE_COLLATION 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'teste_dz' 
AND TABLE_NAME LIKE 'home_%';

-- =====================================================
-- RESULTADO ESPERADO:
-- Todas as tabelas devem mostrar: utf8mb4_unicode_ci
-- =====================================================

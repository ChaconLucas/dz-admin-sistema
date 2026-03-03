<?php
// Teste simples do HTML do banner
require_once 'conexao.php';
require_once 'cms_data_provider.php';

$cms = new CMSProvider($conn);
$banners = $cms->getActiveBanners();

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head><title>Test Banner HTML</title></head>";
echo "<body>";
echo "<h2>HTML Gerado dos Banners:</h2>";

foreach ($banners as $index => $banner) {
    $imageUrl = getBannerImageUrl($banner['image_path'] ?? '');
    $bgStyle = !empty($imageUrl) 
        ? 'background-image: url(\'' . htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') . '\');' 
        : '';
    
    echo "<h3>Banner " . ($index + 1) . ":</h3>";
    echo "<pre>";
    echo "DB image_path: " . htmlspecialchars($banner['image_path']) . "\n";
    echo "getBannerImageUrl(): " . htmlspecialchars($imageUrl) . "\n";
    echo "Style attribute: " . htmlspecialchars($bgStyle) . "\n";
    echo "</pre>";
    
    echo "<div style='width: 400px; height: 200px; border: 2px solid red; " . $bgStyle . " background-size: cover;'>";
    echo "<p style='background: white; padding: 10px;'>Este é o banner " . ($index + 1) . "</p>";
    echo "</div>";
    echo "<br><br>";
}

echo "<h3>Teste de Caminho Direto:</h3>";
$testPath = "../uploads/banners/banner_1772545757_69a6e6dd478da.png";
echo "<img src='$testPath' style='max-width: 400px; border: 2px solid green;'>";
echo "<p>Se a imagem acima aparecer, o caminho está correto!</p>";

echo "</body>";
echo "</html>";
?>

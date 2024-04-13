<?php

$product_id = $_GET['id'];

$product = getProductDetails($product_id);

echo '
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/ProductDetails.css">
</head>
<body>
    <div class="product-details">
        <div class="image-gallery">
            <div class="focused-image-container">
                <img src="' . $product['thumbnail'] . '" alt="' . $product['title'] . '" class="focused-image" />
                <!-- Dugmad za navigaciju kroz slike -->
                <button class="arrow-button left" onclick="prevImage()">&lt;</button>
                <button class="arrow-button right" onclick="nextImage()">&gt;</button>
                <button class="maximize-button" onclick="maximizeImage()">🔍</button>
            </div>
            <div class="thumbnail-list">
                <!-- Prikažite galeriju slika -->
                '. renderThumbnails($product) .'
            </div>
        </div>
        <div class="product-info">
            <h2 class="product-title">' . $product['title'] . '</h2>
            <p class="product-description">' . $product['description'] . '</p>
            <table>
                <tr>
                    <th>Brand</th>
                    <td>' . $product['brand'] . '</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>' . $product['category'] . '</td>
                </tr>
                <tr>
                    <th>Rating</th>
                    <td>' . $product['rating'] . '</td>
                </tr>
                <tr>
                    <th>In Stock</th>
                    <td>' . $product['stock'] . '</td>
                </tr>
            </table>
            <div class="price-and-discount">
                <span class="price">$' . $product['price'] . '</span>
                <p></p>
                <span class="discount">-' . $product['discountPercentage'] . '%</span> 
             </div>
        </div>
        <button class="go-back-button" onclick="window.history.back()">Go Back</button>
    </div>
</body>
</html>
';

function renderThumbnails($product) {
    $thumbnails_html = '';
    foreach ($product['images'] as $index => $image) {
        $active_class = ($index == 0) ? 'active' : '';
        $thumbnails_html .= '<img src="' . $image . '" alt="Thumbnail" class="thumbnail ' . $active_class . '" onclick="selectThumbnail(' . $index . ')"/>';
    }
    return $thumbnails_html;
}

function getProductDetails($product_id) {
    
    $apiUrl = 'https://dummyjson.com/products/' . $product_id;
    
    $jsonData = file_get_contents($apiUrl);
    
    if ($jsonData === false) {
        echo 'Error fetching product details.';
        return null;
    }
    
    $productDetails = json_decode($jsonData, true);
    
    return $productDetails;
}

?>



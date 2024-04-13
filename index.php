<?php
header("Content-Type: text/html; charset=utf-8");

$api_url = "https://dummyjson.com/products?limit=10";
$json_data = file_get_contents($api_url);
$data = json_decode($json_data, true);
$products = $data['products'];

$total_products = $data['total'];
$products_per_page = 10;
$total_pages = ceil($total_products / $products_per_page);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($page < 1) {
    $page = 1;
} elseif ($page > $total_pages) {
    $page = $total_pages;
}

$start_index = ($page - 1) * $products_per_page;
$end_index = min($start_index + $products_per_page, $total_products);

$api_url = "https://dummyjson.com/products?skip=$start_index&limit=$products_per_page";
$json_data = file_get_contents($api_url);
$data = json_decode($json_data, true);
$products = $data['products'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="styles/ProductList.css">
</head>
<body>

    <ul class="product-list">
        <h1 class="product-list-title">Product List</h1>
        <?php
        foreach ($products as $product) {
            echo '
                <li class="product-item">
                    <a href="components/productDetails.php?id=' . $product['id'] . '">
                        <h2 class="product-title">' . $product['title'] . '</h2>
                        <img src="' . $product['thumbnail'] . '" alt="' . $product['title'] . '" class="product-image" />
                    </a>
                    <div class="product-info">
                        <p class="product-description">' . $product['description'] . '</p>
                    </div>
                </li>
            ';
        }
        
        ?>
    </ul>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>"><button>Previous</button></a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>"><button class="<?php echo ($i == $page) ? 'current-page' : ''; ?>"><?php echo $i; ?></button></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>"><button>Next</button></a>
        <?php endif; ?>
    </div>
</body>
</html>






<?php
// ==== CONFIG ====
$site_url = 'https://jaydeepagro.com';
$wp_username = 'admin'; // 🔁 change this
$app_password = 'j0el VkMc B7wG G7HV Vkt1 r842'; // 🔁 24-char app password

$consumer_key = 'ck_bed39b2ed2985edbe7e6c66051e06d96fc889473';
$consumer_secret = 'cs_4cfdf8d8721558ff8e8915233063bca8cf30933c';

$product_result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $short_description = $_POST['short_description'];
    $description = $_POST['description'];
    $sku = $_POST['sku'];
    $stock = $_POST['stock'];
    $category_name = $_POST['category'];
    $color = $_POST['color'];
    $material = $_POST['material'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $weights = $_POST['weights'];
    $prices = $_POST['prices'];

    // STEP 1: Upload Image
    $image_url = '';
    if (isset($_FILES['product_image']) && $_FILES['product_image']['tmp_name']) {
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $image_name = basename($_FILES['product_image']['name']);
        $image_type = mime_content_type($image_tmp);
        $image_data = file_get_contents($image_tmp);

        $upload_url = "$site_url/wp-json/wp/v2/media";

        $ch = curl_init($upload_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$wp_username:$app_password");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Disposition: attachment; filename="' . $image_name . '"',
            'Content-Type: ' . $image_type
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $image_data);
        $media_response = curl_exec($ch);
        curl_close($ch);

        $media = json_decode($media_response, true);
        if (!empty($media['source_url'])) {
            $image_url = $media['source_url'];
        }
    }

    // STEP 2: Check/Create Category
    $category_id = null;
    $cat_check_url = "$site_url/wp-json/wc/v3/products/categories?search=" . urlencode($category_name);
    $cat_response = file_get_contents($cat_check_url . "&consumer_key=$consumer_key&consumer_secret=$consumer_secret");
    $cat_data = json_decode($cat_response, true);
    if (!empty($cat_data[0]['id'])) {
        $category_id = $cat_data[0]['id'];
    } else {
        $cat_create_url = "$site_url/wp-json/wc/v3/products/categories?consumer_key=$consumer_key&consumer_secret=$consumer_secret";
        $ch = curl_init($cat_create_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['name' => $category_name]));
        $cat_create_response = curl_exec($ch);
        curl_close($ch);
        $cat_created = json_decode($cat_create_response, true);
        $category_id = $cat_created['id'] ?? null;
    }

    // STEP 3: Create Variable Product with Weight Options
    $attributes = [
        [
            "name" => "Weight",
            "visible" => true,
            "variation" => true,
            "options" => $weights
        ]
    ];

    $product_data = [
        "name" => $product_name,
        "type" => "variable",
        "description" => $description,
        "short_description" => $short_description,
        "sku" => $sku,
        "manage_stock" => false,
        "in_stock" => true,
        "categories" => $category_id ? [["id" => $category_id]] : [],
        "images" => $image_url ? [["src" => $image_url]] : [],
        "attributes" => $attributes,
        "dimensions" => [
            "length" => $length,
            "width" => $width,
            "height" => $height
        ]
    ];

    $create_url = "$site_url/wp-json/wc/v3/products?consumer_key=$consumer_key&consumer_secret=$consumer_secret";
    $ch = curl_init($create_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($product_data));
    $product_response = curl_exec($ch);
    curl_close($ch);

    $product = json_decode($product_response, true);

    if (!empty($product['id'])) {
        $product_id = $product['id'];

        // Add Variations
        foreach ($weights as $index => $w) {
            $variation = [
                'regular_price' => $prices[$index],
                'attributes' => [
                    ["name" => "Weight", "option" => $w]
                ]
            ];
            $var_url = "$site_url/wp-json/wc/v3/products/$product_id/variations?consumer_key=$consumer_key&consumer_secret=$consumer_secret";
            $ch = curl_init($var_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($variation));
            curl_exec($ch);
            curl_close($ch);
        }

        $product_result = "<p style='color:green;'>✅ Product with variations created successfully: <a href='{$product['permalink']}' target='_blank'>{$product['name']}</a></p>";
    } else {
        $product_result = "<p style='color:red;'>❌ Product creation failed!</p><pre>" . print_r($product, true) . "</pre>";
    }
}
?>

<!-- === FRONTEND HTML FORM === -->
<!DOCTYPE html>
<html>
<head>
    <title>Add WooCommerce Product</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f7f7f7; }
        form { background: #fff; padding: 20px; border-radius: 10px; width: 500px; }
        input, textarea, select { width: 100%; padding: 10px; margin-top: 10px; }
        button { padding: 10px 20px; margin-top: 15px; background: green; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Add New Product</h2>
    <?= $product_result ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Product Name</label>
        <input type="text" name="product_name" required>

        <label>Short Description</label>
        <textarea name="short_description" rows="3" required></textarea>

        <label>Description</label>
        <textarea name="description" rows="5" required></textarea>

        <label>SKU</label>
        <input type="text" name="sku" required>

        <label>Stock Quantity</label>
        <input type="number" name="stock" required>

        <label>Category</label>
        <input type="text" name="category" required>

        <label>Product Image</label>
        <input type="file" name="product_image" accept="image/*" required>

        <label>Color</label>
        <input type="text" name="color" required>

        <label>Material</label>
        <input type="text" name="material" required>

        <label>Dimensions (cm)</label>
        <input type="text" name="length" placeholder="Length" required>
        <input type="text" name="width" placeholder="Width" required>
        <input type="text" name="height" placeholder="Height" required>

        <label>Weight Options</label>
        <input type="text" name="weights[]" placeholder="e.g. 250gm" required>
        <input type="text" name="weights[]" placeholder="e.g. 500gm">
        <input type="text" name="weights[]" placeholder="e.g. 1kg">

        <label>Prices for each Weight</label>
        <input type="text" name="prices[]" placeholder="Price for 250gm" required>
        <input type="text" name="prices[]" placeholder="Price for 500gm">
        <input type="text" name="prices[]" placeholder="Price for 1kg">

        <button type="submit">Add Product</button>
    </form>
</body>
</html>

<?php
require_once __DIR__ . '/../config/config.php';
$pageTitle = isset($pageTitle) ? $pageTitle . ' | ' . APP_NAME : APP_TITLE;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    
    <!-- Google Fonts: Outfit (Headings) & Inter (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Core Application CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="/assets/css/graph.css">

    <!-- Global Backend API Configuration -->
    <script>
        window.BACKEND_API_URL = "<?= BACKEND_API_URL ?>";
    </script>
</head>
<body class="<?= isset($bodyClass) ? $bodyClass : '' ?>">

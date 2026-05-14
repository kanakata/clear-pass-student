<?php
// Store path once to keep the code clean
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Determine which stylesheet to use
$landingPaths = ['/landing', '/selectInstitution', '/'];
$stylesheet = in_array($currentPath, $landingPaths) ? "app.css" : "style.css";

// Determine body overflow logic
$isLocked = isset($_SESSION['login_success']) || !empty($actionStatus);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Clear Pass: <?= e($pageName) ?>. School clearance simplified and tailored to meet your needs.">

    <title><?= e($pageName) ?> || Clear Pass</title>

    <!-- Preload critical branding image -->
    <?php if (isset($_SESSION['school_name'])): ?>
        <link rel="preload" fetchpriority="high" as="image" href="./assets/branding/<?= e($_SESSION['school_name']) ?>.jpg">
    <?php endif; ?>

    <link rel="shortcut icon" href="./assets/icons/favicon.svg" type="image/svg+xml">

    <link rel="stylesheet" href="./css/<?= $stylesheet ?>" type="text/css">

    <script src="./js/config.js" defer></script>
</head>

<body style="overflow: <?= $isLocked ? 'hidden' : 'auto' ?>;">

<?php
require_once 'includes/config.php';

if (!isset($pageTitle)) {
    $pageTitle = $siteTitle;
} else {
    $pageTitle = $pageTitle . " - " . $siteTitle;
}

if (!isset($pageCss)) {
    $pageCss = $cssPath . "styles.css";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo $cssPath; ?>styles.css">
    <?php if ($pageCss != $cssPath . "styles.css"): ?>
    <link rel="stylesheet" href="<?php echo $pageCss; ?>">
    <?php endif; ?>
    <?php if (isset($useChartJs) && $useChartJs): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>
    <?php if (isset($headerExtras)) echo $headerExtras; ?>
    <style>
        .main-content {
            background-image: url('<?php echo $imagesPath; ?>background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
    <div class="container">
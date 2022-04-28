<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />

    <meta name="author" content="<?= System::getSystemInfos('website'); ?>" />
    <meta name="description" content="<?= System::getSystemInfos('meta_desc'); ?>" />
    
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="<?= System::getSystemInfos('website'); ?>" />
    <meta name="twitter:creator" content="<?= System::getSystemInfos('website'); ?>" />

    <meta property="og:image" content="/img/<?= System::getSystemInfos('meta_img'); ?>" />
    <meta property="og:description" content="<?= System::getSystemInfos('meta_desc'); ?>" />
    <meta property="og:title" content="<?= System::getSystemInfos('website'); ?>" />
    
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/css/style.css" />
</head>

<body>
    <header><?php require_once 'Header.php'; ?></header>

    <?= $content; ?>

    <footer><?php require_once 'Footer.php' ; ?></footer>

    <script src="/js/mains.js"></script>
</body>

</html>
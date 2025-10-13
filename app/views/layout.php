<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Sistema de Agendamento' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSS global -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= $faviconImg ?? (BASE_URL . '/assets/img/favicon.png') ?>">

    <!-- CSS dinâmico (do controller) -->
    <?php if (!empty($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($style, ENT_QUOTES, 'UTF-8') ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- JS dinâmico no head (do controller) -->
    <?php if (!empty($pageScriptsHeader)): ?>
        <?php foreach ($pageScriptsHeader as $script): ?>
            <script src="<?= htmlspecialchars($script, ENT_QUOTES, 'UTF-8') ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- JS global -->
    <!-- <script src="<?= BASE_URL ?>/js/script.js" defer></script> -->
</head>

<body class="bg-gray-100 flex flex-col h-screen">

    <!-- Header -->
    <?php require_once __DIR__ . '/partials/header.php'; ?>

    <!-- Conteúdo da página -->
    <main class="container mx-auto p-6 flex-1">
        <!-- <main class="container mx-auto px-4 md:px-8"> -->
        <?php if (!empty($pageContent)) echo $pageContent; ?>
    </main>

    <!-- Footer -->
    <?php require_once __DIR__ . '/partials/footer.php'; ?>

    <!-- JS dinâmico no rodapé (do controller) -->
    <?php if (!empty($pageScriptsFooter)): ?>
        <?php foreach ($pageScriptsFooter as $script): ?>
            <script src="<?= htmlspecialchars($script, ENT_QUOTES, 'UTF-8') ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>


</body>

</html>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Sistema de Agendamento' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="icon" type="image/png" href="<?= $faviconImg ?? (BASE_URL . '/assets/img/favicon.png') ?>">

    <?php if (!empty($pageStyles)): foreach ($pageStyles as $style): ?>
        <link rel="stylesheet" href="<?= htmlspecialchars($style, ENT_QUOTES, 'UTF-8') ?>">
    <?php endforeach; endif; ?>
    <?php if (!empty($pageScriptsHeader)): foreach ($pageScriptsHeader as $script): ?>
        <script src="<?= htmlspecialchars($script, ENT_QUOTES, 'UTF-8') ?>"></script>
    <?php endforeach; endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <?php
    use App\Core\Auth;
    // ATUALIZADO: Define explicitamente as páginas que DEVEM ter o layout fixo.
    $fixedLayoutPages = ['home', 'dashboard', 'perfil', 'course_show'];
    
    // A variável $viewName é definida no BaseController
    $isFixedLayout = Auth::isLogged() && isset($viewName) && in_array($viewName, $fixedLayoutPages);
    
    // Disponibiliza a variável globalmente para ser usada no header.php
    $GLOBALS['isFixedLayout'] = $isFixedLayout;
    $showSidebar = $isFixedLayout;
    ?>

    <!-- Barra Lateral Fixa (condicional) -->
    <?php if ($showSidebar): ?>
        <?php require_once __DIR__ . '/partials/course_sidebar.php'; ?>
    <?php endif; ?>

    <!-- Wrapper de Conteúdo Principal -->
    <div class="flex flex-col min-h-screen <?php if ($showSidebar): ?>lg:ml-64<?php endif; ?>">
        
        <!-- Header -->
        <?php require_once __DIR__ . '/partials/header.php'; ?>

        <!-- Conteúdo da página (com padding condicional para o header fixo) -->
        <main class="flex-grow container mx-auto p-6 <?php if ($isFixedLayout): ?>pt-24<?php endif; ?>">
            <?php if (!empty($pageContent)) echo $pageContent; ?>
        </main>

        <!-- Footer -->
        <?php require_once __DIR__ . '/partials/footer.php'; ?>

    </div>

    <!-- JS dinâmico no rodapé -->
    <?php if (!empty($pageScriptsFooter)): foreach ($pageScriptsFooter as $script): ?>
        <script src="<?= htmlspecialchars($script, ENT_QUOTES, 'UTF-8') ?>"></script>
    <?php endforeach; endif; ?>

</body>

</html>


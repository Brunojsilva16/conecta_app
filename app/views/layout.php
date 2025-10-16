<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Plataforma de Cursos') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="icon" type="image/png" href="<?= $faviconImg ?? (BASE_URL . '/assets/img/favicon.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-100">

<?php
use App\Core\Auth;
$isLoggedIn = Auth::isLogged();
// Lista de páginas que NÃO devem exibir a barra lateral
$noSidebarPages = ['login', 'esqueci-a-senha', 'planos']; 
$currentRoute = trim($_GET['url'] ?? '', '/');

$showSidebar = $isLoggedIn && !in_array($currentRoute, $noSidebarPages);
?>

<?php if ($showSidebar): ?>
    <?php // A barra lateral SÓ é incluída se a condição for verdadeira ?>
    <?php require_once VIEWS_PATH . '/partials/course_sidebar.php'; ?>
<?php endif; ?>

<!-- 
  Container principal que envolve todo o conteúdo à direita da barra lateral.
  - `lg:ml-64`: Adiciona uma margem à esquerda em telas grandes, empurrando o conteúdo para o lado 
    e evitando que ele fique escondido sob a barra lateral.
-->
<div class="flex flex-col min-h-screen <?= $showSidebar ? 'lg:ml-64' : '' ?>">

    <!-- Header (cabeçalho) -->
    <?php require_once VIEWS_PATH . '/partials/header.php'; ?>

    <!-- Conteúdo da página -->
    <main class="flex-grow p-6">
        <?= $pageContent ?? '' ?>
    </main>

    <!-- Footer (rodapé) -->
    <?php require_once VIEWS_PATH . '/partials/footer.php'; ?>
</div>

</body>
</html>


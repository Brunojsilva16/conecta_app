<footer class="bg-white mt-auto">
    <div class="container mx-auto px-6 py-4">
        <div class="text-center text-gray-600">
            &copy; <?= date('Y') ?> Plataforma de Cursos. Todos os direitos reservados.
        </div>
    </div>
</footer>

<!-- JS dinâmico no footer -->
<?php if (!empty($pageScriptsFooter)): ?>
    <?php foreach ($pageScriptsFooter as $script): ?>
        <script src="<?= htmlspecialchars($script, ENT_QUOTES, 'UTF-8') ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
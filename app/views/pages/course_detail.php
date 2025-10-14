<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna Esquerda: Detalhes -->
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <ul class="divide-y divide-gray-200">
                    <?php foreach ($course['details'] as $key => $value): ?>
                    <li class="flex justify-between items-center py-3">
                        <span class="font-semibold text-gray-700"><?= htmlspecialchars($key) ?></span>
                        <span class="text-gray-900 font-bold"><?= htmlspecialchars($value) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <img src="<?= htmlspecialchars($course['image_url']) ?>" alt="Banner do curso" class="w-full rounded-lg">
                <!-- Outras informações do curso como descrição, professores, etc. podem ir aqui -->
            </div>
        </div>

        <!-- Coluna Direita: Inscrição -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-8">
                <div class="text-center mb-6">
                     <p class="text-lg text-gray-600">EM ATÉ 12X SEM JUROS</p>
                     <p class="text-4xl font-extrabold text-gray-900 my-2"><?= htmlspecialchars($course['price']) ?></p>
                </div>
                <button class="w-full bg-gray-800 text-white font-bold py-4 px-4 rounded-lg hover:bg-gray-700 transition duration-300 text-lg">
                    Inscreva-se
                </button>
            </div>
        </div>
    </div>
</div>

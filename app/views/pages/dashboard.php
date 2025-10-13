<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Meus Cursos</h1>

    <?php if (empty($courses)): ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
            <p class="font-bold">Nenhum curso encontrado</p>
            <p>Você ainda não adquiriu nenhum curso. <a href="<?= BASE_URL ?>/" class="underline">Explore nossos cursos</a>.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($courses as $course): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <img src="<?= htmlspecialchars($course['image_url']) ?>" alt="Capa do curso <?= htmlspecialchars($course['title']) ?>" class="w-full h-56 object-cover">
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex-grow">
                            <?= htmlspecialchars($course['title']) ?>
                        </h3>
                        <button class="w-full mt-auto bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Acessar Curso
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="container mx-auto px-4 py-8">
    
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Explore Nossos Cursos</h1>
        <p class="text-lg text-gray-600 mt-2">Conhecimento para transformar sua carreira.</p>
    </div>

    <?php if (!empty($courses) && is_array($courses)): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($courses as $course): ?>
            <div class="course-card bg-white rounded-lg shadow-lg overflow-hidden flex flex-col hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="relative">
                    <?php
                        $imageUrl = !empty($course['image_url']) 
                            ? BASE_URL . htmlspecialchars($course['image_url']) 
                            : BASE_URL . '/assets/img/default_course.svg'; // Caminho para a imagem padrão
                    ?>
                    <img src="<?= $imageUrl ?>" alt="Capa do curso <?= htmlspecialchars($course['title']) ?>" class="w-full h-48 object-cover">
                    <span class="absolute top-2 right-2 text-xs font-semibold px-3 py-1 rounded-full category-tag-<?= strtolower($course['category'] ?? '') ?>">
                        <?= htmlspecialchars(ucfirst($course['category'] ?? '')) ?>
                    </span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 h-16"><?= htmlspecialchars($course['title']) ?></h3>
                    
                    <div class="flex justify-between items-center text-sm text-gray-600 mb-4 border-t pt-4 mt-auto">
                        <span>
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <?= htmlspecialchars($course['workload'] ?? 'N/D') ?>
                        </span>
                        <span class="text-lg font-bold text-indigo-600">
                             <?php if (!empty($course['price']) && $course['price'] > 0): ?>
                                R$ <?= htmlspecialchars(number_format($course['price'], 2, ',', '.')) ?>
                            <?php else: ?>
                                Gratuito
                            <?php endif; ?>
                        </span>
                    </div>

                    <a href="<?= BASE_URL ?>/curso/<?= $course['id'] ?>" class="block text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-150">
                        Ver Detalhes
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <h3 class="text-xl font-semibold text-gray-700">Nenhum curso disponível no momento</h3>
            <p class="text-gray-500 mt-2">Estamos a preparar novos conteúdos incríveis. Volte em breve!</p>
        </div>
    <?php endif; ?>
</div>


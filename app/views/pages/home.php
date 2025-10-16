<?php if (!empty($courses) && is_array($courses)): ?>
<div class="courses-grid grid grid-cols-1 md:grid-cols-3 gap-8">
    <?php foreach ($courses as $course): ?>
        <div class="course-card bg-white rounded-lg shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300 flex flex-col">
            <?php
                // Define uma imagem placeholder caso a do curso não exista
                $imageUrl = !empty($course['image_url']) 
                    ? BASE_URL . htmlspecialchars($course['image_url']) 
                    : 'https://placehold.co/400x225/6D28D9/FFFFFF?text=Curso';
            ?>
            <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($course['title']) ?>" class="w-full h-48 object-cover">
            
            <div class="p-6 flex flex-col flex-grow">
                <h3 class="text-xl font-bold text-gray-900 mb-4 h-16"><?= htmlspecialchars($course['title']) ?></h3>
                
                <?php if ($course['status'] === 'published'): ?>
                    <!-- ATUALIZADO: Layout de preço e carga horária -->
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-lg font-semibold text-indigo-600">
                            <?php if (!empty($course['price']) && $course['price'] > 0): ?>
                                R$ <?= htmlspecialchars(number_format($course['price'], 2, ',', '.')) ?>
                            <?php else: ?>
                                Gratuito
                            <?php endif; ?>
                        </p>
                        <?php if (!empty($course['workload'])): ?>
                            <span class="text-md font-bold text-gray-700">
                                <?= htmlspecialchars($course['workload']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <!-- Fim da Atualização -->

                    <div class="mt-auto">
                        <a href="<?= BASE_URL ?>/curso/<?= $course['id'] ?>" class="block text-center bg-gradient-to-r from-indigo-500 to-blue-600 text-white py-2 rounded-lg font-semibold hover:from-indigo-600 hover:to-blue-700 transition duration-150">
                            Ver Detalhes
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-md font-semibold text-red-500 mb-4">Indisponível</p>
                    <button disabled class="w-full text-center bg-gray-300 text-gray-600 py-2 rounded-lg font-semibold cursor-not-allowed mt-auto">
                        Indisponível
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php else: ?>
    <!-- Mensagem de fallback se não houver cursos -->
    <div class="text-center py-12 bg-gray-50 rounded-lg">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.467 9.5 5 8 5a2.5 2.5 0 00-2.5 2.5c0 .356.126.702.355 1.011l.732 1.026a3.5 3.5 0 00-.73 3.633l-.75.75A1 1 0 004 15.5V17a1 1 0 001 1h14a1 1 0 001-1v-1.5a1 1 0 00-.205-.623l-.75-.75a3.5 3.5 0 00-.73-3.633l.732-1.026c.229-.309.355-.655.355-1.011A2.5 2.5 0 0016 5c-1.5 0-2.832.467-4 1.253z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum Curso Disponível</h3>
        <p class="mt-1 text-sm text-gray-500">Volte mais tarde para conferir nossos lançamentos!</p>
    </div>
<?php endif; ?>

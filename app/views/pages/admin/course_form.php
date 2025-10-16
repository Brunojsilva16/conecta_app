<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6"><?= $title ?></h1>

    <div class="bg-white p-6 rounded-lg shadow-xl max-w-2xl mx-auto">
        <form action="<?= $action ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Título do Curso</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($course['title'] ?? '') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"><?= htmlspecialchars($course['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label for="instructor" class="block text-sm font-medium text-gray-700">Instrutor</label>
                <input type="text" name="instructor" id="instructor" value="<?= htmlspecialchars($course['instructor'] ?? '') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
                <input type="number" step="0.01" name="price" id="price" value="<?= htmlspecialchars($course['price'] ?? '') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- NOVOS CAMPOS -->
            <div>
                <label for="workload" class="block text-sm font-medium text-gray-700">Carga Horária (ex: 45h)</label>
                <input type="text" name="workload" id="workload" value="<?= htmlspecialchars($course['workload'] ?? '') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="target_audience" class="block text-sm font-medium text-gray-700">Público-alvo</label>
                <textarea name="target_audience" id="target_audience" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"><?= htmlspecialchars($course['target_audience'] ?? '') ?></textarea>
            </div>
            <div>
                <label for="format" class="block text-sm font-medium text-gray-700">Formato</label>
                <input type="text" name="format" id="format" value="<?= htmlspecialchars($course['format'] ?? '') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="level" class="block text-sm font-medium text-gray-700">Nível</label>
                <input type="text" name="level" id="level" value="<?= htmlspecialchars($course['level'] ?? '') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="modality" class="block text-sm font-medium text-gray-700">Modalidade</label>
                <input type="text" name="modality" id="modality" value="<?= htmlspecialchars($course['modality'] ?? '') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- NOVO CAMPO CATEGORIA -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Categoria do Curso</label>
                <select name="category" id="category" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="essential" <?= (isset($course['category']) && $course['category'] === 'essential') ? 'selected' : '' ?>>Essential</option>
                    <option value="premium" <?= (isset($course['category']) && $course['category'] === 'premium') ? 'selected' : '' ?>>Premium</option>
                    <option value="platinum" <?= (isset($course['category']) && $course['category'] === 'platinum') ? 'selected' : '' ?>>Platinum</option>
                </select>
            </div>


            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Imagem do Curso</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100">
                
                <div id="image-preview-container" class="mt-4">
                    <?php if (!empty($course['image_url'])): ?>
                        <p class="text-sm text-gray-600 mb-2">Imagem atual:</p>
                        <img id="image-preview" src="<?= BASE_URL . htmlspecialchars($course['image_url']) ?>" alt="Pré-visualização da imagem" class="h-32 w-auto rounded-md shadow-sm">
                        <input type="hidden" name="current_image_url" value="<?= htmlspecialchars($course['image_url']) ?>">
                    <?php else: ?>
                        <p id="no-image-text" class="text-sm text-gray-500">Nenhuma imagem selecionada.</p>
                        <img id="image-preview" src="" alt="Pré-visualização da imagem" class="h-32 w-auto rounded-md shadow-sm hidden">
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="published" <?= (isset($course['status']) && $course['status'] === 'published') ? 'selected' : '' ?>>Publicado</option>
                    <option value="draft" <?= (isset($course['status']) && $course['status'] === 'draft') ? 'selected' : '' ?>>Rascunho</option>
                </select>
            </div>

            <div class="flex justify-end">
                <a href="<?= BASE_URL ?>/admin/courses" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300 mr-4">
                    Cancelar
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(event) {
    const preview = document.getElementById('image-preview');
    const noImageText = document.getElementById('no-image-text');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if(noImageText) noImageText.classList.add('hidden');
        }
        
        reader.readAsDataURL(file);
    }
});
</script>


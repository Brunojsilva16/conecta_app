<?php use App\Core\Auth; ?>

<div class="bg-white">
  <div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
      
      <!-- Coluna da Imagem -->
      <div>
        <img src="<?= BASE_URL . htmlspecialchars($course['image_url']) ?>" alt="Capa do curso <?= htmlspecialchars($course['title']) ?>" class="w-full rounded-lg shadow-xl object-cover">
      </div>

      <!-- Coluna de Informações e Compra -->
      <div class="flex flex-col h-full">
        <h1 class="text-4xl font-bold text-gray-900 tracking-tight"><?= htmlspecialchars($course['title']) ?></h1>
        <p class="mt-2 text-lg text-gray-600">com <?= htmlspecialchars($course['instructor']) ?></p>
        
        <div class="mt-6 text-gray-700 space-y-4 text-base">
            <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
        </div>
        
        <div class="mt-auto pt-8">
            <div class="bg-gray-50 p-6 rounded-lg border">
                <p class="text-xl font-medium text-gray-600">Preço do curso:</p>
                <p class="text-5xl font-extrabold text-gray-900 mt-2">
                    R$ <?= htmlspecialchars(number_format($course['price'], 2, ',', '.')) ?>
                </p>
                
                <div class="mt-6">
                    <?php if (Auth::isLogged()): ?>
                        <?php if ($userHasCourse): ?>
                            <a href="<?= BASE_URL ?>/dashboard" class="w-full flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                Já possui este curso. Aceder ao painel
                            </a>
                        <?php else: ?>
                            <form action="<?= BASE_URL ?>/curso/comprar/<?= $course['id'] ?>" method="POST">
                                <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700">
                                    Comprar Agora
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/login" class="w-full flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900">
                            Faça login para comprar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

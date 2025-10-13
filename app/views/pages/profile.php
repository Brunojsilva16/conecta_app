<?php
// Verifica e exibe mensagens de sessão (sucesso ou erro)
if (isset($_SESSION['success_message'])): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
    </div>
<?php unset($_SESSION['success_message']);
endif;

if (isset($_SESSION['error_message'])): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p><?= htmlspecialchars($_SESSION['error_message']) ?></p>
    </div>
<?php unset($_SESSION['error_message']);
endif;
?>

<div class="max-w-xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Configurações do Perfil</h1>
    <div class="bg-white p-6 rounded-lg shadow-xl">
        <form action="<?= BASE_URL ?>/perfil/atualizar" method="POST" class="space-y-6">

            <!-- Campo Nome (Editável) -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Campo CPF (Editável) -->
            <div>
                <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                <input type="text" name="cpf" id="cpf" value="<?= htmlspecialchars($user['cpf'] ?? '') ?>"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Apenas números">
            </div>

            <!-- Campo E-mail (Não Editável) -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email (Não Editável)</label>
                <input type="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                    class="mt-1 block w-full border border-gray-200 bg-gray-50 rounded-md shadow-sm p-3 cursor-not-allowed" readonly>
            </div>

            <!-- Botão de Submissão -->
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
                Salvar Alterações
            </button>
        </form>
    </div>
</div>
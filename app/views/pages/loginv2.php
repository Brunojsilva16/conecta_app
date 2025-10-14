<div class="flex items-center justify-center min-h-full py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
                Acesse sua conta
            </h2>
        </div>
        <form class="mt-8 space-y-6" action="<?= BASE_URL ?>/login" method="POST">
            <input type="hidden" name="remember" value="true">
            <div class="-space-y-px rounded-md shadow-sm">
                <div>
                    <label for="email-address" class="sr-only">Email</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required
                        class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Email" value="aluno@email.com">
                </div>
                <div>
                    <label for="password" class="sr-only">Senha</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Senha" value="123456">
                </div>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <p class="text-red-500 text-sm text-center">Credenciais inválidas. Tente novamente.</p>
            <?php endif; ?>

            <div>
                <button type="submit"
                    class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Entrar
                </button>
            </div>
             <div class="text-sm text-center">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Não tem uma conta? Cadastre-se
                </a>
            </div>
        </form>
    </div>
</div>

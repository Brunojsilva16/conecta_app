<?php 
// Esta view agora é um pedaço de código PHP que será incluído
// dentro do layout principal (layout.php).
?>

<!-- Painel do Usuário (A div que contém o conteúdo da página) -->
<!-- A estrutura HTML (<html>, <head>, <body>) e o CSS/Fontes devem ser carregados no layout.php -->
<div id="dashboard-view" class="min-h-screen">
    
    <!-- Conteúdo Principal -->
    <!-- Ajustei a margem superior para compensar a falta do cabeçalho da view -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-8"> 
        
        <!-- Boas-vindas e Título -->
        <h2 class="text-3xl font-bold text-slate-900">Meus Cursos</h2>
        <!-- Usa a variável PHP $userName que vem do DashboardController -->
        <p class="mt-1 text-slate-600">Bem-vindo(a) de volta, <strong id="welcome-username" class="font-medium"><?= htmlspecialchars($userName ?? 'Visitante') ?></strong>! Aqui estão seus cursos.</p>

        <!-- Alerta de Simulação -->
        <div class="mt-6 bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-md flex items-start space-x-3">
            <i data-lucide="database" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
            <div>
                <h3 class="font-semibold">Simulação MVC/MySQL</h3>
                <p class="text-sm">Os dados são carregados de um Mock Service e não refletem o progresso real no banco de dados.</p>
            </div>
        </div>

        <!-- Container dos Cursos -->
        <div id="courses-container" class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Os cards dos cursos serão inseridos aqui pelo JavaScript -->
        </div>
        
        <?php if (empty($userCourses)): ?>
            <div class="text-center py-12 bg-gray-50 rounded-lg mt-8">
                <i data-lucide="graduation-cap" class="w-10 h-10 mx-auto text-gray-400 mb-3"></i>
                <h3 class="text-xl font-semibold text-gray-700">Nenhum curso encontrado</h3>
                <p class="text-gray-500">Parece que você ainda não se inscreveu em nenhum curso.</p>
            </div>
        <?php endif; ?>
    </main>
</div>

<script>
    // Os dados dos cursos agora vêm da variável PHP $userCourses
    const coursesData = <?= json_encode($userCourses ?? []) ?>;

    // --- ELEMENTOS DO DOM ---
    const coursesContainer = document.getElementById('courses-container');
    
    // --- FUNÇÕES ---

    /**
     * Renderiza os cards de cursos na tela
     */
    function renderCourses() {
        coursesContainer.innerHTML = ''; // Limpa o container

        // Verifica se lucide está disponível antes de usá-lo na string template
        const lucideIsAvailable = typeof lucide !== 'undefined' && lucide.createIcons;

        coursesData.forEach(course => {
            const courseCard = `
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6 flex flex-col justify-between transition-transform hover:-translate-y-1" data-course-id="${course.id}">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-start space-x-3">
                                <i data-lucide="book-open" class="w-5 h-5 text-blue-600 mt-1"></i>
                                <h3 class="text-lg font-bold text-slate-900">${course.title}</h3>
                            </div>
                            ${course.status === 'Finalizado' 
                                ? `<span class="text-xs font-semibold bg-green-100 text-green-800 px-2 py-1 rounded-full">Finalizado</span>`
                                : `<span class="text-xs font-semibold bg-blue-100 text-blue-800 px-2 py-1 rounded-full">${course.progress}% Em Progresso</span>`
                            }
                        </div>
                        <p class="flex items-center text-sm text-slate-500 mb-6">
                            <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                            Instrutor: ${course.instructor}
                        </p>
                        
                        <!-- Barra de Progresso (se aplicável) -->
                        ${course.status === 'Em Progresso' ? `
                        <div class="w-full bg-slate-200 rounded-full h-2 mb-6">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: ${course.progress}%"></div>
                        </div>
                        ` : ''}
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center space-x-2">
                         ${course.status === 'Finalizado' 
                            ? `
                            <button class="w-1/2 bg-slate-200 text-slate-600 font-semibold py-2 px-4 rounded-md text-sm cursor-not-allowed">Curso Finalizado</button>
                            <button data-action="reopen" class="w-1/2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md text-sm transition-colors">Reabrir Curso</button>
                            `
                            : `
                            <a href="#" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md text-sm transition-colors text-center">Continuar</a>
                            <button data-action="finish" class="w-1/2 bg-white hover:bg-slate-100 text-slate-700 font-semibold py-2 px-4 rounded-md border border-slate-300 text-sm transition-colors flex items-center justify-center space-x-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                <span>Finalizar</span>
                            </button>
                            `
                        }
                    </div>
                </div>
            `;
            coursesContainer.innerHTML += courseCard;
        });
        
        // Se lucide estiver disponível, ele cria os ícones
        if(lucideIsAvailable) {
            lucide.createIcons(); 
        }
    }

    // --- EVENT LISTENERS ---

    /**
     * Lógica para os botões de ação dos cursos (Continuar, Finalizar, Reabrir)
     */
    coursesContainer.addEventListener('click', (e) => {
        const button = e.target.closest('button[data-action]');
        
        if (!button) return;
        
        const action = button.dataset.action;
        const card = button.closest('[data-course-id]');
        const courseId = parseInt(card.dataset.courseId);
        const course = coursesData.find(c => c.id === courseId);
        
        if (!course) return;
        
        switch (action) {
            case 'finish':
                course.progress = 100;
                course.status = 'Finalizado';
                break;
            case 'reopen':
                course.progress = 0;
                course.status = 'Em Progresso';
                break;
            default:
                return; 
        }

        // Apenas para simulação front-end
        renderCourses(); 
    });

    // --- INICIALIZAÇÃO ---
    document.addEventListener('DOMContentLoaded', () => {
        renderCourses();
    });
</script>

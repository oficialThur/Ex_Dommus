$(document).ready(function() {
    
    // ==========================================
    // 1. NAVEGAÇÃO SPA
    // ==========================================
    
    // Captura cliques nos links da navbar com atributo data-target
    $('.navbar-nav .nav-link').on('click', function(e) {
        e.preventDefault();

        // Remove classe active de todos os links e adiciona no clicado
        $('.navbar-nav .nav-link').removeClass('active');
        $(this).addClass('active');

        // Identifica a seção alvo
        const targetId = $(this).data('target');

        // [SPA COMPONENT] Controle de Visibilidade das Seções
        const $visibleSection = $('.spa-section').not('.d-none');
        const $targetSection = $('#' + targetId);

        if ($visibleSection.attr('id') !== targetId) {
            $visibleSection.fadeOut(300, function() {
                $(this).addClass('d-none').removeAttr('style');
                $targetSection.hide().removeClass('d-none').fadeIn(300);
            });
        }

        // Fecha o menu mobile se estiver aberto (UX)
        $('.navbar-collapse').collapse('hide');

        // Se a seção for "destinos", carrega os dados se ainda não foram carregados
        if (targetId === 'destinos') {
            checkAndLoadPlanets();
        }
    });

    // ==========================================
    // 2. CONSUMO DE API (DESTINOS)
    // ==========================================
    
    let planetsLoaded = false;

    function checkAndLoadPlanets() {
        if (planetsLoaded) return; // Evita recarregar se já buscou

        $.ajax({
            url: 'https://swapi.info/api/planets/',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                // [SPA COMPONENT] Feedback de Carregamento
                $('#loading-alert').removeClass('d-none');
            },
            success: function(data) {
                renderPlanets(data);
                planetsLoaded = true;
            },
            error: function() {
                $('#planets-container').html('<div class="alert alert-danger">Erro ao carregar planetas. Tente novamente mais tarde.</div>');
            },
            complete: function() {
                // Remove o alerta de carregamento
                $('#loading-alert').addClass('d-none');
            }
        });
    }

    function renderPlanets(planets) {
        const container = $('#planets-container');
        container.empty(); // Limpa container

        // Pega apenas os primeiros 6 planetas para exemplo (ou todos se preferir)
        const planetList = planets.slice(0, 9); 

        $.each(planetList, function(index, planet) {
            // [SPA COMPONENT] Renderização Dinâmica de Cards
            // Criação do HTML do card usando Template String
            const cardHtml = `
                <div class="col">
                    <div class="card h-100 shadow-sm card-planet">
                        <div class="card-header bg-dark text-white">
                            <h5 class="card-title mb-0">${planet.name}</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Clima:</strong> ${planet.climate}</li>
                                <li class="list-group-item"><strong>Terreno:</strong> ${planet.terrain}</li>
                                <li class="list-group-item"><strong>População:</strong> ${planet.population}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <button class="btn btn-outline-primary w-100 btn-sm">Ver Detalhes</button>
                        </div>
                    </div>
                </div>
            `;
            container.append(cardHtml);
        });
    }

    // ==========================================
    // 3. FORMULÁRIO DE CONTATO
    // ==========================================

    $('#contact-form').on('submit', function(e) {
        e.preventDefault(); // Impede o reload da página

        // Simulação de validação e envio
        const nome = $('#nome').val();
        const email = $('#email').val();

        if(nome && email) {
            // [SPA COMPONENT] Feedback de Formulário
            const successMsg = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                Obrigado, <strong>${nome}</strong>! Sua mensagem foi enviada para o espaço. 🚀
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
            
            $('#form-feedback').html(successMsg);
            $('#contact-form')[0].reset(); // Limpa o formulário
        }
    });
});
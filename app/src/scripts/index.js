const $main = $('main');

$main.html(`
    <div class="alert alert-info" role="alert">
        Carregando naves...
    </div>
`);

$.ajax({
    url: 'https://swapi.info/api/starships',
    method: 'GET',
    success: function (data) {
        $main.empty();

        $main.addClass('d-flex flex-wrap gap-3 p-3');

        const classesUnicas = new Set();

        $.each(data, function (index, nave) {
            classesUnicas.add(nave.starship_class);
            const cardHtml = `
                <div class="card" style="width: 18rem;"
                    data-name="${nave.name}"
                    data-class="${nave.starship_class}"
                    data-manufacturer="${nave.manufacturer}"
                    data-cost="${nave.cost_in_credits}"
                    data-cargo="${nave.cargo_capacity}">
                    <div class="card-body">
                        
                        <h5 class="card-title">${nave.name}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">${nave.starship_class}</h6>
                        <p class="card-text">
                            <strong>Fabricante:</strong> ${nave.manufacturer}<br>
                            <strong>Custo:</strong> ${nave.cost_in_credits}<br>
                            <strong>Carga:</strong> ${nave.cargo_capacity}
                        </p>
                    </div>
                </div>
            `;
            $main.append(cardHtml);
        });

        const $select = $('#filter-class');

        Array.from(classesUnicas).sort().forEach(classe => {
            $select.append(`<option value="${classe}">${classe}</option>`);
        });
    },
    error: function (error) {
        $main.html('<div class="alert alert-danger">Erro ao carregar naves.</div>');
        console.error('Erro ao buscar dados da API:', error);
    }
});


$('#apply-filters').on('click', function () {

    const nameFilter = $('#filter-name').val().toLowerCase();
    const manufacturerFilter = $('#filter-manufacturer').val().toLowerCase();
    const classFilter = $('#filter-class').val();
    const costMin = parseFloat($('#filter-cost-min').val());
    const costMax = parseFloat($('#filter-cost-max').val());
    const cargoMin = parseFloat($('#filter-cargo-min').val());
    const cargoMax = parseFloat($('#filter-cargo-max').val());

    $('.card').each(function () {
        const $card = $(this);
        const name = String($card.data('name')).toLowerCase();
        const manufacturer = String($card.data('manufacturer')).toLowerCase();
        const starshipClass = $card.data('class');
        const cost = parseFloat($card.data('cost'));
        const cargo = parseFloat($card.data('cargo'));

        let show = true;

        if (nameFilter && !name.includes(nameFilter)) show = false;
        if (manufacturerFilter && !manufacturer.includes(manufacturerFilter)) show = false;
        if (classFilter && starshipClass !== classFilter) show = false;

        if (!isNaN(costMin) && (isNaN(cost) || cost < costMin)) show = false;
        if (!isNaN(costMax) && (isNaN(cost) || cost > costMax)) show = false;
        if (!isNaN(cargoMin) && (isNaN(cargo) || cargo < cargoMin)) show = false;
        if (!isNaN(cargoMax) && (isNaN(cargo) || cargo > cargoMax)) show = false;

        $card.toggle(show);
    });

    $('#FilterModal').modal('hide');
});

$('#clear-filters').on('click', function () {
    
    $('#FilterModal input').val('');
    $('#FilterModal select').val('');

    $('#apply-filters').trigger('click');
});
const input_reajuste = document.getElementById('reajuste');
const button_calcular = document.getElementById('btnCalcular');
const tabela_do_imovel = document.querySelectorAll('tr')



button_calcular.addEventListener('click', () => {
    const valor_reajuste = input_reajuste.value;
    if (valor_reajuste <= 0) {
        alert("O reajuste deve ser positivo!");
        return;
    }

    const mapa_imoveis = new Map();

    const linhas = Array.from(tabela_do_imovel).slice(1);

    linhas.forEach((linha) => {
        const colunas = linha.children;

        const id = colunas[0].innerText;
        const descricao = colunas[1].innerText;
        const precoAtual = Number(colunas[2].innerText);
        const disponibilidade = colunas[3].innerText;

        const novoPreco = precoAtual + (precoAtual * (Number(valor_reajuste) / 100));

        colunas[2].innerText = novoPreco.toFixed(2);
        mapa_imoveis.set(id, { descricao, preco: novoPreco, disponibilidade });
    });

    console.log(Object.fromEntries(mapa_imoveis));
})
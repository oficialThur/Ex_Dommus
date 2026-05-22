const button = document.getElementById("btnCarregarPlanetas");
const inputMinPopulacao = document.getElementById("minPopulacao");
const tabela = document.getElementById("tabelaPlanetas");

function buscarPlanetas() {
    return fetch("https://swapi.info/api/planets")
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro ao carregar os planetas: ${response.status}`);
            }
            return response.json();
        });
}

const criarLinhaPlaneta = async (planeta) => {
    const tr = document.createElement("tr");

    const tdName = document.createElement("td");
    tdName.textContent = planeta.name;

    const tdTerrain = document.createElement("td");
    tdTerrain.textContent = planeta.terrain;

    const tdPopulation = document.createElement("td");
    tdPopulation.textContent = planeta.population;

    tr.appendChild(tdName);
    tr.appendChild(tdTerrain);
    tr.appendChild(tdPopulation);

    return tr;
};

button.addEventListener("click", async () => {
    const minPopulacao = inputMinPopulacao.value;


    if (!minPopulacao || Number(minPopulacao) < 0) return;

    console.time("Tempo de Execução");

    try {
        const planetas = await buscarPlanetas();
        const mapPlanetas = new Map();


        let tbody = tabela.querySelector("tbody");
        if (!tbody) {
            tbody = document.createElement("tbody");
            tabela.appendChild(tbody);
        } else {
            tbody.innerHTML = "";
        }

        for (const planeta of planetas) {

            if (planeta.population === "unknown") continue;
            if (Number(planeta.population) < Number(minPopulacao)) continue;

            const tr = await criarLinhaPlaneta(planeta);

            tbody.appendChild(tr);

            mapPlanetas.set(planeta.name, {
                terrain: planeta.terrain,
                population: planeta.population
            });
        }

        console.log(JSON.stringify(Object.fromEntries(mapPlanetas)));
        console.timeEnd("Tempo de Execução");
    }

    catch (error) {
        console.error("Erro:", error.message);
    }
});

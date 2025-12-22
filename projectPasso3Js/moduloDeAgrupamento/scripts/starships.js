import { groupBy } from "./groupBy.js";

const URL = 'https://swapi.info/api/starships'

async function callApi() {
    try {
        const resp = await fetch(URL)

        const starships = await resp.json()

        const starshipsResults = groupBy(starships, 'starship_class');

        const call = new BroadcastChannel('sw_channel');
        call.postMessage(starshipsResults);

        console.log("Dados enviados para o listener!");

    } catch (error) {
        console.error("Erro ao buscar ou processar dados:", error);
    }
}

callApi()
import Imovel from "./imovel.js";

const api101 = new Imovel(101, 2500);
api101.alugar();
console.log(JSON.stringify(api101, null, 2));
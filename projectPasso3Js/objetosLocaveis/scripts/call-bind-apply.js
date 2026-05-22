import locavel from "./locavel.js";

const imovelA = { id: 1, valor_aluguel: 1800, alugado: false };
const imovelB = { id: 2, valor_aluguel: 2200, alugado: false };
const imovelC = { id: 3, valor_aluguel: 1500, alugado: false };

locavel.alugar.call(imovelA);

locavel.alugar.apply(imovelB);

const alugarImovelC = locavel.alugar.bind(imovelC);
alugarImovelC();

console.log("A:", JSON.stringify(imovelA, null, 2));
console.log("B:", JSON.stringify(imovelB, null, 2));
console.log("C:", JSON.stringify(imovelC, null, 2));
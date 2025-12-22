import locavel from "./locavel.js";

function Imovel(id, valor_aluguel) {
    this.id = id;
    this.valor_aluguel = valor_aluguel;
    this.disponibilidade = "DISPONIVEL";
}

Object.setPrototypeOf(Imovel.prototype, locavel);

Imovel.prototype.alugar = function () {
    this.disponibilidade = "ALUGADO";
}

export default Imovel;
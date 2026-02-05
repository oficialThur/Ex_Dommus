const locavel = { 
    id: 0,
    valor_aluguel: 0,
    alugado: false,
    alugar: function() {
        this.alugado = true;
    }
}

export default locavel;

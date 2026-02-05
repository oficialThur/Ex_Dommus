import api from "./api";

class ImovelService {
  // Aceita params para filtros (preco_min, preco_max, disponibilidade) e paginação (page)
  async getAll(params) {
    const response = await api.get('/imoveis', { params });
    return response.data;
  }

  async get(id) {
    const response = await api.get(`/imoveis/${id}`);
    return response.data;
  }

  async create(data) {
    const response = await api.post("/imoveis", data);
    return response.data;
  }

  async update(id, data) {
    const response = await api.put(`/imoveis/${id}`, data);
    return response.data;
  }

  async delete(id) {
    const response = await api.delete(`/imoveis/${id}`);
    return response.data;
  }

  // Endpoint específico do seu Controller para reajuste
  async reajustar(data) {
    const response = await api.post("/imoveis/reajuste", data);
    return response.data;
  }

  // Endpoint para download do CSV
  async exportar() {
    const response = await api.get("/imoveis/exportar", {
      responseType: 'blob' 
    });
    return response.data;
  }
}

export default new ImovelService();
import React, { createContext, useState, useCallback, useEffect } from 'react';
import ImovelService from '../services/ImovelService';

export const ImovelContext = createContext();

export const ImovelProvider = ({ children }) => {
  // Estados principais
  const [imoveis, setImoveis] = useState([]);
  const [loading, setLoading] = useState(false);
  
  // Estado de paginação e totais
  const [paginacao, setPaginacao] = useState({
    current_page: 1,
    last_page: 1,
    total: 0,
    per_page: 15
  });

  const [totais, setTotais] = useState({
    valorTotal: 0,
    quantidade: 0
  });

  // Estado de filtros
  const [filtros, setFiltros] = useState({
    preco_min: '',
    preco_max: '',
    disponibilidade: '', // '' | 'DISPONIVEL' | 'VENDIDO'
    page: 1
  });

  // Função principal de busca (Memoizada com useCallback para não ser recriada a cada render)
  const carregarImoveis = useCallback(async () => {
    setLoading(true);
    try {
      // Remove chaves vazias do objeto de filtros para não enviar "preco_min=" sem valor na URL
      const params = Object.fromEntries(
        Object.entries(filtros).filter(([_, v]) => v != null && v !== '')
      );

      const data = await ImovelService.getAll(params);

      // O Laravel retorna { data: [...], meta: {...} } ou { data: [...], ...paginacao } dependendo do Resource
      // Assumindo estrutura padrão de ResourceCollection ou paginate:
      const listaImoveis = data.data || [];
      const meta = data.meta || data; // Fallback caso a paginação venha na raiz

      setImoveis(listaImoveis);
      
      setPaginacao({
        current_page: meta.current_page,
        last_page: meta.last_page,
        total: meta.total,
        per_page: meta.per_page
      });

      // Calculando totais da página atual (Requisito UI)
      const somaPrecos = listaImoveis.reduce((acc, imovel) => acc + Number(imovel.preco), 0);
      setTotais({
        valorTotal: somaPrecos,
        quantidade: meta.total // Total geral de registros no banco (filtrados)
      });

    } catch (error) {
      console.error("Erro ao carregar imóveis:", error);
      // Aqui você poderia disparar um Toast de erro
    } finally {
      setLoading(false);
    }
  }, [filtros]); // Recria a função apenas se os filtros mudarem

  // Efeito para carregar sempre que a função carregarImoveis mudar (ou seja, quando filtros mudarem)
  useEffect(() => {
    carregarImoveis();
  }, [carregarImoveis]);

  // Funções auxiliares para os componentes usarem
  const atualizarFiltros = (novosFiltros) => {
    // Ao filtrar, voltamos para a página 1
    setFiltros(prev => ({ ...prev, ...novosFiltros, page: 1 }));
  };

  const mudarPagina = (novaPagina) => {
    setFiltros(prev => ({ ...prev, page: novaPagina }));
  };

  const limparFiltros = () => {
    setFiltros({
      preco_min: '',
      preco_max: '',
      disponibilidade: '',
      page: 1
    });
  };

  return (
    <ImovelContext.Provider value={{
      imoveis,
      loading,
      paginacao,
      totais,
      filtros,
      atualizarFiltros,
      mudarPagina,
      limparFiltros,
      carregarImoveis // Exposta para forçar recarregamento após cadastro/edição
    }}>
      {children}
    </ImovelContext.Provider>
  );
};

import React, { useContext, useRef } from 'react';
import { ImovelContext } from '../contexts/ImovelContext';
import Loading from '../components/load';
import ModalFormularioImovel from '../components/ModalFormularioImovel';
import ReajusteDePrecoEmMassa from '../components/ReajusteDePrecoEmMassa';
import ExportacaoDeImoveis from '../components/ExportacaoDeImoveis';
import ModalFiltro from '../components/ModalFiltro';
import { Container, Row, Col, Card, Badge, Button, Pagination, Stack } from 'react-bootstrap';

const Imovel = () => {
  const { imoveis, loading, totais, paginacao, mudarPagina } = useContext(ImovelContext);
  const modalRef = useRef();
  const filtroRef = useRef();

  const formatarMoeda = (valor) => {
    return new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL'
    }).format(valor);
  };

  if (loading) {
    return <Loading mensagem="Carregando imóveis..." />;
  }

  return (
    <Container className="mt-4">
      <div className="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2>Imóveis</h2>
        <div className="text-end">
          <Badge bg="primary" className="me-2 p-2">
            Total: {totais.quantidade}
          </Badge>
          <Badge bg="success" className="p-2">
            Valor Total (Página): {formatarMoeda(totais.valorTotal)}
          </Badge>
        </div>
      </div>

      <Stack direction="horizontal" gap={2} className="mb-4 flex-wrap">
        <Button variant="outline-secondary" onClick={() => filtroRef.current.open()}>
          <i className="bi bi-funnel"></i> Filtros
        </Button>
        <Button variant="primary" onClick={() => modalRef.current.open()}>
          <i className="bi bi-plus-lg"></i> Novo Imóvel
        </Button>
        <ReajusteDePrecoEmMassa />
        <ExportacaoDeImoveis />
      </Stack>

      <Row>
        {imoveis.length > 0 ? (
          imoveis.map((imovel) => (
            <Col md={4} className="mb-4" key={imovel.id}>
              <Card className={`h-100 shadow-sm ${imovel.disponibilidade === 'VENDIDO' ? 'border-danger' : 'border-success'}`}>
                <Card.Body>
                  <div className="d-flex justify-content-between align-items-start">
                    <Card.Title className="text-truncate" title={imovel.descricao}>{imovel.descricao}</Card.Title>
                    <Badge bg={imovel.disponibilidade === 'VENDIDO' ? 'danger' : 'success'}>
                      {imovel.disponibilidade}
                    </Badge>
                  </div>
                  <Card.Subtitle as="h4" className="my-3 text-dark">
                    {formatarMoeda(imovel.preco)}
                  </Card.Subtitle>
                </Card.Body>
                <Card.Footer className="bg-transparent border-top-0 pb-3">
                   <Button variant="outline-primary" className="w-100" onClick={() => modalRef.current.open(imovel)}>
                     Editar
                   </Button>
                </Card.Footer>
              </Card>
            </Col>
          ))
        ) : (
          <Col xs={12} className="text-center py-5">
            <p className="text-muted fs-5">Nenhum imóvel encontrado com os filtros atuais.</p>
          </Col>
        )}
      </Row>

      {paginacao.total > 0 && (
        <div className="d-flex justify-content-center mt-4">
          <Pagination>
            <Pagination.Prev onClick={() => mudarPagina(paginacao.current_page - 1)} disabled={paginacao.current_page === 1}>Anterior</Pagination.Prev>
            <Pagination.Item disabled>{paginacao.current_page} de {paginacao.last_page}</Pagination.Item>
            <Pagination.Next onClick={() => mudarPagina(paginacao.current_page + 1)} disabled={paginacao.current_page === paginacao.last_page}>Próxima</Pagination.Next>
          </Pagination>
        </div>
      )}

      <ModalFormularioImovel ref={modalRef} />
      <ModalFiltro ref={filtroRef} />
    </Container>
  );
};

export default Imovel;
import { Spinner, Container } from 'react-bootstrap';

const Loading = ({ mensagem = "Carregando..." }) => {
  return (
    <Container className="d-flex flex-column justify-content-center align-items-center" style={{ minHeight: '200px' }}>
      <Spinner animation="border" role="status" variant="primary">
        <span className="visually-hidden">Carregando...</span>
      </Spinner>
      <p className="mt-2 text-muted">{mensagem}</p>
    </Container>
  );
};

export default Loading;
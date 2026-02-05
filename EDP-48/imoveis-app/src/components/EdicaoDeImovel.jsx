import { useState } from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import { PencilSimpleIcon } from "@phosphor-icons/react";
import 'bootstrap/dist/css/bootstrap.min.css';
import Form from 'react-bootstrap/Form';
import Spinner from 'react-bootstrap/Spinner';

const EdicaoDeImovel = () => {
  const [show, setShow] = useState(false);
  const [loading, setLoading] = useState(false);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  const handleSalvar = () => {
    setLoading(true);
    // Simulação de delay da API
    setTimeout(() => {
      setLoading(false);
      handleClose();
    }, 2000);
  };

  return (
    <>
      <Button className='d-flex justify-content-center align-items-center gap-1' id='ButtonEditar' variant="primary" onClick={handleShow}>
        Editar
        <PencilSimpleIcon size={15} color="white" />
      </Button>

      <Modal
        show={show}
        onHide={handleClose}
        backdrop="static"
        keyboard={window.innerWidth < 768}
      >
        <Modal.Header closeButton>
          <Modal.Title>Editar imóvel</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <Form>
            <h5>Imóvel a ser editado:</h5>
            <Form.Group className="mb-3" controlId="exampleForm.ControlTextarea1">
              <Form.Label>Preço do imóvel:</Form.Label>
              <div className="d-flex align-items-center gap-3">
                <Form.Control type="number" placeholder="Ex:1000000" />
              </div>
            </Form.Group>
            <Form.Group className="mb-3" controlId="exampleForm.ControlTextarea1">
              <Form.Label>Descrição do imóvel:</Form.Label>
              <Form.Control as="textarea" rows={3} />
            </Form.Group>
            <Form.Group className="mb-3" controlId="exampleForm.ControlTextarea1">
              <Form.Label>Disponibilidade:</Form.Label>
              <div className="d-flex align-items-center gap-3">
                <Form.Check type="checkbox" label="Disponível" />
                <Form.Check type="checkbox" label="Indisponível" />
              </div>
            </Form.Group>

          </Form>
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose} disabled={loading}>
            Cancelar
          </Button>
          <Button variant="primary" onClick={handleSalvar} disabled={loading}>
            {loading ? (
              <><Spinner as="span" animation="border" size="sm" role="status" aria-hidden="true" /> Salvando...</>
            ) : (
              'Editar'
            )}
          </Button>
        </Modal.Footer>
      </Modal>
    </>
  )
}

export default EdicaoDeImovel

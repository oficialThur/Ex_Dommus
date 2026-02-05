import { useState} from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import 'bootstrap/dist/css/bootstrap.min.css';
import { BuildingApartmentIcon } from "@phosphor-icons/react";
import Form from 'react-bootstrap/Form';
import Spinner from 'react-bootstrap/Spinner';

const CadastroDeImovel = () => {

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
      <Button className="d-flex justify-content-center align-items-center gap-1" variant="primary" onClick={handleShow} style={{ width: '110px' }}>
        Cadastra

        <BuildingApartmentIcon size={15} />
      </Button>

      <Modal
        show={show}
        onHide={handleClose}
        backdrop="static"
        keyboard={window.innerWidth < 768}
      >
        <Modal.Header closeButton>
          <Modal.Title>Cadastrar um novo imóvel</Modal.Title>

        </Modal.Header>
        <Modal.Body>
          <Form>
            <Form.Group className="mb-3" controlId="exampleForm.ControlInput1">
              <Form.Label>Nome do imóvel:</Form.Label>
              <div className="d-flex flex-nowrap justify-content-center align-items-center gap-2">
                <Form.Control type="name" placeholder="Nome do imóvel" />
              </div>
            </Form.Group>
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
              'Cadastrar'
            )}
          </Button>
        </Modal.Footer>
      </Modal>
    </>
  )
}

export default CadastroDeImovel

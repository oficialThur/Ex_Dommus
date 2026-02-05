import { useState, useContext } from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import 'bootstrap/dist/css/bootstrap.min.css';
import Spinner from 'react-bootstrap/Spinner';
import Form from 'react-bootstrap/Form';
import { useForm } from 'react-hook-form';
import { ImovelContext } from '../contexts/ImovelContext';
import ImovelService from '../services/ImovelService';

const ReajusteDePrecoEmMassa = () => {
    const [show, setShow] = useState(false);
    const { filtros, carregarImoveis } = useContext(ImovelContext);
    
    const { register, handleSubmit, reset, formState: { errors, isSubmitting } } = useForm();

    const handleClose = () => {
        setShow(false);
        reset();
    };
    const handleShow = () => setShow(true);

    const onSubmit = async (data) => {
        try {

            const payload = {
                percentual: data.percentual,
                ...filtros
            };

            await ImovelService.reajustar(payload);
            

            await carregarImoveis();
            
            alert('Reajuste aplicado com sucesso!');
            handleClose();
        } catch (error) {
            console.error(error);
            alert('Erro ao aplicar reajuste: ' + (error.response?.data?.message || error.message));
        }
    };

    return (
        <>
            <Button variant="warning" onClick={handleShow}>
                Reajuste em Massa
            </Button>

            <Modal show={show} onHide={handleClose} backdrop="static">
                <Form onSubmit={handleSubmit(onSubmit)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Reajuste de Preço em Massa</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <p className="text-muted small">
                            Atenção: O reajuste será aplicado a todos os imóveis listados atualmente (respeitando os filtros ativos).
                        </p>
                        <Form.Group className="mb-3">
                            <Form.Label>Percentual (%)</Form.Label>
                            <Form.Control 
                                type="number" 
                                step="0.01"
                                placeholder="Ex: 10 para aumentar, -5 para diminuir"
                                {...register('percentual', { required: 'Informe o percentual' })}
                                isInvalid={!!errors.percentual}
                            />
                            <Form.Control.Feedback type="invalid">{errors.percentual?.message}</Form.Control.Feedback>
                        </Form.Group>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="secondary" onClick={handleClose} disabled={isSubmitting}>
                            Cancelar
                        </Button>
                        <Button variant="primary" type="submit" disabled={isSubmitting}>
                            {isSubmitting ? (
                                <><Spinner as="span" animation="border" size="sm" role="status" aria-hidden="true" /> Processando...</>
                        ) : (
                            'Aplicar Reajuste'
                        )}
                    </Button>
                </Modal.Footer>
                </Form>
            </Modal>
        </>
    )
}

export default ReajusteDePrecoEmMassa
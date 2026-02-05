import { useState, useContext, forwardRef, useImperativeHandle } from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import Form from 'react-bootstrap/Form';
import { Row, Col } from 'react-bootstrap';
import { useForm } from 'react-hook-form';
import { ImovelContext } from '../contexts/ImovelContext';

const ModalFiltro = forwardRef((props, ref) => {
    const [show, setShow] = useState(false);
    const { filtros, atualizarFiltros, limparFiltros } = useContext(ImovelContext);
    const { register, handleSubmit, reset, setValue, watch, formState: { errors } } = useForm();

    useImperativeHandle(ref, () => ({
        open: () => {

            setValue('preco_min', filtros.preco_min);
            setValue('preco_max', filtros.preco_max);
            setValue('disponibilidade', filtros.disponibilidade);
            setShow(true);
        },
        close: () => setShow(false)
    }));

    const handleClose = () => setShow(false);

    const onSubmit = (data) => {
        atualizarFiltros(data);
        handleClose();
    };

    const handleLimpar = () => {
        limparFiltros();
        reset();
        handleClose();
    };

    const precoMin = watch('preco_min');

    return (
        <Modal show={show} onHide={handleClose}>
            <Form onSubmit={handleSubmit(onSubmit)}>
                <Modal.Header closeButton>
                    <Modal.Title>Filtrar Imóveis</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <Form.Group className="mb-3">
                        <Form.Label>Faixa de Preço (R$)</Form.Label>
                        <Row>
                            <Col>
                                <Form.Control type="number" placeholder="Mínimo" {...register('preco_min')} />
                            </Col>
                            <Col>
                            <Form.Control 
                                type="number" 
                                placeholder="Máximo" 
                                {...register('preco_max', {
                                    validate: (value) => {
                                        if (!value || !precoMin) return true;
                                        return Number(value) >= Number(precoMin) || "O máximo deve ser maior que o mínimo";
                                    }
                                })}
                                isInvalid={!!errors.preco_max}
                            />
                            </Col>
                        </Row>
                        {errors.preco_max && <div className="text-danger small mt-1">{errors.preco_max.message}</div>}
                    </Form.Group>
                    <Form.Group className="mb-3">
                        <Form.Label>Disponibilidade</Form.Label>
                        <Form.Select {...register('disponibilidade')}>
                            <option value="">Todos</option>
                            <option value="DISPONIVEL">Disponível</option>
                            <option value="VENDIDO">Vendido</option>
                        </Form.Select>
                    </Form.Group>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="outline-secondary" onClick={handleLimpar}>Limpar Filtros</Button>
                    <Button variant="primary" type="submit">Aplicar Filtros</Button>
                </Modal.Footer>
            </Form>
        </Modal>
    );
});

export default ModalFiltro

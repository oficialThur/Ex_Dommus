import React, { useState, forwardRef, useImperativeHandle, useContext } from 'react';
import { Modal, Button, Form } from 'react-bootstrap';
import { useForm } from 'react-hook-form';
import { ImovelContext } from '../contexts/ImovelContext';
import ImovelService from '../services/ImovelService';

const ModalFormularioImovel = forwardRef((props, ref) => {
    const [show, setShow] = useState(false);
    const [isEditing, setIsEditing] = useState(false);
    const [currentId, setCurrentId] = useState(null);
    
    const { carregarImoveis } = useContext(ImovelContext);
    
    const { 
        register, 
        handleSubmit, 
        reset, 
        setValue, 
        watch, 
        formState: { errors } 
    } = useForm();

    // Observa a disponibilidade para aplicar a regra de negócio do preço
    const disponibilidadeAtual = watch('disponibilidade');
    const precoAtual = watch('preco');

    // Expõe funções para o componente pai (Imovel.jsx)
    useImperativeHandle(ref, () => ({
        open: (imovel = null) => {
            setShow(true);
            if (imovel) {
                setIsEditing(true);
                setCurrentId(imovel.id);
                setValue('descricao', imovel.descricao);
                // Formata o preço float para string (ex: 1000.00 -> 1.000,00)
                setValue('preco', formatarMoedaInput(imovel.preco)); 
                setValue('disponibilidade', imovel.disponibilidade);
            } else {
                setIsEditing(false);
                setCurrentId(null);
                reset({
                    descricao: '',
                    preco: '',
                    disponibilidade: 'DISPONIVEL'
                });
            }
        },
        close: () => setShow(false)
    }));

    const formatarMoedaInput = (valor) => {
        if (!valor) return '';
        return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(valor);
    };

    const handleClose = () => setShow(false);

    const onSubmit = async (data) => {
        try {
            // Remove formatação visual (pontos e vírgulas) para enviar float válido
            const precoFloat = data.preco 
                ? parseFloat(data.preco.toString().replace(/\./g, '').replace(',', '.')) 
                : 0;

            const payload = { ...data, preco: precoFloat };

            if (isEditing) {
                await ImovelService.update(currentId, payload);
            } else {
                await ImovelService.create(payload);
            }

            carregarImoveis(); // Atualiza a lista no Contexto imediatamente
            handleClose();
        } catch (error) {
            console.error(error);
            alert('Erro ao salvar: ' + (error.response?.data?.message || error.message));
        }
    };

    // Máscara simples de moeda enquanto o usuário digita
    const handlePrecoChange = (e) => {
        let value = e.target.value;
        value = value.replace(/\D/g, ""); // Remove tudo que não é dígito
        value = (Number(value) / 100).toFixed(2) + ""; // Divide por 100 para centavos
        value = value.replace(".", ","); // Troca ponto por vírgula
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Adiciona pontos de milhar
        setValue('preco', value, { shouldValidate: true });
    };

    // Extrai o onChange original do register para não sobrescrevê-lo incorretamente
    const { onChange: _ignoreOnChange, ...precoRegister } = register('preco', { required: 'Preço é obrigatório' });

    return (
        <Modal show={show} onHide={handleClose}>
            <Form onSubmit={handleSubmit(onSubmit)}>
                <Modal.Header closeButton>
                    <Modal.Title>{isEditing ? 'Editar Imóvel' : 'Novo Imóvel'}</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <Form.Group className="mb-3">
                        <Form.Label>Descrição</Form.Label>
                        <Form.Control 
                            type="text" 
                            {...register('descricao', { required: 'Descrição é obrigatória', maxLength: 255 })}
                            isInvalid={!!errors.descricao}
                        />
                        <Form.Control.Feedback type="invalid">{errors.descricao?.message}</Form.Control.Feedback>
                    </Form.Group>

                    <Form.Group className="mb-3">
                        <Form.Label>Preço (R$)</Form.Label>
                        <Form.Control 
                            type="text"
                            {...precoRegister}
                            value={precoAtual || ''}
                            onChange={handlePrecoChange}
                            // Regra: Preço só editável se disponível. Se estiver VENDIDO, bloqueia.
                            disabled={disponibilidadeAtual === 'VENDIDO'}
                            isInvalid={!!errors.preco}
                        />
                        {disponibilidadeAtual === 'VENDIDO' && (
                            <Form.Text className="text-muted">Não é possível alterar o preço de imóveis vendidos.</Form.Text>
                        )}
                    </Form.Group>

                    <Form.Group className="mb-3">
                        <Form.Label>Disponibilidade</Form.Label>
                        <Form.Select {...register('disponibilidade', { required: true })}>
                            <option value="DISPONIVEL">DISPONIVEL</option>
                            <option value="VENDIDO">VENDIDO</option>
                        </Form.Select>
                    </Form.Group>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" onClick={handleClose}>Cancelar</Button>
                    <Button variant="primary" type="submit">Salvar</Button>
                </Modal.Footer>
            </Form>
        </Modal>
    );
});

export default ModalFormularioImovel;
import { useState } from "react"
import Button from "react-bootstrap/Button"
import { FileArrowDownIcon } from "@phosphor-icons/react"
import Spinner from "react-bootstrap/Spinner"
import ImovelService from "../services/ImovelService"

const ExportacaoDeImoveis = () => {
  const [loading, setLoading] = useState(false)

  const handleExport = async () => {
    setLoading(true)
    try {
      const data = await ImovelService.exportar();

      const url = window.URL.createObjectURL(new Blob([data], { type: 'text/csv' }));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'imoveis.csv');
      document.body.appendChild(link);
      link.click();
      link.parentNode.removeChild(link);
    } catch (error) {
      console.error(error);
      alert('Erro ao exportar arquivo.');
    } finally {
      setLoading(false)
    }
  }

  return (
    <Button variant="info" className="d-flex justify-content-center align-items-center gap-1 text-white" onClick={handleExport} disabled={loading}>
      {loading ? (
        <Spinner as="span" animation="border" size="sm" role="status" aria-hidden="true" />
      ) : (
        <>Exportar CSV <FileArrowDownIcon size={15} /></>
      )}
    </Button>
  )   
}

export default ExportacaoDeImoveis

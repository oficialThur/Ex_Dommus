import Container from 'react-bootstrap/esm/Container'
import { useState, useEffect } from "react"
import Card from 'react-bootstrap/Card'
import Loading from '../components/load'
import 'bootstrap/dist/css/bootstrap.min.css'


const Home = () => {

   const [loading, setLoading] = useState(true)

    useEffect(() => {
      const timer = setTimeout(() => {
        setLoading(false)
      }, 1000)
      return () => clearTimeout(timer)
    }, [])
  
    if (loading) {
      return <Loading mensagem="Carregando Home..." />
    }

  return (
    <Container fluid className="p-4" height="100%" >
      <Card className="mt-4">
        <Card.Body>
        <h4>Seja bem-vindo ao sistema de gerenciamento de imóveis.</h4>
        <p> Mussum Ipsum, cacilds vidis litro abertis.  Vehicula non. Ut sed ex eros. Vivamus sit amet nibh non tellus tristique interdum. In elementis mé pra quem é amistosis quis leo. Cevadis im ampola pa arma uma pindureta. Copo furadis é disculpa de bebadis, arcu quam euismod magna.</p>
        </Card.Body>
      </Card>
    </Container>
  )
}

export default Home

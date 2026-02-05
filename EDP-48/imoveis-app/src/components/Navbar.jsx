import Navbar from 'react-bootstrap/Navbar';
import Container from 'react-bootstrap/Container';
import { Link } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import DropdownImovel from '../components/DropdownImovel';

const navbar = () => {
    return (
        <nav>
            <Navbar className="d-flex justify-content-around align-items-center p-2 border-bottom" >
                <h2 className='m-0'>Imoveis</h2>
                <Container className='d-flex justify-content-end align-items-center m-0 p-0'>
                    <Navbar.Brand as={Link} to="/">Home</Navbar.Brand>
                    <DropdownImovel />
                </Container>
            </Navbar>
        </nav>
    )
}

export default navbar

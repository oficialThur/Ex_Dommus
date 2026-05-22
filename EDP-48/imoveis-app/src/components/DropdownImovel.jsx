import Dropdown from 'react-bootstrap/Dropdown';
import { Link } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';

const navbar = () => {
    return (
        <Dropdown>
            <Dropdown.Toggle  variant="success" id="dropdown-basic">
                Imovel
            </Dropdown.Toggle>

            <Dropdown.Menu>
                <Dropdown.Item Link as={Link} to="/imovel">listagem</Dropdown.Item>
            </Dropdown.Menu>
        </Dropdown>
    )
}

export default navbar

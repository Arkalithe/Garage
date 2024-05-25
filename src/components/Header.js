import React from 'react';
import { Link } from 'react-router-dom';
import { Navbar, Nav, Container, Button } from 'react-bootstrap';
import Logo from '../assests/Image/Logo.png';
import useAuth from '../hooks/useAuth';

const Header = () => {
    const { auth, logout } = useAuth();

    const handleLogout = () => {
        logout();
    };

    return (
        <Navbar bg="light" expand="lg" className="border-bottom">
            <Container>
                <Navbar.Brand>                    
                        <Link to="/" className="lien">
                            <img src={Logo} alt="Company logo" className="Logo" />
                        </Link>                    
                </Navbar.Brand>

                <Navbar.Toggle aria-controls="navmenu" />

                <Navbar.Collapse id="navmenu">
                    <Nav className="ms-auto">
                        <Nav.Link as={Link} to="/" className="bouton nav-link">Accueil</Nav.Link>
                        <Nav.Link as={Link} to="/contactPage" className="bouton nav-link">Contact</Nav.Link>
                        <Nav.Link as={Link} to="/newavis" className="bouton nav-link">Avis</Nav.Link>
                        <Nav.Link as={Link} to="/voiture" className="bouton nav-link">Voiture</Nav.Link>

                        {auth.accessToken && (
                            <>
                                {auth.role === 'admin' && (
                                    <Nav.Link as={Link} to="/adminSpace" className="bouton nav-link">Espace Admin</Nav.Link>
                                )}
                                {auth.role === 'employee' && (
                                    <Nav.Link as={Link} to="/employeSpace" className="bouton nav-link">Espace Employe</Nav.Link>
                                )}
                                <Button className="bouton nav-link" onClick={handleLogout}>Déconnexion</Button>
                            </>
                        )}
                        {!auth.accessToken && (
                            <Nav.Link as={Link} to="/login" className="bouton nav-link">Connexion</Nav.Link>
                        )}
                    </Nav>
                </Navbar.Collapse>
            </Container>
        </Navbar>
    );
};

export default Header;

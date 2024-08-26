import React, { useState, useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { Navbar, Nav, Container, Button } from 'react-bootstrap';
import Logo from '../assests/Image/Logo.png';
import useAuth from '../hooks/useAuth';

const Header = () => {
    const { auth, logout } = useAuth();
    const [expanded, setExpanded] = useState(false);
    const navbarRef = useRef(null);

    const handleLogout = () => {
        logout();
        setExpanded(false);
    };

    const handleToggle = () => {
        setExpanded(!expanded);
    };

    const handleOutsideClick = (event) => {
        if (navbarRef.current && !navbarRef.current.contains(event.target)) {
            setExpanded(false);
        }
    };

    useEffect(() => {
        if (expanded) {
            document.addEventListener('click', handleOutsideClick);
        } else {
            document.removeEventListener('click', handleOutsideClick);
        }

        return () => {
            document.removeEventListener('click', handleOutsideClick);
        };
    }, [expanded]);

    return (
        <header className='header d-flex border-bottom'>
            <Container className='cont-test'>
            <Navbar expand="lg" expanded={expanded} ref={navbarRef}>
                <Container className='container-nav '>
                    <Navbar.Brand>
                        <Link to="/" className="lien">
                            <img src={Logo} alt="Company logo" className="Logo" />
                        </Link>
                    </Navbar.Brand>

                    <Navbar.Toggle aria-controls="navmenu" onClick={handleToggle} />

                    <Navbar.Collapse id="navmenu" className={expanded ? 'show' : ''}>
                        <Nav className="ms-auto">
                            <Nav.Link as={Link} to="/" className="bouton nav-link" onClick={() => setExpanded(false)}>Accueil</Nav.Link>
                            <Nav.Link as={Link} to="/contactPage" className="bouton nav-link" onClick={() => setExpanded(false)}>Contact</Nav.Link>
                            <Nav.Link as={Link} to="/newavis" className="bouton nav-link" onClick={() => setExpanded(false)}>Avis</Nav.Link>
                            <Nav.Link as={Link} to="/voiture" className="bouton nav-link" onClick={() => setExpanded(false)}> Voiture</Nav.Link>

                            {auth.token && (
                                <>
                                    {auth.role === 'admin' && (
                                        <Nav.Link as={Link} to="/adminSpace" className="bouton nav-link" onClick={() => setExpanded(false)}>Espace Admin</Nav.Link>
                                    )}
                                    {auth.role === 'employee' && (
                                        <Nav.Link as={Link} to="/employeSpace" className="bouton nav-link" onClick={() => setExpanded(false)}>Espace Employe</Nav.Link>
                                    )}
                                    <Button className="bouton nav-link" onClick={handleLogout}>Déconnexion</Button>
                                </>
                            )}
                            {!auth.token && (
                                <Nav.Link as={Link} to="/login" className="bouton nav-link" onClick={() => setExpanded(false)}>Connexion</Nav.Link>
                            )}
                        </Nav>
                    </Navbar.Collapse>
                </Container>
            </Navbar>
            </Container>    
        </header>
    );
};

export default Header;

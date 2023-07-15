import React from 'react';
import { Link } from 'react-router-dom';
import Logo from '../assests/Image/Logo.png';
import useAuth from '../hooks/useAuth';

const Header = () => {
    const { auth, logout } = useAuth();

    const handleLogout = () => {
        logout();
    };

    return (
        <nav className="border-bottom navbar navbar-expand-lg">
            <div className="container-fluid">
                <div className="navbar-brand">
                    <h1 className="align-items-center text-decoration-none lien">
                        <Link to="/" className="lien">
                            <img src={Logo} alt="Logo" className="Logo" />
                        </Link>
                    </h1>
                </div>

                <button
                    className="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navmenu"
                >
                    <span className="navbar-toggler-icon"></span>
                </button>

                <nav className="collapse navbar-collapse " id="navmenu">
                    <ul className="navbar-nav ms-auto">
                        <li className="nav-item">
                            <Link to="/" className="bouton nav-link">
                                Accueil
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link to="/contact" className="bouton nav-link">
                                Contact
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link to="/newavis" className="bouton nav-link">
                                Avis
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link to="/voiture" className="bouton nav-link">
                                Voiture
                            </Link>
                        </li>

                        {auth.accessToken && auth.role === 'Admin' && (
                            <li className="nav-item">
                                <Link to="/adminSpace" className="bouton nav-link">
                                   Espace Admin
                                </Link>
                            </li>
                        )}

                        {auth.accessToken && auth.role === 'Employe' && (
                            <li className="nav-item">
                                <Link to="/employeSpace" className="bouton nav-link">
                                    Espace Employe
                                </Link>
                            </li>
                        )}

                        {!auth.accessToken && (
                            <li className="nav-item">
                                <Link to="/login" className="bouton nav-link">
                                    Connexion
                                </Link>
                            </li>
                        )}
                        {auth.accessToken && (
                            <li className="nav-item">
                                <button className="bouton nav-link" onClick={handleLogout}>
                                    Deconnexion
                                </button>
                            </li>
                        )}
                    </ul>
                </nav>
            </div>
        </nav>
    );
};

export default Header;

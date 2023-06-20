import React from 'react';
import { Link } from "react-router-dom";

const Header = () => {
    return (
        <nav className="border-bottom navbar navbar-expand-lg">
            <div className="container-fluid">
                <div className="navbar-brand">
                    <h1  className="align-items-center text-decoration-none lien">
                        <Link to="/" className='lien'>Garage V.Parrot</Link>                        
                    </h1>
                </div>

                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <nav className="collapse navbar-collapse " id="navmenu">
                    <ul className=" navbar-nav ms-auto" >                        
                        <li className="nav-item">
                        <Link to="/" className="bouton nav-link"> Acceuil  </Link>
                        </li>
                        <li className="nav-item">
                        <Link to="/Contact" className="bouton nav-link"> Contact  </Link>
                        </li>
                        <li className="nav-item">
                        <Link to="/Voiture" className="bouton nav-link"> Voiture  </Link>
                        </li>
                        <li className="nav-item">
                        <Link to="/adminSpace" className="bouton nav-link"> Admin  </Link>
                        </li>
                        <li className="nav-item">
                        <Link to="/login" className="bouton nav-link"> Login  </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
    )

}

export default Header
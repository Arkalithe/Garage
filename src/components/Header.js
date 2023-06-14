import { Component } from "react";
import { Navbar } from "./Navbar";

class Header extends Component {
    render() {
        return (
            <nav className="border-bottom navbar navbar-expand-lg">
                <div className="container-fluid">

                    <div className="navbar-brand">
                        <h1 className="align-items-center text-decoration-none ">
                            <i className="">
                            </i>
                            Garage V.Parrot
                        </h1>
                    </div>

                    <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className="collapse navbar-collapse " id="navmenu">
                        <ul className=" navbar-nav ms-auto" >
                            {Navbar.map((item, index) => {
                                return (
                                    <li key={index} className="nav-item">
                                        <a href={item.url} className="bouton nav-link"> {item.title} </a>
                                    </li>
                                )
                            })}
                        </ul>


                    </div>
                </div>
            </nav>
        )
    }
}

export default Header
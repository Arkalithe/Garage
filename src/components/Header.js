import { Component } from "react";
import { Navbar } from "./Navbar";

class Header extends Component {
    render() {
        return (
            <nav className="NavbarItems d-flex px-3 py-2 border-bottom">
                <div className="container">
                    <div className="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                        <h1 className="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none">
                            <i className="">
                            </i>
                            Garage
                        </h1>

                        <ul className="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                            {Navbar.map((item, index) => {
                                return (
                                    <li key={index}>
                                        <a href={item.url} className={item.cName}> {item.title} </a>
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
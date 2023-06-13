import { Component } from "react";
import {Navbar} from "./Navbar";

class Header extends Component {
    render() {
        return(
        <nav className="NavbarItems">
            <h1><i className=""></i> Garage</h1>

            <ul>
                {Navbar.map((item, index) => {
                    return(
                        <li key={index}>
                            <a href={item.url} className={item.cName}> {item.title} </a>
                        </li>
                    )
                })}
            </ul>
        </nav>
        )
    }
}

export default Header
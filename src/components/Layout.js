import { Component } from "react";
import Footer from './Footer';
import Header from "./Header";
import Section from './Section';

class Layout extends Component {
    render() {
        return (
            
            <div className="layout">
                <Header />
                <Section />
                <Footer />
            </div>
          

        )
    }
}

export default Layout
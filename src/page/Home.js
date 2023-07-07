
import { useNavigate, Link } from "react-router-dom";
import { useContext } from "react";
import AuthContext from "../context/AuthProvider";


const Home = () => {
    const { setAuth } = useContext(AuthContext);
    const navigate = useNavigate();

    const logout = async () => {
        // if used in more components, this should be in context 
        // axios to /logout endpoint 
        setAuth({});

        navigate('/login');
    }



    const log =  async (e) => {        
        console.log(setAuth.role)
    }
    return (
        <section>
            <h1>Acceuil</h1>
            <br />
            <li className="nav-item">
                <Link to="/signup" className="bouton nav-link"> signup  </Link>
            </li>

            <div className="flexGrown">
                <button onClick={log}>gdfuhgdfg</button>
            </div>

            <div className="flexGrow">
                <button onClick={logout}>Sign Out</button>
            </div>
            <li className="nav-item">
                <Link to="adminSpace" className="bouton nav-link"> Admin  </Link>
            </li>
        </section>
    )
}

export default Home;
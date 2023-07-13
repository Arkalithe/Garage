
import { useNavigate, Link } from "react-router-dom";
import { useContext } from "react";
import AuthContext from "../context/AuthProvider";
import Voiture from '../assests/Image/Voiture.png'


const Home = () => {
    const { setAuth } = useContext(AuthContext);
    const navigate = useNavigate();

    const logout = async () => {
        setAuth({});
        navigate('/login');
    }
    const log = async (e) => {
        console.log(setAuth.role)
    }


    return (
        <div className="container">
            <section className="d-flex flex-row ">
                <article className="form-cadre m-2 p-2">
                    <div className="pb-2">
                        <h1>
                            Depannage
                        </h1>
                    </div>

                    <div className="pb-3">
                        <img className="container" src={Voiture} alt='test' ></img>
                    </div>
                    <div>
                        <p>
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum
                        </p>
                    </div>
                </article>
                <article className="form-cadre m-2 p-2">
                    <div className="pb-2">
                        <h1>
                            Reparation
                        </h1>
                    </div>
                    <div className="pb-3">
                        <img className="container" src={Voiture} alt='test' ></img>
                    </div>
                    <div className="pb-3">
                        <p>
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum
                        </p>
                    </div>
                </article>
                <article className="form-cadre m-2 p-2">
                    <div className="pb-2">
                        <h1>
                            Voiture d'occasion
                        </h1>
                        <div className="pb-3">
                            <img className="container" src={Voiture} alt='test' ></img>
                        </div>
                    </div>
                    <div className="pb-3">
                        <p>
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                            Lorem ipsum Lorem ipsum Lorem ipsum
                        </p>
                    </div>
                </article>
            </section>
            <hr className="section-divider"></hr>
        </div>
    )
}

export default Home;
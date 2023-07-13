
import Voiture from '../assests/Image/Voiture.png'
import GetAvis from "../components/Avis/GetAvis";


const Home = () => {

    return (
        <div className="container">
            <section>
                <div>
                    <h1>
                        Nos Services
                    </h1>
                </div>
                <div className="d-flex flex-row ">
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
                </div>

            </section>
            <div className="border my-3"></div >
            <section>
                <div>
                    <h1>
                        Témoignage
                    </h1>
                </div>
                <div className="container"> <GetAvis></GetAvis>  </div>

            </section>
        </div>
    )
}

export default Home;
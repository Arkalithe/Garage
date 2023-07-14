import Voiture from '../assests/Image/Voiture.png';
import GetAvis from '../components/Avis/GetAvis';


const Home = () => {
  return (
    <div className="container">
      <section>
        <div>
          <h1>Nos Services</h1>
        </div>
        <div className="row justify-content-center align-items-center">
          <article className="col-md-4 form-cadre m-2 p-2">
            <div className="pb-2">
              <h1>Dépannage</h1>
            </div>
            <div className="pb-3">
              <img className="img-fluid" src={Voiture} alt="Dépannage" />
            </div>
            <div>
              <p>
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
              </p>
            </div>
            <button className="bouton bouton-lien">Plus d'information</button>
          </article>
          <article className="col-md-4 form-cadre m-2 p-2">
            <div className="pb-2">
              <h1>Réparation</h1>
            </div>
            <div className="pb-3">
              <img className="img-fluid" src={Voiture} alt="Réparation" />
            </div>
            <div className="pb-3">
              <p>
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
              </p>
            </div>
            <button className="bouton bouton-lien">Plus d'information</button>
          </article>
          <article className="col-md-4 form-cadre m-2 p-2">
            <div className="pb-2">
              <h1>Voiture d'occasion</h1>
            </div>
            <div className="pb-3">
              <img className="img-fluid" src={Voiture} alt="Voiture" />
            </div>
            <div className="pb-3">
              <p>
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
              </p>
            </div>
            <button className="bouton bouton-lien">Plus d'information</button>
          </article>
        </div>
      </section>
      <div className="border my-3"></div>
      <section>
        <div>
          <h1>Témoignage</h1>
        </div>
        <div className="container">
          <GetAvis />
        </div>
      </section>
    </div>
  );
};

export default Home;

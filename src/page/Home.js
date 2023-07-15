import Voiture from '../assests/Image/Voiture.png';
import GetAvis from '../components/Avis/GetAvis';


const Home = () => {
  return (
    <div className="container">
      <section>
        <div >
          <h1 >Nos Services</h1>
        </div>
        <div className="row row-cols-1 row-cols-md-3">
          <div className="col mb-4 ">
            <div className="card form-cadre h-100">
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
            </div>
          </div>
          <div className="col mb-4">
            <div className="card form-cadre h-100">
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
            </div>
          </div>
          <div className="col mb-4">
            <div className="card form-cadre h-100">
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
            </div>
          </div>
        </div>    
      </section >
      <div className="border my-3"></div>
      <section>
        <div>
          <h1>Témoignage</h1>
        </div>
        <div className="container">
          <GetAvis />
        </div>
      </section>
    </div >
  );
};

export default Home;

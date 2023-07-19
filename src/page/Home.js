import { Link } from 'react-router-dom';
import GetAvis from '../components/Avis/GetAvis';
import Depanage from '../components/Depanage/Depanage';
import Reparation from '../components/Reparation/Reparation';
import VoitureOccasion from '../components/Ocasion/VoitureOccasion';


const Home = () => {
  return (
    <div className="container">
      <section>
        <div >
          <h1 >Nos Services</h1>
        </div>

        <div className="row row-cols-1 row-cols-md-3 flex-grow-1">
          <Depanage />
          <Reparation />
          <VoitureOccasion />
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

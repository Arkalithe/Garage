import React from 'react';
import { Container, Row } from 'react-bootstrap';
import GetAvis from '../components/Avis/GetAvis';
import Depanage from '../components/Depanage/Depanage';
import Reparation from '../components/Reparation/Reparation';
import VoitureOccasion from '../components/Ocasion/VoitureOccasion';

const Home = () => {
  return (
    <Container>
      <section>
        <h1>Nos Services</h1>
        <Row className="flex-grow-1">
          <Depanage />
          <Reparation />
          <VoitureOccasion />
        </Row>
      </section>
      <div className="border my-3"></div>
      <section>
        <h1>Témoignage</h1>
        <Container>
          <GetAvis />
        </Container>
      </section>
    </Container>
  );
};

export default Home;

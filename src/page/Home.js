import React from 'react';
import { Container, Row, Col } from 'react-bootstrap';
import GetAvis from '../components/Avis/GetAvis';
import Depanage from '../components/Depanage/Depanage';
import Reparation from '../components/Reparation/Reparation';
import VoitureOccasion from '../components/Ocasion/VoitureOccasion';

const Home = () => {
  return (
    <Container >
      <h1 className="text-center my-4">Nos Services</h1>
      <section className='d-flex align-items-center justify-content-center '>
        <Row >
          <Col xs={12} md={4} className='mb-3'>
            <Depanage />
          </Col>
          <Col xs={12} md={4} className='mb-3'>
            <Reparation />
          </Col>
          <Col xs={12} md={4} className='mb-3'>
            <VoitureOccasion />
          </Col>
        </Row>
      </section>
      <div className="border my-4"></div>
      <h1 className="text-center my-4">Témoignages</h1>
      <section className='mb-3'>
        <GetAvis />
      </section>
    </Container>
  );
};

export default Home;
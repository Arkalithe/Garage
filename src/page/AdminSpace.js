import React from 'react';
import { Link } from 'react-router-dom';
import { Container, Row, Col } from 'react-bootstrap';

const AdminSpace = () => {
  return (
    <Container className='form-cadre p-2'>
      <section className='d-flex justify-content-center mt-auto'>
        <h2 className="d-flex justify-content-center mt-auto">
          Espace Administrateur
        </h2>
      </section>
      <Row className='justify-content-center'>
        <Col lg={5} md={5} sm={12} className=' cadre-admin my-2 mx-3'>
          <h3>Gestion Employé</h3>
          <Link to='/employe'><button className='mb-3 bouton bouton-lien'>Modifier</button></Link>
        </Col>

        <Col lg={5} md={5} sm={12} className='cadre-admin my-2 mx-3'>
          <h3>Gestion Horaire</h3>
          <Link to='/horaire'><button className='mb-3 bouton bouton-lien'>Modifier</button></Link>
        </Col>
      </Row>

      <Row className='justify-content-center'>
        <Col lg={5} md={5} sm={12} className='cadre-admin my-2 mx-3'>
          <h3>Moderation avis</h3>
          <Link to='/avis'><button className='mb-3 bouton bouton-lien'>Modifier</button></Link>
        </Col>

        <Col lg={5} md={5} sm={12} className='cadre-admin my-2 mx-3'>
          <h3>Creation Voiture</h3>
          <Link to='/creationVoiture'><button className='mb-3 bouton bouton-lien'>Modifier</button></Link>
        </Col>
      </Row>

      <Row className='justify-content-center'>
        <Col lg={5} md={5} sm={12} className='cadre-admin my-2 mx-3'>
          <h3>Moderation Voiture</h3>
          <Link to='/updateVoiture'><button className='mb-3 bouton bouton-lien'>Modifier</button></Link>
        </Col>

        <Col lg={5} md={5} sm={12} className='cadre-admin my-2 mx-3'>
          <h3>Moderation Contenue</h3>
          <Link to='/contentSpace'><button className='mb-3 bouton bouton-lien'>Modifier</button></Link>
        </Col>
      </Row>

    </Container>
  );
};

export default AdminSpace;

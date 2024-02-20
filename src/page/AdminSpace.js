import React from 'react';
import { Link } from 'react-router-dom';
import { Container, Row, Col, Button } from 'react-bootstrap';

const AdminSpace = () => {
  return (
    <Container className='form-cadre p-1'>
      <div className='d-flex flex-column'>
        <Row className='justify-content-center'>

          <Col lg={5} md={5} sm={12} className='d-flex flex-column align-items-center cadre-admin m-1'>
            <h3>Gestion Employé</h3>
            <Link to='/employe'><Button variant='primary'>Modifié</Button></Link>
          </Col>

          <Col lg={5} md={5} sm={12} className='d-flex flex-column align-items-center cadre-admin m-1'>
            <h3>Gestion Horaire</h3>
            <Link to='/horaire'><Button variant='primary'>Modifié</Button></Link>
          </Col>
        </Row>

        <Row className='justify-content-center'>
          <Col lg={5} md={5} sm={12} className='d-flex flex-column align-items-center cadre-admin m-1'>
            <h3>Moderation avis</h3>
            <Link to='/avis'><Button variant='primary'>Modifié</Button></Link>
          </Col>

          <Col lg={5} md={5} sm={12} className='d-flex flex-column align-items-center cadre-admin m-1'>
            <h3>Creation Voiture</h3>
            <Link to='/creationVoiture'><Button variant='primary'>Modifié</Button></Link>
          </Col>
        </Row>

        <Row className='justify-content-center'>
          <Col lg={5} md={5} sm={12} className='d-flex flex-column align-items-center cadre-admin m-1'>
            <h3>Moderation Voiture</h3>
            <Link to='/updateVoiture'><Button variant='primary'>Modifié</Button></Link>
          </Col>

          <Col lg={5} md={5} sm={12} className='d-flex flex-column align-items-center cadre-admin m-1'>
            <h3>Moderation Contenue</h3>
            <Link to='/contentSpace'><Button variant='primary'>Modifié</Button></Link>
          </Col>
        </Row>
      </div>
    </Container>
  );
};

export default AdminSpace;

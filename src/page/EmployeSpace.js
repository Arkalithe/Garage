import React from 'react';
import { Container, Row, Col, Button } from 'react-bootstrap';
import { Link } from 'react-router-dom';

const EmployeSpace = () => {
  return (
    <Container className="form-cadre p-1 mb-3">
      <div className="d-flex flex-column container">
        <Row className="justify-content-center">
          <Col lg={5} md={5} sm={12} className="m-1">
            <h3>Moderation avis</h3>
            <Link to='/avis'>
              <Button className='bouton bouton-lien'>Modifié</Button>
            </Link>
          </Col>
          <Col lg={5} md={5} sm={12} className="m-1">
            <h3>Creation Voiture</h3>
            <Link to='/creationVoiture'>
              <Button className='bouton bouton-lien'>Modifié</Button>
            </Link>
          </Col>
        </Row>
        <Row className="justify-content-center">
          <Col lg={5} md={5} sm={12} className="m-1">
            <h3>Moderation Voiture</h3>
            <Link to='/updateVoiture'>
              <Button className='bouton bouton-lien'>Modifié</Button>
            </Link>
          </Col>
        </Row>
      </div>
    </Container>
  );
};

export default EmployeSpace;

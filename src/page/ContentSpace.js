import React from 'react';
import { Container, Row, Col, Button } from 'react-bootstrap';
import { Link } from 'react-router-dom';

const ContentSpace = () => {
  return (
    <Container className="form-cadre p-1">

        <Row className="justify-content-center">
          <Col lg={5} md={5} sm={12} className="m-1">
            <h3>Gestion Depannage</h3>
            <Link to='/editDepanage'>
              <Button className='bouton bouton-lien'>Modifié</Button>
            </Link>
          </Col>
          <Col lg={5} md={5} sm={12} className="m-1">
            <h3>Gestion Repartion</h3>
            <Link to='/editReparation'>
              <Button className='bouton bouton-lien'>Modifié</Button>
            </Link>
          </Col>
        </Row>
        <Row className="justify-content-center">
          <Col lg={5} md={5} sm={12} className="m-1">
            <h3>Gestion Ocasion</h3>
            <Link to='/editOcasion'>
              <Button className='bouton bouton-lien'>Modifié</Button>
            </Link>
          </Col>
        </Row>

    </Container>
  );
};

export default ContentSpace;

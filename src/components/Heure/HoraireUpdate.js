import React, { useEffect, useState } from 'react';
import { Form, Container, Row, Col } from 'react-bootstrap';
import config from '../../api/axios';

const HoraireUpdate = () => {
  const update_url = '/Garage/php/Api/Horaire/HoraireUpdate.php';
  const fetch_url = '/Garage/php/Api/Horaire/HoraireRead.php';

  const [businessHours, setBusinessHours] = useState([]);

  useEffect(() => {
    fetchBusinessHours();
  }, []);

  const fetchBusinessHours = async () => {
    try {
      const response = await config.localTestingUrl.get(fetch_url);
      setBusinessHours(response.data);
    } catch (error) {
      console.error('Erreur recuperation horaires', error);
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      for (const hour of businessHours) {
        const { id, jour, matin, apresmidi } = hour;
        const data = { id, jour, matin, apresmidi };
        await config.localTestingUrl.post(update_url, JSON.stringify(data));
      }
    } catch (error) {
      console.error('Erreur mise a jour horaires', error);
    }
  };

  const handleInputChange = (e, index, key) => {
    const updatedHours = [...businessHours];
    updatedHours[index] = {
      ...updatedHours[index],
      [key]: e.target.value,
    };
    setBusinessHours(updatedHours);
  };

  return (
    <Container className="p-3 my-3 form-cadre">
      <h3>Modifiez Horaire</h3>
      <Form onSubmit={handleSubmit}>
        {businessHours.map((hour, index) => (
          <Row className="align-items-center mb-3" key={hour.id}>
            <Col xs={12} md={3}>
              <Form.Label>{hour.jour}:</Form.Label>
            </Col>
            <Col xs={12} md={4}>
              <Form.Group as={Row} className="align-items-center">
                <Form.Label column sm={4}>Matin:</Form.Label>
                <Col sm={8}>
                  <Form.Control
                    type='text'
                    value={hour.matin}
                    onChange={(e) => handleInputChange(e, index, 'matin')}
                  />
                </Col>
              </Form.Group>
            </Col>
            <Col xs={12} md={4}>
              <Form.Group as={Row} className="align-items-center">
                <Form.Label column sm={4}>Apresmidi:</Form.Label>
                <Col sm={8}>
                  <Form.Control
                    type='text'
                    value={hour.apresmidi}
                    onChange={(e) => handleInputChange(e, index, 'apresmidi')}
                  />
                </Col>
              </Form.Group>
            </Col>
          </Row>
        ))}
        <button className='bouton' type="submit">Envoyez</button>
      </Form>
    </Container>
  );
};

export default HoraireUpdate;

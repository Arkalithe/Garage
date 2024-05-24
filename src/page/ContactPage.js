import React, { useRef, useState } from 'react';
import { Container, Row, Col, Form, Button, Card } from 'react-bootstrap';
import config from '../api/axios';

const ContactPage = () => {
  const nameRef = useRef();

  const [mailSetting, setMailSetting] = useState({
    nom: '',
    prenom: '',
    email: '',
    phone: '',
    message: '',
  });

  const url_email = '/Garage/php/Api/Email.php';

  const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData();

    try {
      formData.append('nom', mailSetting.nom);
      formData.append('prenom', mailSetting.prenom);
      formData.append('email', mailSetting.email);
      formData.append('phone', mailSetting.phone);
      formData.append('message', mailSetting.message);

      await config.localTestingUrl.post(url_email, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      alert('Email envoyé avec succès !');
    } catch (error) {
      console.error('Erreur lors de l\'envoi de l\'email :', error);
      alert('Échec de l\'envoi de l\'email. Veuillez réessayer plus tard.');
    }
  };

  const handleChange = (event) => {
    const { name, value } = event.target;
    setMailSetting({ ...mailSetting, [name]: value });
  };

  return (
    <Container className="voit">
      <Row>
        <Col md={6} className="d-flex align-items-center">
          <Form className="p-2 m-2" onSubmit={handleSubmit}>
            <Form.Group controlId="nom">
              <Form.Label>Nom :</Form.Label>
              <Form.Control
                type="text"
                name="nom"
                ref={nameRef}
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.nom}
                required
              />
            </Form.Group>

            <Form.Group controlId="prenom">
              <Form.Label>Prénom :</Form.Label>
              <Form.Control
                type="text"
                name="prenom"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.prenom}
                required
              />
            </Form.Group>

            <Form.Group controlId="email">
              <Form.Label>Adresse e-mail :</Form.Label>
              <Form.Control
                type="email"
                name="email"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.email}
                required
              />
            </Form.Group>

            <Form.Group controlId="phone">
              <Form.Label>Numéro de téléphone :</Form.Label>
              <Form.Control
                type="tel"
                name="phone"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.phone}
                required
              />
            </Form.Group>

            <Form.Group controlId="message">
              <Form.Label>Message :</Form.Label>
              <Form.Control
                as="textarea"
                name="message"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.message}
                required
              />
            </Form.Group>

            <Button variant="primary" type="submit">
              Envoyer Email
            </Button>
          </Form>
        </Col>

        <Col md={6} className="d-flex align-items-center justify-content-center">
          <Card className="cadre-admin">
            <Card.Body className="text-center">
              <Card.Title>Informations de contact</Card.Title>
              <Card.Text>
                Numéro de téléphone : <strong>07-77-56-78-90</strong>
              </Card.Text>
              <Card.Text>
                Adresse : <strong>26 Rue Richard Wagner, Toulouse, France</strong>
              </Card.Text>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  );
};

export default ContactPage;

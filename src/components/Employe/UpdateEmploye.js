import React, { useEffect, useState, useCallback } from 'react';
import { Form, Button, Spinner, Alert, Col, Row, Container } from 'react-bootstrap';
import config from '../../api/axios';
import { useParams } from 'react-router';

const email_regex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
const password_regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#€%*]).{7,24}$/;


const useEmployeData = (idEmploye) => {
  const employe_url = '/Garage/php/Api/User/UserGetSingle.php';
  const employe_update = '/Garage/php/Api/User/UserUpdate.php';
  const [isLoading, setLoading] = useState(true);
  const [form, setForm] = useState(false);
  const [id, setId] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [role, setRole] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState(false);

  const fetchEmploye = useCallback(async () => {
    try {
      const response = await config.localTestingUrl.get(employe_url, { params: { id: idEmploye } });
      setId(response.data.id);
      setEmail(response.data.email);
      setPassword(response.data.password);
      setRole(response.data.role);
      setLoading(false);
    } catch (err) {
      if (err.response) setError("Erreur dans la recupération des Employes. Essayer plus tard.");
      setLoading(false);
    }
  }, [idEmploye]);

  useEffect(() => {
    fetchEmploye();
  }, [fetchEmploye]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    const v1 = email_regex.test(email);
    const v2 = password_regex.test(password);
    if (!v1 || !v2) {
      setError("Valeur incorect");
      return
    }
    try {
      await config.localTestingUrl.post(employe_update, JSON.stringify({ id, email, password, role }));
      setSuccess(true);
    } catch (err) {
      setError("Erreur dans la mise a jour des Employes. Essayer plus tard.");
    }
  }
  return {
    isLoading,
    form,
    setForm,
    email,
    setEmail,
    password,
    setPassword,
    handleSubmit,
    error,
    success
  };
};

export const UpdateEmploye = () => {
  const { idEmploye } = useParams();
  const {
    isLoading,
    form,
    setForm,
    email,
    setEmail,
    password,
    setPassword,
    handleSubmit,
    error,
    success
  } = useEmployeData(idEmploye);

  const handleClick = () => {
    setForm((prevState) => !prevState);
  };

  if (isLoading) {
    return (
      <div className="d-flex justify-content-center align-items-center" style={{ height: '100vh' }}>
        <Spinner animation="border" role="status">
          <span className="sr-only">Chargement...</span>
        </Spinner>
      </div>
    );
  }

  return (
    <Container>
      {error && <Alert variant="danger">{error}</Alert>}
      {success && <Alert variant="success">Employee data updated successfully!</Alert>}
      <Row className="justify-content-center">
        <Col>
          <div className="form-cadre d-flex flex-column align-items-center">
            {form ? (
              <Button onClick={handleClick}>Précedent</Button>
            ) : (
              <Form className="w-100" onSubmit={handleSubmit}>
                <Form.Group controlId="email" className='m-2'>
                  <Form.Label>Email:</Form.Label>
                  <Form.Control
                    type="text"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                    isInvalid={email && !email_regex.test(email)}
                  />
                  <Form.Control.Feedback type="invalid">
                    Email incorrect. Veuillez respecter ce format : exemple@exemple.exe
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group controlId="password" className='m-2'>
                  <Form.Label>New Password</Form.Label>
                  <Form.Control
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                    isInvalid={password && !password_regex.test(password)}
                  />
                  <Form.Control.Feedback type="invalid">
                    7 à 24 caractères requis. Doit inclure une minuscule, une majuscule, un chiffre et un caractère spécial.
                  </Form.Control.Feedback>
                </Form.Group>

                <button 
                type="submit" 
                disabled={!email || !password || !email_regex.test(email) || !password_regex.test(password)}
                className='bouton'
                >Envoyez</button>
              </Form>
            )}
          </div>
        </Col>
      </Row>
    </Container>
  );
};

export default UpdateEmploye;

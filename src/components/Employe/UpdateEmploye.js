import React, { useEffect, useState, useCallback } from 'react';
import { Form, Button } from 'react-bootstrap';
import config from '../../api/axios';
import { useParams } from 'react-router';

export const UpdateEmploye = () => {
  const employe_url = '/Garage/php/Api/User/UserGetSingle.php';
  const employe_update = '/Garage/php/Api/User/UserUpdate.php';
  const [isLoading, setLoading] = useState(true);
  const [form, setForm] = useState(false);
  const [id, setId] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [role, setRole] = useState("");
  const { idEmploye } = useParams();

  const fetchEmploye = useCallback(async () => {
    try {
      const response = await config.localTestingUrl.get(employe_url, { params: { id: idEmploye } });
      setId(response.data.id);
      setEmail(response.data.email);
      setPassword(response.data.password);
      setRole(response.data.role);
      setLoading(false);
    } catch (err) {
      if (err.response) {
      } else if (err.request) {
      } else {

      }
    }
  }, [employe_url, idEmploye]);

  useEffect(() => {
    fetchEmploye();
  }, [fetchEmploye]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await config.localTestingUrl.post(employe_update, JSON.stringify({ id, email, password, role }));
    } catch (err) {

    }
  };

  const handleClick = () => {
    setForm((prevState) => !prevState);
  };

  if (isLoading) {
    return <div>Chargement</div>;
  }

  return (
    <section>
      {form ? (
        <div className="form-cadre d-flex flex-column align-items-center">
          <Button onClick={handleClick}>Précedent</Button>
        </div>
      ) : (
        <Form className="container form-cadre d-flex flex-column align-items-center" onSubmit={handleSubmit}>
          <Form.Group controlId="email">
            <Form.Label>Email:</Form.Label>
            <Form.Control type="text" value={email} onChange={(e) => setEmail(e.target.value)} />
          </Form.Group>

          <Form.Group controlId="password">
            <Form.Label>New Password</Form.Label>
            <Form.Control type="password" onChange={(e) => setPassword(e.target.value)} />
          </Form.Group>

          <Button type="submit">Envoyez</Button>
        </Form>
      )}

    </section>
  );
};

export default UpdateEmploye;

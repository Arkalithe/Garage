import React, { useEffect, useState, useCallback } from 'react';
import axios from '../../api/axios';
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
      const response = await axios.get(employe_url, { params: { id: idEmploye } });
      console.log(response.data);
      setId(response.data.id);
      setEmail(response.data.email);
      setPassword(response.data.password);
      setRole(response.data.role);
      setLoading(false);
    } catch (err) {
      if (err.response) {
        console.log(err.response.data);
        console.log(err.response.status);
      } else if (err.request) {
        console.log(err.request);
      } else {
        console.log('Problème', err.message);
      }
    }
  }, [employe_url, idEmploye]);

  useEffect(() => {
    fetchEmploye();
  }, [fetchEmploye]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post(employe_update, JSON.stringify({ id, email, password, role }));
      console.log(response?.data);
      console.log(email, password, role, id);
    } catch (err) {
      console.log(err);
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
          <button onClick={handleClick}>Précedent</button>
        </div>
      ) : (
        <form className="container form-cadre d-flex flex-column align-items-center" onSubmit={handleSubmit}>
          <label>Email:</label>
          <input type="text" id="email" value={email} onChange={(e) => setEmail(e.target.value)} />

          <label>Password</label>
          <input type="password" id="password" onChange={(e) => setPassword(e.target.value)} />
          <button type="submit">Envoyez</button>
        </form>
      )}

      <button onClick={handleClick}>Contact</button>
    </section>
  );
};

export default UpdateEmploye;

import React, { useEffect, useState } from 'react';
import { Form, Button } from 'react-bootstrap';
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
      console.error('Error:', error);
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
      console.error('Error:', error);
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
    <div className='container-fluid p-1 my-3 form-cadre'>
      <h3>Modifé Horaire</h3>
      <Form onSubmit={handleSubmit}>
        {businessHours.map((hour, index) => (
          <div className="container-fluid mb-3" key={hour.id}>
            <div className="row align-items-center">
              <div className="col-3">
                <div className="d-flex align-items-center">
                  <Form.Label className="mb-0">{hour.jour}:</Form.Label>
                </div>
              </div>
              <div className="col">
                <div className="row align-items-center">
                  <div className="col-4">
                    <p className="pl-1">Matin:</p>
                  </div>
                  <div className="col">
                    <Form.Control
                      type='text'
                      value={hour.matin}
                      onChange={(e) => handleInputChange(e, index, 'matin')}
                    />
                  </div>
                </div>
                <div className="row align-items-center">
                  <div className="col-4">
                    <p>Apresmidi:</p>
                  </div>
                  <div className="col">
                    <Form.Control
                      type='text'
                      value={hour.apresmidi}
                      onChange={(e) => handleInputChange(e, index, 'apresmidi')}
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        ))}
        <Button className='bouton' type="submit">Envoyez</Button>
      </Form>
    </div>
  );
};

export default HoraireUpdate;

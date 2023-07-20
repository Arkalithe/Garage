import React, { useEffect, useState } from 'react';
import config from '../../api/axios';

const HoraireUpdate = () => {
  const update_url = '/Garage/php/Api/Horaire/HoraireUpdate.php';
  const fetch_url = '/Garage/php/Api/Horaire/HoraireRead.php';

  const [businessHours, setBusinessHours] = useState([]);

  useEffect(() => {
    fetchBusinessHours();
  }, []);

  const fetchBusinessHours = async (e) => {
    try {
      const response = await config.herokuTesting.get(fetch_url);
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
        await config.herokuTesting.post(update_url, JSON.stringify(data));
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
      <form onSubmit={handleSubmit}>
        {businessHours.map((hour, index) => (
          <div className="container-fluid mb-3" key={hour.id}>
            <div className="row align-items-center">
              <div className="col-3">
                <div className="d-flex align-items-center">
                  <label className="mb-0">{hour.jour}:</label>
                </div>
              </div>
              <div className="col">
                <div className="row align-items-center">
                  <div className="col-4">
                    <p className="pl-1">Matin:</p>
                  </div>
                  <div className="col">
                    <input
                      type='text'
                      className="form-control"
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
                    <input
                      type='text'
                      className="form-control"
                      value={hour.apresmidi}
                      onChange={(e) => handleInputChange(e, index, 'apresmidi')}
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        ))}
        <button className='bouton'>Envoyez</button>
      </form>
    </div>
  );
};

export default HoraireUpdate;

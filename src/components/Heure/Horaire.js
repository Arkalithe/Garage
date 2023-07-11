import React, { useEffect, useState } from 'react';
import useHoraire from '../../hooks/useHoraire';

const Horaire = () => {
  const { businessHours, updateBusinessHours } = useHoraire();
  const [updatedHours, setUpdatedHours] = useState(businessHours);

  useEffect(() => {
    if (businessHours) {
      setUpdatedHours(businessHours);
    }
  }, [businessHours]);

  const handleSubmit = (e) => {
    e.preventDefault();
    updateBusinessHours(updatedHours);
  };

  const handleInputChange = (e) => {
    setUpdatedHours({
      ...updatedHours,
      [e.target.name]: e.target.value
    });
  };

  return (
    <div>
      <h2>Horaire :</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label htmlFor="lundiVendredi" className="form-label">Lundi - Vendredi :</label>
          <input
            type="text"
            id="lundiVendredi"
            name="lundiVendredi"
            value={updatedHours.lundiVendredi || ''}
            onChange={handleInputChange}
            className="form-control"
          />
        </div>
        <div className="mb-3">
          <label htmlFor="Samedi" className="form-label">Samedi :</label>
          <input
            type="text"
            id="Samedi"
            name="Samedi"
            value={updatedHours.Samedi || ''}
            onChange={handleInputChange}
            className="form-control"
          />
        </div>
        <div className="mb-3">
          <label htmlFor="Dimanche" className="form-label">Dimanche :</label>
          <input
            type="text"
            id="Dimanche"
            name="Dimanche"
            value={updatedHours.Dimanche || ''}
            onChange={handleInputChange}
            className="form-control"
          />
        </div>
        <button type="submit" className="bouton">Modifié horaire</button>
      </form>
    </div>
  );
};

export default Horaire;
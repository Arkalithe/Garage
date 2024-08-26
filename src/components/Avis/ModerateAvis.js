import React, { useState, useEffect } from "react";
import config from "../../api/axios";
import { Link } from "react-router-dom";
import { Rating } from "@mui/material";

const ModerateAvis = () => {
  const register_url = "/api/aviss";
  const [avis, setAvis] = useState([]);
  const [isLoading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchAvis();
  }, []);

  const fetchAvis = async () => {
    try {
      const response = await config.localTestingUrl.get(register_url);
      const avisData = response.data['hydra:member'];
      setAvis(avisData);
      setLoading(false);
    } catch (error) {
      setError(error.message);
      setLoading(false);
    }
  };

  if (isLoading) {
    return <div>Chargement...</div>;
  }

  if (error) {
    return (
      <div>
        Erreur : {error}
        <button onClick={fetchAvis}>Réessayer</button>
      </div>
    );
  }

  if (!Array.isArray(avis) || avis.length === 0) {
    return <div>Pas d'avis a modéré trouvé</div>;
  }

  const avist = avis
    .filter((aviss) => aviss.moderate === 0)
    .map((aviss) => (
      <div className="card-container my-3" key={aviss.id}>
        <div className=" voit card h-100">
          <div className="card-body d-flex flex-column">
            <h5 className="card-title">{aviss.name}</h5>
            <p className="card-text flex-grow-1">{aviss.message}</p>
            <div className="my-3 d-flex justify-content-center">
              <Rating type="number" id="note" name="read-only" size="large" value={aviss.note} readOnly />
            </div>
            <Link className="bouton bouton-lien mt-auto" to={`/avis/${aviss.id}`}>
              Plus d'information
            </Link>
          </div>
        </div>
      </div>
    ));

  return <div className="container"><div className="row d-flex justify-content-between">{avist}</div></div>
};

export default ModerateAvis;
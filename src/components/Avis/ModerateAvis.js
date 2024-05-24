import React, { useState, useEffect } from "react";
import config from "../../api/axios";
import { Link } from "react-router-dom";
import { Rating } from "@mui/material";

const ModerateAvis = () => {
  const register_url = "/Garage/php/Api/Avis/AvisRead.php";
  const [avis, setAvis] = useState([]);
  const [isLoading, setLoading] = useState(true);

  useEffect(() => {
    fetchAvis();
  }, []);

  const fetchAvis = async () => {
    try {
      const response = await config.localTestingUrl.get(register_url);
      setAvis(response.data);
      setLoading(false);
    } catch (error) {
      
    }
  };

  if (isLoading) {
    return <div>Chargement...</div>;
  }

  if (!Array.isArray(avis)) {
    return <div> Pas d'avis trouvé </div>
  }

  const avist = avis.map((aviss) => {
    if (avis.moderate === 0) {
      return (
        <div className="voit d-flex flex-column container col-5 align-items-center my-3" key={aviss.id}>
          <div className="container pt-2  m-auto">{aviss.name}</div>
          <div className="container m-auto">
            <div className="my-3 avis-message">{aviss.message}</div>
          </div>
          <div className="container m-auto">
            <Rating type="number" id="note" name="read-only" size="large" value={aviss.note} readOnly />
          </div>
          <Link className="align-self-center bouton lien" to={`/avis/${aviss.id}`}>
            Plus d'information
          </Link>
        </div>
      );
    } else {
      return null;
    }
  });

  return <section className="d-flex flex-wrap justify-content-between">{avist}</section>;
};

export default ModerateAvis;
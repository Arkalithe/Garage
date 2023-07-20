import React from "react";
import config from "../../api/axios";
import { useState } from "react";
import { useEffect } from "react";
import { Link } from "react-router-dom";

const Reparation = () => {
  const [reparationContent, setReparationContent] = useState([]);

  const reparation_url = "/Api/Reparation/ReparationRead.php"

  useEffect(() => {
    getData()
  }, [])

  const getData = async () => {
    try {
      const response = await config.config.herokuTesting.get(reparation_url);
      setReparationContent(response.data);

    } catch (error) {

    }
  };

  const firstReparation = reparationContent.length > 0 ? reparationContent[0] : null;

  return (
    <div className="col mb-4">
      {firstReparation && (
        <div className="card form-cadre h-100">
          <div className="pb-2 card-title">
            <h1>{firstReparation.title}</h1>
          </div>
          <div className="pb-3 m-2">
            {firstReparation.image.length > 0 ? (
              <div
                className="image-container"
                style={{
                  maxWidth: "300px",
                  maxHeight: "300px",
                  overflow: "hidden",
                }}
              >
                <img
                  className="img-fluid"
                  src={require(`../../assests/Image/${firstReparation.image}`)}
                  alt="Reparation"
                  style={{
                    width: "100%",
                    height: "100%",
                    objectFit: "cover",
                  }}
                />
              </div>
            ) : (
              <div>No Image</div>
            )}
          </div>
          <div className="pb-3">
            <p>{firstReparation.intro}</p>
          </div>
          <Link to={"/reparation"} className="d-flex justify-content-center mt-auto bouton bouton-lien">
            Plus d'information
          </Link>
        </div>
      )}
    </div>
  );
};

export default Reparation;
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
      const response = await config.herokuTesting.get(reparation_url);
      setReparationContent(response.data);

    } catch (error) {

    }
  };



  const contents = reparationContent.map((Content) => (

    <div className="card form-cadre h-100" key={Content.id}>
      <div className="pb-2 card-title">
        <h1>{Content.title}</h1>
      </div>
      <div className="pb-3 m-2 image-container d-flex justify-content-center align-items-center">
        {Content.image.length > 0 ? (
          <div            
            style={{
              maxWidth: "300px",
              maxHeight: "300px",
              overflow: "hidden",
            }}
          >
            <img
              className="img-fluid"
              src={require(`../../assests/Image/${Content.image}`)}
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
      <div className="pb-3 ">
        <p>{Content.intro}</p>
      </div>

      <Link to={"/reparation"} className="d-flex justify-content-center mt-auto bouton bouton-lien">
        Plus d'information
      </Link>

    </div>
  ))


  return (
    <div className="col mb-4">{contents}</div>
  );
};

export default Reparation;
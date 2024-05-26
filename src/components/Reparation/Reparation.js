import React, { useState, useEffect } from "react";
import config from "../../api/axios";
import { Card } from "react-bootstrap";
import { Link } from "react-router-dom";

const Reparation = () => {
  const [reparationContent, setReparationContent] = useState([]);

  const reparation_url = "/Garage/php/Api/Reparation/ReparationRead.php";

  useEffect(() => {
    getData();
  }, []);

  const getData = async () => {
    try {
      const response = await config.localTestingUrl.get(reparation_url);
      if (Array.isArray(response.data)) {
        setReparationContent(response.data);
      } else {
        setReparationContent([]);
      }
    } catch (error) {
      console.error("Error fetching data: ", error);
    }
  };

  const contents = reparationContent.length > 0 ? 
  ( reparationContent.map((content) => (
    <Card className="card form-cadre h-100 d-flex flex-column" key={content.id}>
      <Card.Body className="d-flex flex-column ">
        <Card.Title style={{ fontSize: "40px", textAlign: "center" }}>{content.title}</Card.Title>
        <div className="pb-3 m-2 flex-grow-1">
          {content.image.length > 0 ? (
            <Card.Img
              variant="top"
              src={require(`../../assests/Image/${content.image}`)}
              alt="Reparation"
              style={{
                width: "100%",
                height: "100%",
                maxWidth: "300px",
                maxHeight: "300px",
                overflow: "hidden",
                objectFit: "contain",
              }}
            />

          ) : (
            <div>No Image</div>
          )}
        </div>

        <Card.Text>{content.intro}</Card.Text>
        <div className="d-flex justify-content-center mt-auto">
          <Link to={"/reparation"} className=" mt-auto">
            <button className="bouton bouton-lien" >Plus d'informations</button>
          </Link>
        </div>
      </Card.Body>
    </Card>
  ))
 ) : (
    <div className="text-center">
      <h3>Aucune Reparation disponible</h3>
    </div>
  )

  return <>{contents}</>;
};

export default Reparation;

import React, { useState, useEffect } from "react";
import config from "../../api/axios";
import { Card, Button } from "react-bootstrap";
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
      setReparationContent(response.data);
    } catch (error) {
      console.error("Error fetching data: ", error);
    }
  };

  const contents = reparationContent.map((content) => (
    <Card className="card form-cadre h-100" key={content.id}>
      <Card.Body>
        <Card.Title style={{ fontSize: "40px", textAlign: "center" }}>{content.title}</Card.Title>
        {content.image.length > 0 ? (

            <Card.Img
              variant="top"
              src={require(`../../assests/Image/${content.image}`)}
              alt="Reparation"
              style={{
                width: "100%",
                height: "100%",
                maxWidth: "200px",
                maxHeight: "200px",
                overflow: "hidden",
                objectFit: "contain",
              }}
            />

        ) : (
          <div>No Image</div>
        )}
        <Card.Text>{content.intro}</Card.Text>
        <Link to={"/reparation"} className="d-flex justify-content-center mt-auto">
          <Button className="bouton bouton-lien" >Plus d'informations</Button>
        </Link>
      </Card.Body>
    </Card>
  ));

  return <div className="col mb-4">{contents}</div>;
};

export default Reparation;

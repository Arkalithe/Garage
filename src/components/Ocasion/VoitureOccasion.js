import React, { useState, useEffect } from 'react';
import { Card } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import config from '../../api/axios';

export const VoitureOccasion = () => {

  const [voitureContent, setVoitureContent] = useState([]);
  const voiture_url = "/Garage/php/Api/Ocasion/OcasionRead.php";

  useEffect(() => {
    getData();
  }, []);

  const getData = async () => {
    try {
      const response = await config.localTestingUrl.get(voiture_url);
      if (Array.isArray(response.data)) {
        setVoitureContent(response.data);
      } else {
        setVoitureContent([]);
      }      
    } catch (error) {}
  };

  const contents = voitureContent.length > 0 ? (
    voitureContent.map((Content) => (
      <Card className="card form-cadre h-100 d-flex flex-column" key={Content.id}>
        <Card.Body className='d-flex flex-column'>
          <Card.Title style={{ fontSize: "40px", textAlign: "center" }}>{Content.title}</Card.Title>
          <div className="pb-3 m-2 flex-grow-1">
            {Content.image.length > 0 ? (
              <Card.Img
                className="img-fluid"
                src={require(`../../assests/Image/${Content.image}`)}
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
          <Card.Text>{Content.intro}</Card.Text>
          <div className="d-flex justify-content-center mt-auto">
            <Link to={"/voiture"} className="mt-auto">
              <button className="bouton bouton-lien align-items-center">Plus d'information</button>
            </Link>
          </div>
        </Card.Body>
      </Card>
    ))
  ) : (
    <div className="text-center">
      <h3>Aucune voiture disponible pour le moment</h3>
    </div>
  );

  return <>{contents}</>;
};

export default VoitureOccasion;
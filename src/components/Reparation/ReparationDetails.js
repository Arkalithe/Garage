import React, { useState, useEffect } from 'react';
import { Card} from 'react-bootstrap';
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
      setVoitureContent(response.data);
    } catch (error) {}
  };

  const contents = voitureContent.map((Content) => (
    <Card className="card form-cadre h-100" key={Content.id}>
      <Card.Body>
        <Card.Title>{Content.title}</Card.Title>
        <div className="pb-3 m-2">
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
      </Card.Body>
    </Card>
  ));

  return <div className="col mb-4">{contents}</div>;
};

export default VoitureOccasion;

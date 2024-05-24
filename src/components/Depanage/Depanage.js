import React from 'react';
import { useEffect } from 'react';
import { useState } from 'react';
import config from '../../api/axios';
import { Link } from 'react-router-dom';
import { Button, Card } from 'react-bootstrap';


const Depanage = () => {

  const [depanageContent, setDepanageContent] = useState([]);
  const depannage_url = "/Garage/php/Api/Depanage/DepanageRead.php"
  useEffect(() => {
    getData()
  }, [])
  const getData = async () => {
    try {
      const response = await config.localTestingUrl.get(depannage_url)
      setDepanageContent(response.data);
    } catch (error) {

    }
  }

  const contents = depanageContent.map((Content) => (


    <Card className="card form-cadre h-100" key={Content.id}>
      <Card.Body>
        <Card.Title style={{ fontSize: "40px", textAlign: "center" }}>{Content.title}</Card.Title>
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
        
        <div className="d-flex justify-content-center">
        <Link to={"/depanage"} className="mt-auto">
          <Button className="bouton bouton-lien align-items-center">Plus d'information</Button>
        </Link>
      </div>
      </Card.Body>
    </Card>
  ));

  return <div className="col mb-4">{contents}</div>;
};


export default Depanage;

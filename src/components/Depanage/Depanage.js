import React from 'react';
import { useEffect } from 'react';
import { useState } from 'react';
import config from '../../api/axios';
import { Link } from 'react-router-dom';
import {Card } from 'react-bootstrap';


const Depanage = () => {

  const [depanageContent, setDepanageContent] = useState([]);
  const depannage_url = "/api/depannage_contents"
  useEffect(() => {
    getData()
  }, [])
  const getData = async () => {
    try {
      const response = await config.localTestingUrl.get(depannage_url, {withCredentials: true})
      if (Array.isArray(response.data)) {
        setDepanageContent(response.data);      
      } else {
        setDepanageContent([])
      }
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  }

  const contents = depanageContent.length > 0 ? 
  (depanageContent.map((Content) => (

    <Card className="card form-cadre h-100 d-flex flex-column" key={Content.id}>
      <Card.Body className="d-flex flex-column">
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
        
        <div className="d-flex justify-content-center mt-auto" >
        <Link to={"/depanage"} className="mt-auto">
          <button className="bouton bouton-lien align-items-center">Plus d'information</button>
        </Link>
      </div>
      </Card.Body>
    </Card>
  ))
)  :(
  <div className='text-center'>
    <h3>Pas de depannage disponible</h3>
  </div>
)

  return <>{contents}</>;
};


export default Depanage;

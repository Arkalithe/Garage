import React from 'react';
import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from '../../api/axios';
import { useState } from 'react';

export const VoitureOccasion = () => {

  const [voitureContent, setVoitureContent] = useState([]);
  const voiture_url = "/Garage/php/Api/Ocasion/OcasionRead.php"

  useEffect(() => {
    getData()
  }, [])

  const getData = async () => {
    try {
      const response = await axios.get(voiture_url)
      setVoitureContent(response.data);


    } catch (error) {

    }
  }

  const contents = voitureContent.map((Content) => (
    <div className="card form-cadre h-100">
      <div className="pb-2 card-title">
        <h1>{Content.title}</h1>
      </div>
      <div className="pb-3 m-2">
        {Content.image.length > 0 ? (
          <div
            className="image-container d-flex justify-content-center align-items-center"
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
      <Link
        to={"/voiture"}
        className="d-flex justify-content-center align-items-center mt-auto bouton bouton-lien"
      >
        Plus d'information
      </Link>
    </div>
  ));

  return <div className="col mb-4">{contents}</div>;
};

export default VoitureOccasion;

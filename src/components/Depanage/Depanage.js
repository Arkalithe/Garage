import React from 'react';
import { useEffect } from 'react';
import { useState } from 'react';
import config from '../../api/axios';
import { Link } from 'react-router-dom';


const Depanage = () => {

  const [depanageContent, setDepanageContent] = useState([]);
  const depannage_url = "/Garage/php/Api/Depanage/DepanageRead.php"
  useEffect(() => {
    getData()
  }, [])
  const getData = async () => {
    try {
      const response = await config.herokuTesting.get(depannage_url)
      setDepanageContent(response.data);
    } catch (error) {

    }
  }

  const contents = depanageContent.map((Content) => (


    <div className="card form-cadre h-100">
      <div className="pb-2 card-title">
        <h1>{Content.title}</h1>
      </div>
      <div className="pb-3 m-2">
        {Content.image.length > 0 ? (
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
      <div className="pb-3">

        <p>{Content.intro}</p>
      </div>
      <Link to={"/depanage"} className="d-flex justify-content-center mt-auto bouton bouton-lien">
        Plus d'information
      </Link>
    </div>
  ))


  return (
    <div className="col mb-4">{contents}</div>
  );
};


export default Depanage;

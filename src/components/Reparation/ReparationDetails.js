import React from "react";
import config from "../../api/axios";
import { useState } from "react";
import { useEffect } from "react";

const ReparationDetails = () => {
  const [reparationContent, setReparationContent] = useState([]);

  const reparation_url = "/Garage/php/Api/Reparation/ReparationRead.php"

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
  const contents = reparationContent.map((Content) => (
    <div className="" key={Content.id}>
      <div className="pb-2 ">
        <h1>{Content.title}</h1>
      </div>
      <div className="pb-3">
        {Content.image.length > 0 ? (
          <img
            className="img-fluid"
            src={require(`../../assests/Image/${Content.image}`)}
            alt="Reparation"
            style={{ maxWidth: '300px', maxHeight: '300px' }}
          />
        ) : (
          <div>No Image</div>
        )}
      </div>
      <div className="pb-3">
        <p>{Content.intro}</p>
      </div>
      <div className="pb-3">
        <p>{Content.message}</p>
      </div>

    </div>
  ))


  return (
    <div className="col mb-4 voit">{contents}</div>
  );
};

export default ReparationDetails;
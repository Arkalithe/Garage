import React, { useState, useEffect } from "react";
import config from "../../api/axios";
import  {Rating}  from "@mui/material";

const GetAvis = () => {
    const register_url = '/Garage/php/Api/Avis/AvisRead.php';
    const [avis, setAvis] = useState([]);


    useEffect(() => {
        fetchAvis();
    }, []);

    const fetchAvis = async () => {
        try {
          const response = await config.localTestingUrl.get(register_url);     
          const filteredData = response.data.filter(aviss => aviss.moderate === 1);
          const shuffledData = filteredData.sort(() => Math.random() - 0.5);
      
          setAvis(shuffledData.slice(0, 4));
        } catch (error) {       
            console.error("Erreure recuperation des avis ", error);   
        }
      };


    const avist = avis.map((aviss) =>  (

            <div className="voit d-flex flex-column container col-5 align-items-center my-3" key={aviss.id}>
                <div className="container pt-2  m-auto">
                    <div >
                        {aviss.name}
                    </div>
                </div>

                <div className="container m-auto">
                    <div className="my-3 avis-message">
                        {aviss.message}
                    </div>
                </div>

                <div className="container m-auto">
                    <Rating
                        type="number"
                        id="note"
                        name="read-only"
                        size="large"
                        value={aviss.note}
                        readOnly
                    />
                </div>
            </div>
        ));

    return (

        <div className="d-flex flex-wrap justify-content-between">
            {avist}
        </div>

    );
};

export default GetAvis;

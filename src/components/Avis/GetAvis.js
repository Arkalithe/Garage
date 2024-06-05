import React, { useState, useEffect } from "react";
import config from "../../api/axios";
import { Rating } from "@mui/material";
import { Container } from "react-bootstrap";

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


    const avist = avis.map((aviss) => (

        <Container className="voit d-flex flex-column container col-5 align-items-center my-3" key={aviss.id}>
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

            <div>
                <Rating
                    type="number"
                    id="note"
                    name="read-only"
                    size="large"
                    value={aviss.note}
                    readOnly
                    className="w-auto"
                />
            </div>
        </Container>
    ));

    return (

        <div className="d-flex">
            {avist}
        </div>

    );
};

export default GetAvis;

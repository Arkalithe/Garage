import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "../../api/axios";
import { Rating } from "@mui/material";

const SingleAvis = () => {
    const avis_url = "/Garage/php/Api/Avis/AvisGetSingle.php";
    const deleteAvis_url = "/Garage/php/Api/Avis/AvisDelete.php";
    const updateAvis_url = "/Garage/php/Api/Avis/AvisUpdate.php";


    const [isLoading, setLoading] = useState(true);
    const [avis, setAvis] = useState([]);
    const { idAvis } = useParams();

    useEffect(() => {
        fetchAvis();
    }, []);

    const fetchAvis = async () => {
        try {
            const response = await axios.get(avis_url, { params: { id: idAvis } });
            setAvis(response.data);
            setLoading(false);
        } catch (error) {
            console.log(error);
        }
    };

    const handleDelete = async () => {
        try {
            const response = await axios.post(deleteAvis_url, { ids: [idAvis] });
            console.log(response.data);

        } catch (error) {
            console.log(error);
        }
    };

    const handleUpdate = async () => {
        try {
            const updatedAvis = {
                id: idAvis,
                moderate: 1,
                note: avis.note,
                message: avis.message,
                name: avis.name
            };

            const response = await axios.post(updateAvis_url, updatedAvis );
            console.log(response.data);
            setAvis(prevAvis => ({ ...prevAvis, moderate: 1}));

        } catch (error) {
            console.log(error);
        }
    };

    if (isLoading) {
        return <div>Chargement</div>;
    }

    return (
        <section className="voit container align-items-center">
            <div className="d-flex flex-column align-items-center">
                <div className="my-2">{avis.name}</div>
                <div className="my-2">{avis.message}</div>
                <Rating
                    className="my-2"
                    type="number"
                    id="note"
                    name="read-only"
                    size="large"
                    value={avis.note}
                    readOnly
                />
                <div>
                    
                    <button className="bouton mx-4" onClick={handleUpdate}>Autoriser</button>
                    <button className="bouton-delete mx-4" onClick={handleDelete}>Suprimer</button>
                </div>
            </div>
        </section>
    );
};

export default SingleAvis;
import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import config from "../../api/axios";
import { Rating } from "@mui/material";

const SingleAvis = () => {
    const avis_url = "/Api/Avis/AvisGetSingle.php";
    const deleteAvis_url = "/Api/Avis/AvisDelete.php";
    const updateAvis_url = "/Api/Avis/AvisUpdate.php";


    const [isLoading, setLoading] = useState(true);
    const [avis, setAvis] = useState([]);
    const { idAvis } = useParams();

    useEffect(() => {
       
        fetchAvis();
    }, []);

     const fetchAvis = async () => {
        try {
            const response = await config.localTestingUrl.get(avis_url, { params: { id: idAvis } });
            setAvis(response.data);
            setLoading(false);
        } catch (error) {
           
        }
    };

    const handleDelete = async () => {
        try {
        await config.localTestingUrl.post(deleteAvis_url, { ids: [idAvis] });
        } catch (error) {
            
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

            await config.localTestingUrl.post(updateAvis_url, updatedAvis );
            setAvis(prevAvis => ({ ...prevAvis, moderate: 1}));
        } catch (error) {           
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
import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "../../api/axios";
import { Contact } from "../Contact/Contact";
import Carousel from "react-material-ui-carousel";

const SingleCar = () => {
    const register_url = '/Garage/php/Api/Car/CarGetSingle.php';

    const [isLoading, setLoading] = useState(true);
    const [form, setForm] = useState(false);
    const [voiture, setVoiture] = useState([]);
    const { idVoiture } = useParams();

    const handleClick = () => {
        setForm((prevState) => !prevState);
    };

    useEffect(() => {
        fetchVoiture();
    }, []);

    const fetchVoiture = async () => {
        try {
            const res = await axios.get(register_url, { params: { id: idVoiture } });
            setVoiture(res.data);            
            setLoading(false);
        } catch (err) {            
        }
    };

    if (isLoading) {
        return <div>Chargement</div>;
    }

    return (
        <section className="container-fluid d-flex row">
            {form ? (
                <div className="form-cadre d-flex flex-column align-items-center my-3">
                    <Contact car={voiture} />
                    <button onClick={handleClick} className="bouton-alt mb-3 p-2" style={{ backgroundColor: '#db3e3e' }}>
                        Précedent
                    </button>
                </div>
            ) : (
                <div className="voit">
                    <h1>
                        <div>{voiture.modele}</div>
                    </h1>

                    <div className="container-lg d-flex">
                        <div className="row">
                            <div className="d-flex flex-column align-items-start my-1">
                                <h3>Prix :</h3>
                                <div>{voiture.prix}</div>
                            </div >
                            <div className="d-flex flex-column align-items-start  my-1">
                                <h3>Kilometrage :</h3>
                                <div>{voiture.kilometrage}</div>
                            </div>
                            <div className="d-flex flex-column align-items-start  my-1">
                                <h3>Année de mise en circulation :</h3>
                                <div>{voiture.annee_circulation}</div>
                            </div>
                            <div className="d-flex flex-column align-items-start  my-1">
                                <h3>Caracteristique :</h3>
                                {Array.isArray(voiture.caracteristique) ? (
                                    <div>{voiture.caracteristique.join(" / ")}</div>
                                ) : (
                                    <div>{voiture.caracteristique}</div>
                                )}
                            </div>
                            <div className="d-flex flex-column align-items-start  my-1">
                                <h3>Equipement :</h3>
                                {Array.isArray(voiture.equipement) ? (
                                    <div>{voiture.equipement.join(' / ')}</div>) :
                                    (<div>{voiture.equipement}</div>
                                    )}

                            </div>
                        </div>

                        <div className="container-fluid d-flex row align-items-center justify-content-end">
                            <Carousel
                                navButtonsAlwaysVisible
                            >
                                {voiture.voiture_images.map((image, index) => (
                                    <div key={index} >
                                        {image.length > 0 ? (
                                            <img                                                
                                                className="img-fluid"
                                                style={{ width: "300px", height: "200px" }}
                                                src={require(`../../assests/Image/${image}`)}
                                                alt="voiture"
                                            />

                                        ) : (
                                            <div>No Image</div>
                                        )}</div>

                                ))}

                            </Carousel>
                        </div>

                    </div>

                    <button onClick={handleClick} className="bouton">Contact</button>
                </div>
            )}
        </section>
    );
};

export default SingleCar;

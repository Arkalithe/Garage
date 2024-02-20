import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import config from "../../api/axios";
import { Contact } from "../Contact/Contact";
import Carousel from "react-material-ui-carousel";
import { Button, Container, Row, Col, Card } from "react-bootstrap";

const SingleCar = () => {
    const register_url = '/Api/Car/CarGetSingle.php';

    const [isLoading, setLoading] = useState(true);
    const [form, setForm] = useState(false);
    const [voiture, setVoiture] = useState([]);
    const { idVoiture } = useParams();

    const handleClick = () => {
        setForm((prevState) => !prevState);
    };

    useEffect(() => {
        const fetchVoiture = async () => {
            try {
                const res = await config.localTestingUrl.get(register_url, { params: { id: idVoiture } });
                setVoiture(res.data);            
                setLoading(false);
            } catch (err) {            
                console.error('Error fetching car:', err);
            }
        };
        fetchVoiture();
    }, [idVoiture]);

    if (isLoading) {
        return <div>Chargement</div>;
    }

    return (
        <Container fluid className="d-flex row">
            {form ? (
                <Card className="form-cadre d-flex flex-column align-items-center my-3">
                    <Contact car={voiture} />
                    <Button onClick={handleClick} variant="danger" className="mb-3 p-2">
                        Précedent
                    </Button>
                </Card>
            ) : (
                <Card className="voit">
                    <h1>
                        <div>{voiture.modele}</div>
                    </h1>
                    <Container fluid className="d-flex">
                        <Row>
                            <Col className="d-flex flex-column align-items-start my-1">
                                <h3>Prix :</h3>
                                <div>{voiture.prix}</div>
                            </Col>
                            <Col className="d-flex flex-column align-items-start my-1">
                                <h3>Kilometrage :</h3>
                                <div>{voiture.kilometrage}</div>
                            </Col>
                            <Col className="d-flex flex-column align-items-start my-1">
                                <h3>Année de mise en circulation :</h3>
                                <div>{voiture.annee_circulation}</div>
                            </Col>
                            <Col className="d-flex flex-column align-items-start my-1">
                                <h3>Caracteristique :</h3>
                                {Array.isArray(voiture.caracteristique) ? (
                                    <div>{voiture.caracteristique.join(" / ")}</div>
                                ) : (
                                    <div>{voiture.caracteristique}</div>
                                )}
                            </Col>
                            <Col className="d-flex flex-column align-items-start my-1">
                                <h3>Equipement :</h3>
                                {Array.isArray(voiture.equipement) ? (
                                    <div>{voiture.equipement.join(' / ')}</div>) :
                                    (<div>{voiture.equipement}</div>
                                )}
                            </Col>
                        </Row>
                        <Row className="container-fluid d-flex row align-items-center justify-content-end">
                            <Carousel navButtonsAlwaysVisible>
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
                                        )}
                                    </div>
                                ))}
                            </Carousel>
                        </Row>
                    </Container>
                    <Button onClick={handleClick} className="bouton">Contact</Button>
                </Card>
            )}
        </Container>
    );
};

export default SingleCar;

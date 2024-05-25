import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import config from "../../api/axios";
import { Contact } from "../Contact/Contact";
import { Button, Container, Row, Col, Card, Spinner, Carousel } from "react-bootstrap";

const SingleCar = () => {
    const register_url = '/Garage/php/Api/Car/CarGetSingle.php';

    const [isLoading, setLoading] = useState(true);
    const [form, setForm] = useState(false);
    const [voiture, setVoiture] = useState({});
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
                console.error('Erreur recuperation voiture:', err);
                setLoading(false);
            }
        };
        fetchVoiture();
    }, [idVoiture]);

    if (isLoading) {
        return <div className="text-center mt-5"><Spinner animation="border" /> Chargement...</div>;
    }

    return (
        <>
            {form ? (
                <Card className="form-cadre d-flex flex-column align-items-center my-3 p-3">
                    <Contact car={voiture} />
                    <Button onClick={handleClick} variant="danger" className="mb-3">
                        Précédent
                    </Button>
                </Card>
            ) : (
                <Container className="voit" >
                    <Row >
                        <h1 className="text-center">
                            {voiture.modele}
                        </h1>
                        <Col md={7} >
                            <Row className="text-start">
                                <Row className="mb-3 ">
                                    <h3>Prix :</h3>
                                    <div>{voiture.prix}</div>
                                </Row>
                                <Row className="mb-3">
                                    <h3>Kilométrage :</h3>
                                    <div>{voiture.kilometrage}</div>
                                </Row>
                                <Row className="mb-3">
                                    <h3>Année de mise en circulation :</h3>
                                    <div>{voiture.annee_circulation}</div>
                                </Row>
                                <Row className="mb-3">
                                    <h3>Caractéristiques :</h3>
                                    <div>{Array.isArray(voiture.caracteristique) ? voiture.caracteristique.join(" / ") : voiture.caracteristique}</div>
                                </Row>
                                <Row className="mb-3">
                                    <h3>Équipement :</h3>
                                    <div>{Array.isArray(voiture.equipement) ? voiture.equipement.join(' / ') : voiture.equipement}</div>
                                </Row>
                            </Row>
                        </Col>
                        <Col md={5} className="d-flex align-items-center justify-content-center">
                            <Container > 
                            <Carousel slide={false} >
                                {voiture.voiture_images && voiture.voiture_images.length > 0 ? (
                                    voiture.voiture_images.map((image, index) => (
                                        <Carousel.Item key={index}>
                                            <img
                                                className="img-fluid"
                                                style={{ width: "80%", maxHeight: "400px" }}
                                                src={require(`../../assests/Image/${image}`)}
                                                alt="voiture"
                                            />
                                        </Carousel.Item>
                                    ))
                                ) : (
                                    <div>No Images Available</div>
                                )}
                            </Carousel>
                            </Container>
                        </Col>
                        <div>
                            <button onClick={handleClick} className="bouton align-items-center">Contact</button>
                        </div>
                    </Row>

                </Container>


            )}
        </>
    );
};

export default SingleCar;

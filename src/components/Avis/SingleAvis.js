import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import config from "../../api/axios";
import { Rating } from "@mui/material";
import { Container, Row, Col, Button, Spinner } from 'react-bootstrap';

const SingleAvis = () => {
    const avis_url = "/Garage/php/Api/Avis/AvisGetSingle.php";
    const deleteAvis_url = "/Garage/php/Api/Avis/AvisDelete.php";
    const updateAvis_url = "/Garage/php/Api/Avis/AvisUpdate.php";

    const [isLoading, setLoading] = useState(true);
    const [avis, setAvis] = useState([]);
    const { idAvis } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        const fetchAvis = async () => {
            try {
                const response = await config.localTestingUrl.get(avis_url, { params: { id: idAvis } });
                console.log(response);
                setAvis(response.data);
                setLoading(false);
            } catch (error) {
                console.error("Error fetching avis:", error);
            }
        };
        fetchAvis();
    }, [idAvis]);

    const handleDelete = async () => {
        const confirmDelete = window.confirm("Êtes-vous sûr de vouloir supprimer cet avis ?");
        if (confirmDelete) {
            try {
                await config.localTestingUrl.post(deleteAvis_url, { ids: [idAvis] });
                navigate(-1); // Go back to the previous page
            } catch (error) {
                console.error("Error deleting avis:", error);
            }
        }
    };

    const handleUpdate = async () => {
        const confirmUpdate = window.confirm("Êtes-vous sûr de vouloir autoriser cet avis ?");
        if (confirmUpdate) {
            try {
                const updatedAvis = {
                    id: idAvis,
                    moderate: 1,
                    note: avis.note,
                    message: avis.message,
                    name: avis.name
                };

                await config.localTestingUrl.post(updateAvis_url, updatedAvis);
                setAvis(prevAvis => ({ ...prevAvis, moderate: 1 }));
                navigate(-1); // Go back to the previous page
            } catch (error) {
                console.error("Error updating avis:", error);
            }
        }
    };

    if (isLoading) {
        return <div className="text-center"><Spinner animation="border" /></div>;
    }

    return (
        <Container className="voit align-items-center mb-3">
            <Row className="d-flex flex-column align-items-center">
                <Col className="my-2">{avis.name}</Col>
                <Col className="my-2">{avis.message}</Col>
                <Col className="my-2">
                    <Rating
                        type="number"
                        id="note"
                        name="read-only"
                        size="large"
                        value={avis.note}
                        readOnly
                    />
                </Col>
                <Col>
                    <Button className="bouton mx-2" onClick={handleUpdate}>Autoriser</Button>
                    <Button className="bouton-delete mx-2" onClick={handleDelete}>Supprimer</Button>
                </Col>
            </Row>
        </Container>
    );
};

export default SingleAvis;

import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import config from "../../api/axios";
import { Rating } from "@mui/material";
import { Container, Row, Col, Button, Spinner } from 'react-bootstrap';

const SingleAvis = () => {
    const avis_url = "/api/aviss";
    const deleteAvis_url = "/api/aviss";
    const updateAvis_url = "/api/aviss";

    const [isLoading, setLoading] = useState(true);
    const [avis, setAvis] = useState([]);
    const { idAvis } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        const fetchAvis = async () => {
            try {
                const response = await config.localhost.get(avis_url, { params: { id: idAvis } });
                const avisData = response.data['hydra:member'];
                console.log(avisData);
                setAvis(avisData);
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
                await config.localTestingUrl.delete(deleteAvis_url, { params: { id: idAvis } });
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

                await config.localTestingUrl.patch(updateAvis_url, updatedAvis);
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

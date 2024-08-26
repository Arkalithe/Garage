import React, { useEffect, useState } from 'react';
import { Card, Col, Container, Row } from 'react-bootstrap';
import config from '../../api/axios';

const DepanageDetails = () => {
    const [depanageContent, setDepanageContent] = useState([]);
    const depannage_url = "/api/depannage_contents";

    useEffect(() => {
        getData();
    }, []);

    const getData = async () => {
        try {
            const response = await config.localTestingUrl.get(depannage_url, { withCredentials: true });

            setDepanageContent(response.data);
            console.log(response)
        } catch (error) { }
    };

    const contents = depanageContent.map((Content, index) => (
        <Col xs={12} sm={6} md={4} lg={3} className="mb-4 d-flex justify-content-center" key={index}>
            <Card className="form-cadre h-100">
                <Card.Body>
                    <Card.Title>{Content.title}</Card.Title>
                    <Card.Text>
                        {Content.imagePath.length > 0 ? (
                            <img
                                className="img-fluid"
                                src={require(`../../assests/Image/${Content.imagePath}`)}
                                alt="Depanage"
                                style={{ maxWidth: '100%', height: 'auto'}}
                            />
                        ) : (
                            <div>No Image</div>
                        )}
                        <p>{Content.intro}</p>
                        <p>{Content.message}</p>
                    </Card.Text>
                </Card.Body>
            </Card>
        </Col>
    ));

    return <Container>
        <Row className="justify-content-center">{contents}</Row>
    </Container>;
};

export default DepanageDetails;

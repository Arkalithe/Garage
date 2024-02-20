import React, { useEffect, useState } from 'react';
import { Card } from 'react-bootstrap';
import config from '../../api/axios';

const DepanageDetails = () => {
    const [depanageContent, setDepanageContent] = useState([]);
    const depannage_url = "/Garage/php/Api/Depanage/DepanageRead.php";

    useEffect(() => {
        getData();
    }, []);

    const getData = async () => {
        try {
            const response = await config.herokuTesting.get(depannage_url);
            setDepanageContent(response.data);
        } catch (error) {}
    };

    const contents = depanageContent.map((Content, index) => (
        <div className="col mb-4" key={index}>
            <Card className="form-cadre h-100">
                <Card.Body>
                    <Card.Title>{Content.title}</Card.Title>
                    <Card.Text>
                        {Content.image.length > 0 ? (
                            <img
                                className="img-fluid"
                                src={require(`../../assests/Image/${Content.image}`)}
                                alt="Depanage"
                                style={{ maxWidth: '300px', maxHeight: '300px' }}
                            />
                        ) : (
                            <div>No Image</div>
                        )}
                        <p>{Content.intro}</p>
                        <p>{Content.message}</p>
                    </Card.Text>
                </Card.Body>
            </Card>
        </div>
    ));

    return <div className="row">{contents}</div>;
};

export default DepanageDetails;

import React, { useState, useEffect } from "react";
import config from "../../api/axios";
import { Form, Button, Card } from "react-bootstrap";

const EditReparation = () => {
    const [reparationContent, setReparationContent] = useState([]);
    const [formData, setFormData] = useState({
        id: "",
        title: "",
        intro: "",
        message: "",
        image: null,
    });

    const reparation_url = "/Garage/php/Api/Reparation/ReparationRead.php";
    const reparation_edit_url = "/Garage/php/Api/Reparation/ReparationUpdate.php";

    useEffect(() => {
        getData();
    }, []);

    const getData = async () => {
        try {
            const response = await config.herokuTesting.get(reparation_url);
            setReparationContent(response.data);
            const Content = response.data[0];
            setFormData({
                id: Content.id,
                title: Content.title,
                intro: Content.intro,
                message: Content.message,
                image: Content.image,
            });
        } catch (error) { }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const newFormData = new FormData();
        newFormData.append("id", formData.id);
        newFormData.append("titre", formData.title);
        newFormData.append("intro", formData.intro);
        newFormData.append("message", formData.message);
        if (formData.image) {
            newFormData.append("image", formData.image);
        }

        try {
            await config.herokuTesting.post(reparation_edit_url, newFormData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            });
            getData();
        } catch (error) { }
    };

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleImageUpload = (event) => {
        const file = event.target.files[0];
        setFormData({ ...formData, image: file });
    };

    const image = reparationContent.map((Content) => (
        <Card className="d-flex align-items-center justify-content-center m-2" key={Content.id}>
            {Content.image.length > 0 ? (
                <Card.Img className="img-fluid" src={require(`../../assests/Image/${Content.image}`)} alt="Reparation"
                    style={{
                        width: "100%",
                        height: "100%",
                        maxWidth: "200px",
                        maxHeight: "200px",
                        overflow: "hidden",
                        objectFit: "contain",
                    }} />
            ) : (
                <div>No Image</div>
            )}
        </Card>
    ));

    return (
        <div className="col mb-4 voit d-flex flex-column p-2">
            <h3>Modification Reparation</h3>
            <Form className="d-flex align-items-center justify-content-start-start flex-column" onSubmit={handleSubmit}>
                <Form.Group className="pb-2 m-1 d-flex flex-column align-items-center justify-content-start">
                    <Form.Label>Titre :</Form.Label>
                    <Form.Control type="text" name="title" value={formData.title} onChange={handleChange} />
                </Form.Group>
                <Form.Group className="pb-3 m-1 d-flex flex-column">
                    <Form.Label>Image :</Form.Label>
                    <Form.Control type="file" name="image" onChange={handleImageUpload} />
                </Form.Group>
                <Form.Group className="pb-3 m-1 d-flex flex-column">
                    <Form.Label>Intro Carte Home :</Form.Label>
                    <Form.Control as="textarea" name="intro" value={formData.intro} onChange={handleChange} style={{ height: "300px", width: "300px" }} />
                </Form.Group>
                <Form.Group className="pb-3 d-flex flex-column">
                    <Form.Label>Message :</Form.Label>
                    <Form.Control as="textarea" name="message" value={formData.message} onChange={handleChange} style={{ height: "500px", width: "500px" }} />
                </Form.Group>
                {image}
                <Button type="submit" className="bouton bouton-lien">Envoyer Modification</Button>
            </Form>
        </div>
    );
};

export default EditReparation;

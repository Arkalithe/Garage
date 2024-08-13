import React from "react";
import config from "../../api/axios";
import { useState, useEffect } from "react";
import { Container, Form, Button } from "react-bootstrap";

const EditOcasion = () => {
  const [ocasionContent, setOcasionContent] = useState([]);
  const [formData, setFormData] = useState({
    id: "",
    title: "",
    intro: "",
    image: null,
  });

  const ocasion_url = "/api/voiture_contents";
  const ocasion_edit_url = "/api/voiture_contents";

  useEffect(() => {
    getData();
  }, []);

  const getData = async () => {
    try {
      const response = await config.localTestingUrl.get(ocasion_url);
      setOcasionContent(response.data);

      const content = response.data[0];
      setFormData({
        id: content.id,
        title: content.title,
        intro: content.intro,
        image: content.image,
      });
    } catch (error) {}
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const newFormData = new FormData();
    newFormData.append("id", formData.id);
    newFormData.append("titre", formData.title);
    newFormData.append("intro", formData.intro);
    if (formData.image) {
      newFormData.append("image", formData.image);
    }

    try {
      await config.localTestingUrl.patch(ocasion_edit_url, newFormData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });

      getData();
    } catch (error) {}
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

  const image = ocasionContent.map((content) => (
    <div
      className="d-flex align-items-center justify-content-center m-2"
      key={content.id}
    >
      {content.image.length > 0 ? (
        <img
          className="img-fluid"
          src={require(`../../assests/Image/${content.image}`)}
          alt="Ocasion"
          style={{ maxWidth: "300px", maxHeight: "300px" }}
        />
      ) : (
        <div>No Image</div>
      )}
    </div>
  ));

  return (
    <Container className="col mb-4 voit d-flex flex-column p-2">
      <h3>Modification Ocasion</h3>
      <Form onSubmit={handleSubmit}>
        <Form.Group className="pb-2 m-1 d-flex flex-column align-items-center justify-content-start">
          <Form.Label>Titre :</Form.Label>
          <Form.Control
            type="text"
            name="title"
            value={formData.title}
            onChange={handleChange}
          />
        </Form.Group>
        <Form.Group className="pb-3 m-1 d-flex flex-column">
          <Form.Label>Image :</Form.Label>
          <Form.Control
            type="file"
            name="image"
            onChange={handleImageUpload}
          />
        </Form.Group>
        <Form.Group className="pb-3 m-1 d-flex flex-column">
          <Form.Label>Intro Carte Home :</Form.Label>
          <Form.Control
            as="textarea"
            rows={3}
            name="intro"
            value={formData.intro}
            onChange={handleChange}
          />
        </Form.Group>
        {image}
        <Button type="submit" className="bouton bouton-lien">
          Envoyer Modification
        </Button>
      </Form>
    </Container>
  );
};

export default EditOcasion;

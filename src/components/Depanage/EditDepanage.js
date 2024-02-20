import React, { useState, useEffect } from "react";
import { Form, Button } from "react-bootstrap";
import config from "../../api/axios";

const EditDepanage = () => {
  const [DepanageContent, setDepanageContent] = useState([]);
  const [formData, setFormData] = useState({
    id: "",
    title: "",
    intro: "",
    message: "",
    image: null,
  });

  const depanage_url = "/Garage/php/Api/Depanage/DepanageRead.php";
  const depanage_edit_url = "/Garage/php/Api/Depanage/DepanageUpdate.php";

  useEffect(() => {
    getData();
  }, []);

  const getData = async () => {
    try {
      const response = await config.herokuTesting.get(depanage_url);
      setDepanageContent(response.data);

      const Content = response.data[0];
      setFormData({
        id: Content.id,
        title: Content.title,
        intro: Content.intro,
        message: Content.message,
        image: Content.image,
      });
    } catch (error) {}
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
      await config.herokuTesting.post(depanage_edit_url, newFormData, {
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

  const image = DepanageContent.map((Content) => (
    <div className="d-flex align-items-center justify-content-center m-2" key={Content.id}>
      {Content.image.length > 0 ? (
        <img className="img-fluid" src={require(`../../assests/Image/${Content.image}`)} alt="Depanage" style={{ maxWidth: "300px", maxHeight: "300px" }} />
      ) : (
        <div>No Image</div>
      )}
    </div>
  ));

  return (
    <div className="col mb-4 voit d-flex flex-column p-2">
      <h3>Modification Depanage</h3>
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

export default EditDepanage;

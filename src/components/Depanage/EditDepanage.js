import React from "react";
import axios from "../../api/axios";
import { useState } from "react";
import { useEffect } from "react";


const EditDepanage = () => {
    const [DepanageContent, setDepanageContent] = useState([]);

    const [formData, setFormData] = useState({
        id: "",
        title: "",
        intro: "",
        message: "",
        image: null,
    });

    const depanage_url = "/Garage/php/Api/Depanage/DepanageRead.php"
    const depanage_edit_url = "/Garage/php/Api/Depanage/DepanageUpdate.php"
    useEffect(() => {
        getData()
    }, [])

    const getData = async () => {
        try {
            const response = await axios.get(depanage_url);
            setDepanageContent(response.data);
            console.log(response.data);

            const Content = response.data[0];
            setFormData({
                id: Content.id,
                title: Content.title,
                intro: Content.intro,
                message: Content.message,
                image: Content.image
            });
        } catch (error) {
            console.log("Error retrieving data:", error);
            console.log("Response status:", error.response.status);
            console.log("Response data:", error.response.data);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const newFormData = new FormData()
        newFormData.append('id', formData.id);
        newFormData.append('titre', formData.title);
        newFormData.append('intro', formData.intro);
        newFormData.append('message', formData.message);
        if (formData.image) {
            newFormData.append("image", formData.image);
        }

        try {

            await axios.post(depanage_edit_url, newFormData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            console.log("Data updated successfully!");
            console.log(newFormData)
            getData();
        } catch (error) {
            console.log("Error updating data:", error);
            console.log("Response status:", error.response.status);
            console.log("Response data:", error.response.data);
        }
    };

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleImageUpload = (event) => {
        const file = event.target.files[0];
        setFormData({ ...formData, image: file });
    };


    const image = DepanageContent.map((Content) => (

        <div className="d-flex align-items-center justify-content-center m-2" key={Content.id}>
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

        </div>
    ))


    return (
        <div className="col mb-4 voit d-flex flex-column p-2">
            <h3>Modification Depanage</h3>
            <form className="d-flex align-items-center justify-content-start-start flex-column" onSubmit={handleSubmit}>
                <div className="pb-2 m-1 d-flex flex-column align-items-center justify-content-start">
                    <label>Titre :</label>
                    <input
                        type="text"
                        name="title"
                        value={formData.title}
                        onChange={handleChange}
                    />
                </div>
                <div className="pb-3 m-1 d-flex flex-column">
                    <label>Image :</label>
                    <input
                        type="file"
                        name="image"
                        onChange={handleImageUpload}
                    />
                </div>

                <div className="pb-3 m-1 d-flex flex-column">
                    <label>Intro Carte Home :  </label>
                    <textarea
                        name="intro"
                        value={formData.intro}
                        onChange={handleChange}
                        style={{ height: "300px", width: "300px" }}
                    ></textarea>
                </div>
                <div className="pb-3 d-flex flex-column">
                    <label>Message :  </label>
                    <textarea
                        name="message"
                        value={formData.message}
                        onChange={handleChange}
                        style={{ height: "500px", width: "500px" }}
                    ></textarea>
                </div>
                {image}
                <button type="submit" className="bouton bouton-lien">Envoyer Modification</button>
            </form>


        </div>
    );
};

export default EditDepanage;
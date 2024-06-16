import React, { useRef, useState, useEffect } from 'react';
import config from '../../api/axios';
import { Link, useParams } from 'react-router-dom';
import { Form, Button } from 'react-bootstrap';
import BasicInfoForm from './BasicInfoForm';
import EquipementForm from './EquipementForm';
import CaracteristiqueForm from './CaracteristiqueForm';
import ImageGallery from './ImageGallery';

export const UpdateCar = () => {
    const errRef = useRef();
    const { idVoiture } = useParams();

    const [isLoading, setLoading] = useState(true);
    const [voiture, setVoiture] = useState({});
    const [err, setErr] = useState('');
    const [success, setSuccess] = useState(false);

    const car_update = `/Garage/php/Api/Car/CarUpdate.php`;
    const get_car = `/Garage/php/Api/Car/CarGetSingle.php`;

    useEffect(() => {
        const fetchVoiture = async () => {
            try {
                const res = await config.localTestingUrl.get(get_car, { params: { id: idVoiture } });
                setVoiture(res.data);
            } catch (err) {
                setErr('Erreur récupération données voiture');
            } finally {
                setLoading(false);
            }
        };

        fetchVoiture();
    }, [get_car, idVoiture]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('id', voiture.id);
        formData.append('nom', voiture.nom);
        formData.append('prenom', voiture.prenom);
        formData.append('modele', voiture.modele);
        formData.append('prix', voiture.prix);
        formData.append('kilometrage', voiture.kilometrage);
        formData.append('annee_circulation', voiture.annee_circulation);
        formData.append('numero', voiture.numero);

        if (Array.isArray(voiture.caracteristique)) {
            voiture.caracteristique.forEach((caracteristique, index) => {
                formData.append(`caracteristique_${index}`, caracteristique);
            });
        } else {
            formData.append('caracteristique', voiture.caracteristique);
        }

        if (Array.isArray(voiture.equipement)) {
            voiture.equipement.forEach((equipement, index) => {
                formData.append(`equipement_${index}`, equipement);
            });
        } else {
            formData.append('equipement', voiture.equipement);
        }

        if (voiture.images) {
            voiture.images.forEach((image, index) => {
                formData.append(`image_${index}`, image);
            });
        }

        try {
            await config.localTestingUrl.post(car_update, formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            setSuccess(true);
        } catch (err) {
            setErr('An error occurred while updating the car');
            errRef.current.focus();
        }
    };

    const handleChange = (event) => {
        const { name, value } = event.target;
        setVoiture((prevVoiture) => ({ ...prevVoiture, [name]: value }));
    };

    const handleImageUpload = (event) => {
        const files = event.target.files;
        const uploadedImages = [];
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            uploadedImages.push(file);
        }
        setVoiture({ ...voiture, images: uploadedImages });
    };

    if (isLoading) {
        return <div>Chargement...</div>;
    }

    return (
        <>
            {success ? (
                <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
                    <h1 className="d-flex flex-column p-2 m-2">Car Updated</h1>
                    <p>
                        <Link to="/adminSpace" className="bouton lien">
                            Retour à l'espace Admin
                        </Link>
                    </p>
                </section>
            ) : (
                <section className="form-cadre align-items-center">
                    <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
                        {err}
                    </p>
                    <h1 className="d-flex flex-column p-1 m-2">Update Car</h1>
                    <Form className="d-flex flex-column p-2 m-2" onSubmit={handleSubmit} encType="multipart/form-data">
                        <BasicInfoForm voiture={voiture} handleChange={handleChange} />
                        <EquipementForm voiture={voiture} handleChange={handleChange} setVoiture={setVoiture} />
                        <CaracteristiqueForm voiture={voiture} handleChange={handleChange} setVoiture={setVoiture} />
                        <Form.Group controlId="image">
                            <Form.Label>Image:</Form.Label>
                            <Form.Control
                                type="file"
                                name="image"
                                accept=".jpeg, .png, .jpg"
                                onChange={handleImageUpload}
                                multiple
                            />
                        </Form.Group>
                        <Button className="d-flex flex-column p-2 m-2 mt-3" type="submit">
                            Modification
                        </Button>
                    </Form>
                    <ImageGallery voiture={voiture} setVoiture={setVoiture} />
                </section>
            )}
        </>
    );
};

export default UpdateCar;

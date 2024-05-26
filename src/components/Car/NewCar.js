import React, { useRef, useState } from 'react';
import config from '../../api/axios';
import { Link } from 'react-router-dom';
import { Form, Container, Alert } from 'react-bootstrap';

export const NewCar = () => {
    const errRef = useRef();
    const nameRef = useRef();
    const prenomRef = useRef();
    const modeleRef = useRef();
    const prixRef = useRef();
    const kilometrageRef = useRef();
    const anneeRef = useRef();
    const numeroRef = useRef();
    const imageRef = useRef();

    const [equipementData, setEquipementData] = useState([]);
    const [caracteristiqueData, setCaracteristiqueData] = useState([]);
    const [carData, setCarData] = useState({
        nom: '',
        prenom: '',
        modele: '',
        prix: '',
        kilometrage: '',
        annee_circulation: '',
        numero: '',
        images: [],
    });

    const [err, setErr] = useState('');
    const [success, setSuccess] = useState(false);

    const Car_url = '/Garage/php/Api/Car/CarCreate.php';

    const handleSubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData();
        Object.keys(carData).forEach(key => {
            if (key === 'images') {
                carData.images.forEach((image, index) => {
                    formData.append(`image_${index}`, image);
                });
            } else {
                formData.append(key, carData[key]);
            }
        });

        equipementData.forEach((equipement, index) => {
            formData.append(`equipement_${index}`, equipement);
        });

        caracteristiqueData.forEach((caracteristique, index) => {
            formData.append(`caracteristique_${index}`, caracteristique);
        });

        try {
            await config.localTestingUrl.post(Car_url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            setSuccess(true);
        } catch (err) {
            if (!err?.response) {
                setErr('Pas de reponse serveur');
            } else if (err.response?.status === 422) {
                setErr('422 Error');
            } else {
                setErr('Autre erreur');
            }
            errRef.current.focus();
        }
    };

    const handleChange = (event) => {
        const { name, value } = event.target;
        setCarData({ ...carData, [name]: value });
    };

    const handleImageUpload = (event) => {
        const files = event.target.files;
        const uploadedImages = Array.from(files);
        setCarData({ ...carData, images: uploadedImages });
    };

    const handleDynamicFieldChange = (setData, index, event) => {
        const { value } = event.target;
        setData((prevData) => {
            const updatedData = [...prevData];
            updatedData[index] = value;
            return updatedData;
        });
    };

    const handleAddDynamicField = (setData) => {
        setData((prevData) => [...prevData, '']);
    };

    const handleRemoveDynamicField = (setData, index) => {
        setData((prevData) => {
            const updatedData = [...prevData];
            updatedData.splice(index, 1);
            return updatedData;
        });
    };

    return (
        <Container className="form-cadre m-3">
            {success ? (
                <>
                    <h1 className="p-2 m-2 text-center">Voiture Ajouté</h1>
                    <p className="text-center">
                        <Link to="/adminSpace" className="btn btn-primary">Retour Accueil</Link>
                    </p>
                </>
            ) : (
                <>
                    <Alert ref={errRef} variant="danger" show={!!err}>
                        {err}
                    </Alert>

                    <h1 className="p-1 m-2 text-center">Ajouter une Voiture</h1>

                    <Form onSubmit={handleSubmit} encType="multipart/form-data">
                        <Form.Group className="mb-3" controlId="nom">
                            <Form.Label>Nom</Form.Label>
                            <Form.Control
                                type="text"
                                name="nom"
                                ref={nameRef}
                                autoComplete="off"
                                onChange={handleChange}
                                value={carData.nom}
                                required
                            />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="prenom">
                            <Form.Label>Prénom</Form.Label>
                            <Form.Control
                                type="text"
                                name="prenom"
                                ref={prenomRef}
                                autoComplete="off"
                                onChange={handleChange}
                                value={carData.prenom}
                                required
                            />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="modele">
                            <Form.Label>Modèle</Form.Label>
                            <Form.Control
                                type="text"
                                name="modele"
                                ref={modeleRef}
                                autoComplete="off"
                                onChange={handleChange}
                                value={carData.modele}
                                required
                            />
                        </Form.Group>

                        <h3>Equipements</h3>
                        {equipementData.map((equipement, index) => (
                            <Form.Group key={index} className="mb-3">
                                <Form.Control
                                    type="text"
                                    value={equipement}
                                    onChange={(event) => handleDynamicFieldChange(setEquipementData, index, event)}
                                    placeholder={`Equipement ${index + 1}`}
                                />
                                <button
                                    variant="danger"
                                    type="button"
                                    onClick={() => handleRemoveDynamicField(setEquipementData, index)}
                                    className="mt-2 bouton-delete"
                                >
                                    Supprimer
                                </button>
                            </Form.Group>
                        ))}
                        <button className='bouton' type="button" onClick={() => handleAddDynamicField(setEquipementData)}>
                            Ajouter Equipement
                        </button>

                        <h3>Caractéristiques</h3>
                        {caracteristiqueData.map((caracteristique, index) => (
                            <Form.Group key={index} className="mb-3">
                                <Form.Control
                                    type="text"
                                    value={caracteristique}
                                    onChange={(event) => handleDynamicFieldChange(setCaracteristiqueData, index, event)}
                                    placeholder={`Caractéristique ${index + 1}`}
                                />
                                <button                                    
                                    type="button"
                                    onClick={() => handleRemoveDynamicField(setCaracteristiqueData, index)}
                                    className="mt-2 bouton-delete"
                                >
                                    Supprimer
                                </button>
                            </Form.Group>
                        ))}
                        <button className='bouton' type="button" onClick={() => handleAddDynamicField(setCaracteristiqueData)}>
                            Ajouter Caractéristique
                        </button>

                        <Form.Group className="mb-3" controlId="prix">
                            <Form.Label>Prix</Form.Label>
                            <Form.Control
                                type="number"
                                name="prix"
                                ref={prixRef}
                                autoComplete="off"
                                onChange={handleChange}
                                value={carData.prix}
                                required
                            />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="kilometrage">
                            <Form.Label>Kilométrage</Form.Label>
                            <Form.Control
                                type="number"
                                name="kilometrage"
                                ref={kilometrageRef}
                                autoComplete="off"
                                onChange={handleChange}
                                value={carData.kilometrage}
                                required
                            />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="annee_circulation">
                            <Form.Label>Année de circulation</Form.Label>
                            <Form.Control
                                type="number"
                                name="annee_circulation"
                                ref={anneeRef}
                                autoComplete="off"
                                onChange={handleChange}
                                value={carData.annee_circulation}
                                required
                            />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="numero">
                            <Form.Label>Numéro de téléphone</Form.Label>
                            <Form.Control
                                type="tel"
                                name="numero"
                                ref={numeroRef}
                                autoComplete="off"
                                onChange={handleChange}
                                value={carData.numero}
                                required
                            />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="image">
                            <Form.Label>Image</Form.Label>
                            <Form.Control
                                type="file"
                                name="image"
                                ref={imageRef}
                                accept=".jpeg, .png, .jpg"
                                onChange={handleImageUpload}
                                multiple
                                required
                            />
                        </Form.Group>

                        <button type="submit" className="bouton lienmt-3">
                            Envoyer
                        </button>
                    </Form>
                </>
            )}
        </Container>
    );
};

export default NewCar;
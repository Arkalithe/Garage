import React, { useRef, useState, useEffect } from 'react';
import config from '../../api/axios';
import { Link, useParams } from 'react-router-dom';
import { Form, Button } from 'react-bootstrap';

export const UpdateCar = ({ carId }) => {
    const errRef = useRef();
    const nameRef = useRef();
    const prenomRef = useRef();
    const modeleRef = useRef();
    const prixRef = useRef();
    const kilometrageRef = useRef();
    const anneeRef = useRef();
    const numeroRef = useRef();
    const imageRef = useRef();

    const { idVoiture } = useParams();
    ;

    const [isLoading, setLoading] = useState(true);
    const [voiture, setVoiture] = useState([]);

    const [err, setErr] = useState('');
    const [success, setSuccess] = useState(false);

    const car_update = `/Garage/php/Api/Car/CarUpdate.php`;
    const get_car = `/Garage/php/Api/Car/CarGetSingle.php`;

    useEffect(() => {
        fetchVoiture();
    }, []);

    const fetchVoiture = async () => {
        try {
            const res = await config.localTestingUrl.get(get_car, { params: { id: idVoiture } });
            const fetchedVoiture = res.data;
            if (Array.isArray(fetchedVoiture.caracteristique)) {
                fetchedVoiture.caracteristique = [...fetchedVoiture.caracteristique];
            } else {
                fetchedVoiture.caracteristique = fetchedVoiture.caracteristique || '';
            }
            if (Array.isArray(fetchedVoiture.equipement)) {
                fetchedVoiture.equipement = [...fetchedVoiture.equipement];
            } else {
                fetchedVoiture.equipement = fetchedVoiture.equipement || '';
            } if (!Array.isArray(fetchedVoiture.voiture_images)) {
                fetchedVoiture.voiture_images = fetchedVoiture.voiture_images ? [fetchedVoiture.voiture_images] : [];
            }

            setVoiture(fetchedVoiture);
            setLoading(false);
        } catch (err) {
           
        }
    };

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


        voiture.images.forEach((image, index) => {
            formData.append(`image_${index}`, image);
        });
        try {
            await config.localTestingUrl.post(car_update, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            setSuccess(true);
        } catch (err) {
            if (!err?.response) {
                setErr('No response from the server');

            } else if (err.response?.status === 422) {
                setErr('Validation error occurred');
         
            } else {
                setErr('An error occurred while updating the car');
      
            }
            errRef.current.focus();
        }
    };

    const handleChange = (event) => {
        const { name, value } = event.target;
        if (name.startsWith('equipement_')) {
            setVoiture((prevVoiture) => {
                const equipementIndex = Number(name.split('_')[1]);
                const updatedEquipement = Array.isArray(prevVoiture.equipement)
                    ? [...prevVoiture.equipement]
                    : [prevVoiture.equipement];
                updatedEquipement[equipementIndex] = value;
                return { ...prevVoiture, equipement: updatedEquipement };
            });
        } else if (name === 'equipement') {
            setVoiture((prevVoiture) => {
                const updatedEquipement = Array.isArray(prevVoiture.equipement)
                    ? [...prevVoiture.equipement]
                    : [];
                updatedEquipement[0] = value;
                return { ...prevVoiture, equipement: updatedEquipement };
            });
        } else {
            setVoiture((prevVoiture) => ({ ...prevVoiture, [name]: value }));
        }
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
    const handleAddEquipement = () => {
        setVoiture((prevVoiture) => {
            const updatedEquipement = Array.isArray(prevVoiture.equipement)
                ? [...prevVoiture.equipement, '']
                : [prevVoiture.equipement, ''];
            return { ...prevVoiture, equipement: updatedEquipement };
        });
    };

    const handleRemoveEquipement = (index) => {
        setVoiture((prevVoiture) => {
            const updatedEquipement = Array.isArray(prevVoiture.equipement)
                ? [...prevVoiture.equipement]
                : [prevVoiture.equipement];
            updatedEquipement.splice(index, 1);
            return { ...prevVoiture, equipement: updatedEquipement };
        });
    };

    const handleAddCaracteristique = () => {
        setVoiture((prevVoiture) => {
            const updatedCaracteristique = Array.isArray(prevVoiture.caracteristique)
                ? [...prevVoiture.caracteristique, '']
                : [prevVoiture.caracteristique, ''];
            return { ...prevVoiture, caracteristique: updatedCaracteristique };
        });
    };

    const handleRemoveCaracteristique = (index) => {
        setVoiture((prevVoiture) => {
            const updatedCaracteristique = Array.isArray(prevVoiture.caracteristique)
                ? [...prevVoiture.caracteristique]
                : [prevVoiture.caracteristique];
            updatedCaracteristique.splice(index, 1);
            return { ...prevVoiture, caracteristique: updatedCaracteristique };
        });
    };

    const handleRemoveImage = (index) => {
        setVoiture((prevVoiture) => {
            const updatedImages = [...prevVoiture.voiture_images];
            updatedImages.splice(index, 1);
            return { ...prevVoiture, voiture_images: updatedImages };
        });
    };
    if (isLoading) {
        return <div>Chargement</div>;
    }

    return (
        <>
            {success ? (
                <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
                    <h1 className="d-flex flex-column p-2 m-2">Car Updated</h1>
                    <p>
                        <Link to="/adminSpace" className="bouton lien">
                            Back to Admin Space
                        </Link>
                    </p>
                </section>
            ) : (
                <section className="form-cadre  align-items-center">
                    <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
                        {err}
                    </p>
                    <h1 className="d-flex flex-column p-1 m-2">Update Car</h1>
                    <div className='container-fluid d-flex'>
                        <div>
                            <Form className="d-flex flex-column p-2 m-2" onSubmit={handleSubmit} encType="multipart/form-data">
                                <Form.Group controlId="nom">
                                    <Form.Label>Nom:</Form.Label>
                                    <Form.Control
                                        type="text"
                                        name="nom"
                                        ref={nameRef}
                                        autoComplete="off"
                                        onChange={handleChange}
                                        value={voiture.nom}
                                        required
                                    />
                                </Form.Group>

                                <Form.Group controlId="prenom">
                                    <Form.Label>Prenom:</Form.Label>
                                    <Form.Control
                                        type="text"
                                        name="prenom"
                                        ref={prenomRef}
                                        autoComplete="off"
                                        onChange={handleChange}
                                        value={voiture.prenom}
                                        required
                                    />
                                </Form.Group>

                                <Form.Group controlId="modele">
                                    <Form.Label>Modele:</Form.Label>
                                    <Form.Control
                                        type="text"
                                        name="modele"
                                        ref={modeleRef}
                                        autoComplete="off"
                                        value={voiture.modele}
                                        onChange={handleChange}
                                        required
                                    />
                                </Form.Group>

                                <Form.Group controlId="prix">
                                    <Form.Label>Prix:</Form.Label>
                                    <Form.Control
                                        type="number"
                                        name="prix"
                                        ref={prixRef}
                                        autoComplete="off"
                                        value={voiture.prix}
                                        onChange={handleChange}
                                        required
                                    />
                                </Form.Group>

                                <Form.Group controlId="kilometrage">
                                    <Form.Label>Kilometrage:</Form.Label>
                                    <Form.Control
                                        type="number"
                                        name="kilometrage"
                                        ref={kilometrageRef}
                                        autoComplete="off"
                                        value={voiture.kilometrage}
                                        onChange={handleChange}
                                        required
                                    />
                                </Form.Group>

                                <Form.Group controlId="annee_circulation">
                                    <Form.Label>Annee mise en circulation:</Form.Label>
                                    <Form.Control
                                        type="number"
                                        name="annee_circulation"
                                        ref={anneeRef}
                                        autoComplete="off"
                                        value={voiture.annee_circulation}
                                        onChange={handleChange}
                                        required
                                    />
                                </Form.Group>

                                <Form.Group controlId="numero">
                                    <Form.Label>Numero de telephone:</Form.Label>
                                    <Form.Control
                                        type="tel"
                                        name="numero"
                                        ref={numeroRef}
                                        autoComplete="off"
                                        value={voiture.numero}
                                        onChange={handleChange}
                                        required
                                    />
                                </Form.Group>

                                <Form.Group controlId="image">
                                    <Form.Label>Image:</Form.Label>
                                    <Form.Control
                                        type="file"
                                        name="image"
                                        ref={imageRef}
                                        accept=".jpeg, .png, .jpg"
                                        onChange={handleImageUpload}
                                        multiple
                                    />
                                </Form.Group>

                                <div>
                                    <h3>Equipement:</h3>
                                    {Array.isArray(voiture.equipement) ? (
                                        voiture.equipement.map((equipement, index) => (
                                            <div key={index}>
                                                <Form.Control
                                                    type="text"
                                                    name={`equipement_${index}`}
                                                    value={equipement}
                                                    placeholder={`Equipement ${index + 1}`}
                                                    onChange={handleChange}
                                                />
                                                <Button
                                                    type="button"
                                                    onClick={() => handleRemoveEquipement(index)}
                                                    variant="danger"
                                                >
                                                    Supprimer
                                                </Button>
                                            </div>
                                        ))
                                    ) : (
                                        <div>
                                            <Form.Control
                                                type="text"
                                                name="equipement"
                                                value={voiture.equipement}
                                                placeholder="Equipement"
                                                onChange={handleChange}
                                            />
                                            <Button type="button" variant="danger">
                                                Supprimer
                                            </Button>
                                        </div>
                                    )}
                                    <Button type="button" onClick={handleAddEquipement} variant="success">
                                        Ajouter Equipement
                                    </Button>
                                </div>


                                <div>
                                    <h3>Caracteristique:</h3>
                                    {Array.isArray(voiture.caracteristique) ? (
                                        voiture.caracteristique.map((caracteristique, index) => (
                                            <div key={index}>
                                                <Form.Control
                                                    type="text"
                                                    name={`caracteristique_${index}`}
                                                    value={caracteristique}
                                                    placeholder={`caracteristique ${index + 1}`}
                                                    onChange={handleChange}
                                                />
                                                <Button
                                                    type="button"
                                                    onClick={() => handleRemoveCaracteristique(index)}
                                                    variant="danger"
                                                >
                                                    Supprimer
                                                </Button>
                                            </div>
                                        ))
                                    ) : (
                                        <div>
                                            <Form.Control
                                                type="text"
                                                name="caracteristique"
                                                value={voiture.caracteristique}
                                                placeholder="caracteristique"
                                                onChange={handleChange}
                                            />
                                            <Button type="button" variant="danger">
                                                Supprimer
                                            </Button>
                                        </div>
                                    )}
                                    <Button type="button" onClick={handleAddCaracteristique} variant="success">
                                        Ajouter caracteristique
                                    </Button>
                                </div>
                                <Button className="d-flex flex-column p-2 m-2 mt-3" type="submit">
                                    Modification.
                                </Button>
                            </Form>
                        </div>

                        <div className='container-fluid d-flex row align-items-center justify-content-end'>
                            {voiture.voiture_images.map((image, index) => (
                                <div key={index}>
                                    {image.length > 0 ? (
                                        <img
                                            className="img-fluid"
                                            style={{ width: "300px", height: "200px" }}
                                            src={require(`../../assests/Image/${image}`)}
                                            alt="voiture"
                                        />

                                    ) : (
                                        <div>No Image</div>
                                    )}

                                    <Button type="button" onClick={handleRemoveImage} variant="danger">
                                        Supprimer
                                    </Button>
                                </div>
                            ))}

                        </div>
                    </div>
                </section>
            )}
        </>
    );
};

export default UpdateCar;

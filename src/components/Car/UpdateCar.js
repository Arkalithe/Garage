import React, { useRef, useState, useEffect } from 'react';
import axios from '../../api/axios';
import { Link, useParams } from 'react-router-dom';


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
            const res = await axios.get(get_car, { params: { id: idVoiture } });
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
            const response = await axios.post(car_update, formData, {
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
                            <form className="d-flex flex-column p-2 m-2" onSubmit={handleSubmit} encType="multipart/form-data">
                                <label htmlFor="name">Nom:</label>
                                <input
                                    type="text"
                                    id="nom"
                                    name="nom"
                                    ref={nameRef}
                                    autoComplete="off"
                                    onChange={handleChange}
                                    value={voiture.nom}
                                    required
                                />

                                <label htmlFor="prenom">Prenom:</label>
                                <input
                                    type="text"
                                    id="prenom"
                                    name="prenom"
                                    ref={prenomRef}
                                    autoComplete="off"
                                    onChange={handleChange}
                                    value={voiture.prenom}
                                    required
                                />

                                <label htmlFor="modele">Modele:</label>
                                <input
                                    type="text"
                                    id="modele"
                                    ref={modeleRef}
                                    autoComplete="off"
                                    name="modele"
                                    value={voiture.modele}
                                    onChange={handleChange}
                                    required
                                />

                                <label htmlFor="prix">Prix:</label>
                                <input
                                    type="number"
                                    id="prix"
                                    ref={prixRef}
                                    autoComplete="off"
                                    name="prix"
                                    value={voiture.prix}
                                    onChange={handleChange}
                                    required
                                />

                                <label htmlFor="kilometrage">Kilometrage:</label>
                                <input
                                    type="number"
                                    id="kilometrage"
                                    ref={kilometrageRef}
                                    autoComplete="off"
                                    name="kilometrage"
                                    value={voiture.kilometrage}
                                    onChange={handleChange}
                                    required
                                />

                                <label htmlFor="annee">Annee mise en circulation:</label>
                                <input
                                    type="number"
                                    id="annee_circulation"
                                    ref={anneeRef}
                                    autoComplete="off"
                                    name="annee_circulation"
                                    value={voiture.annee_circulation}
                                    onChange={handleChange}
                                    required
                                />

                                <label htmlFor="numero">Numero de telephone:</label>
                                <input
                                    type="tel"
                                    id="numero"
                                    ref={numeroRef}
                                    autoComplete="off"
                                    name="numero"
                                    value={voiture.numero}
                                    onChange={handleChange}
                                    required
                                />

                                <label htmlFor="image_url">Image:</label>
                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    ref={imageRef}
                                    accept=".jpeg, .png, .jpg"
                                    onChange={handleImageUpload}
                                    multiple
                                />

                                <div>
                                    <h3>Equipement:</h3>
                                    {Array.isArray(voiture.equipement) ? (
                                        voiture.equipement.map((equipement, index) => (
                                            <div key={index}>
                                                <input
                                                    type="text"
                                                    name={`equipement_${index}`}
                                                    value={equipement}
                                                    placeholder={`Equipement ${index + 1}`}
                                                    onChange={handleChange}
                                                />
                                                <button
                                                    type="button"
                                                    onClick={() => handleRemoveEquipement(index)}
                                                    className="bouton-delete-alt"
                                                >
                                                    Supprimer
                                                </button>
                                            </div>
                                        ))
                                    ) : (
                                        <div>
                                            <input
                                                type="text"
                                                name="equipement"
                                                value={voiture.equipement}
                                                placeholder="Equipement"
                                                onChange={handleChange}
                                            />
                                            <button type="button" className="bouton-delete-alt">
                                                Supprimer
                                            </button>
                                        </div>
                                    )}
                                    <button type="button" onClick={handleAddEquipement} className="bouton-alt">
                                        Ajouter Equipement
                                    </button>
                                </div>


                                <div>
                                    <h3>Caracteristique:</h3>
                                    {Array.isArray(voiture.caracteristique) ? (
                                        voiture.caracteristique.map((caracteristique, index) => (
                                            <div key={index}>
                                                <input
                                                    type="text"
                                                    name={`caracteristique_${index}`}
                                                    value={caracteristique}
                                                    placeholder={`caracteristique ${index + 1}`}
                                                    onChange={handleChange}
                                                />
                                                <button
                                                    type="button"
                                                    onClick={() => handleRemoveCaracteristique(index)}
                                                    className="bouton-delete-alt"
                                                >
                                                    Supprimer
                                                </button>
                                            </div>
                                        ))
                                    ) : (
                                        <div>
                                            <input
                                                type="text"
                                                name="caracteristique"
                                                value={voiture.caracteristique}
                                                placeholder="caracteristique"
                                                onChange={handleChange}
                                            />
                                            <button type="button" className="bouton-delete-alt">
                                                Supprimer
                                            </button>
                                        </div>
                                    )}
                                    <button type="button" onClick={handleAddCaracteristique} className="bouton-alt">
                                        Ajouter caracteristique
                                    </button>
                                </div>
                                <button className="d-flex flex-column p-2 m-2 mt-3 bouton" type="submit">
                                    Modification.
                                </button>
                            </form>
                        </div>

                        <div className='container-fluid d-flex row align-items-center justify-content-end'>
                            {voiture.voiture_images.map((image, index) => (
                                <div>
                                    {image.length > 0 ? (
                                        <img
                                            key={index}
                                            className="img-fluid"
                                            style={{ width: "300px", height: "200px" }}
                                            src={require(`../../assests/Image/${image}`)}
                                            alt="voiture"
                                        />

                                    ) : (
                                        <div>No Image</div>
                                    )}

                                    <button type="button" onClick={handleRemoveImage} className="bouton-delete-alt">
                                        Supprimer
                                    </button>
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

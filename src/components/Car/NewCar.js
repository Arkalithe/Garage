import React, { useRef, useState } from 'react'
import axios from '../../api/axios';
import { Link } from 'react-router-dom';





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

    const Car_url = '/Garage/php/Api/Car/CarCreate.php'



    const handleSubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('nom', carData.nom);
        formData.append('prenom', carData.prenom);
        formData.append('modele', carData.modele);
        formData.append('prix', carData.prix);
        formData.append('kilometrage', carData.kilometrage);
        formData.append('annee_circulation', carData.annee_circulation);
        formData.append('numero', carData.numero);
        formData.append('image', carData.image);

        equipementData.forEach((equipement, index) => {
            formData.append(`equipement_${index}`, equipement);
        });

        caracteristiqueData.forEach((caracteristique, index) => {
            formData.append(`caracteristique_${index}`, caracteristique);
        });

        carData.images.forEach((image, index) => {
            formData.append(`image_${index}`, image);
          });

        try {
            const response = await axios.post(
                Car_url,
                formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            console.log(response)
            console.log(formData)
            console.log(response?.data)

            setSuccess(true);


        } catch (err) {
            if (!err?.response) {
                setErr('Pas de reponse serveur');
                console.log(err.response?.data)
            } else if (err.response?.status === 422) {
                setErr()
                console.log(err.response?.data)
            } else {
                setErr()
                console.log(err.response?.data)
            }
            errRef.current.focus()
        }

    }

    const handleChange = (event) => {
        const { name, value } = event.target;
        setCarData({ ...carData, [name]: value });
    };

    const handleImageUpload = (event) => {
        const files = event.target.files;
        const uploadedImages = [];
      
        for (let i = 0; i < files.length; i++) {
          const file = files[i];
          uploadedImages.push(file);
        }
      
        setCarData({ ...carData, images: uploadedImages });
      };

    const handleEquipementChange = (index, event) => {
        const { value } = event.target;
        setEquipementData((prevData) => {
            const updatedData = [...prevData];
            updatedData[index] = value;
            return updatedData;
        });
    };

    const handleAddEquipementField = () => {
        setEquipementData((prevData) => [...prevData, '']);
    };

    const handleRemoveEquipementField = (index) => {
        setEquipementData((prevData) => {
            const updatedData = [...prevData];
            updatedData.splice(index, 1);
            return updatedData;
        });
    };

    const handleCaracteristiqueChange = (index, event) => {
        const { value } = event.target;
        setCaracteristiqueData((prevData) => {
            const updatedData = [...prevData];
            updatedData[index] = value;
            return updatedData;
        });
    };

    const handleAddCaracteristiqueField = () => {
        setCaracteristiqueData((prevData) => [...prevData, '']);
    };

    const handleRemoveCaracteristiqueField = (index) => {
        setCaracteristiqueData((prevData) => {
            const updatedData = [...prevData];
            updatedData.splice(index, 1);
            return updatedData;
        });
    };

    return (
        <>{success ? (
            <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
                <h1 className="d-flex flex-column p-2 m-2">Voiture Ajouté</h1>
                <p >
                    <Link to="/adminSpace" className="bouton lien"> Retour Acceuil  </Link>
                </p>
            </section>
        ) : (
            <section className="form-cadre d-flex flex-column align-items-center">
                <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
                    {err}
                </p>

                <h1 className='d-flex flex-column p-1 m-2'> Voiture. </h1>

                <form className='d-flex flex-column p-2 m-2' onSubmit={handleSubmit} encType="multipart/form-data">
                    <label htmlFor="name">
                        Nom :
                    </label>
                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        ref={nameRef}
                        autoComplete="off"
                        onChange={handleChange}
                        value={carData.nom}
                        required
                    />
                    <label htmlFor="prenom">
                        Prenom :
                    </label>
                    <input
                        type="text"
                        id="prenom"
                        name="prenom"
                        ref={prenomRef}
                        autoComplete="off"
                        onChange={handleChange}
                        value={carData.prenom}
                        required
                    />
                    <label htmlFor="modele">
                        Modele :
                    </label>
                    <input
                        type="text"
                        id="modele"
                        ref={modeleRef}
                        autoComplete="off"
                        name="modele"
                        value={carData.modele}
                        onChange={handleChange}
                        required
                    />
                    <div>
                        <h3>Equipement :</h3>
                        {equipementData.map((equipement, index) => (
                            <div key={index}>
                                <input
                                    type="text"
                                    value={equipement}
                                    onChange={(event) => handleEquipementChange(index, event)}
                                    placeholder={`Equipement ${index + 1}`}
                                />
                                <button
                                    type="button"
                                    onClick={() => handleRemoveEquipementField(index)}
                                    className='bouton-delete-alt'
                                >
                                    Supprimer
                                </button>
                            </div>
                        ))}
                        <button type="button" className='bouton-alt' onClick={handleAddEquipementField}>
                            Ajoute Equipement
                        </button>
                    </div>
                    <div>
                        <h3>Caracteristique :</h3>
                        {caracteristiqueData.map((caracteristique, index) => (
                            <div key={index}>
                                <input
                                    type="text"
                                    value={caracteristique}
                                    onChange={(event) => handleCaracteristiqueChange(index, event)}
                                    placeholder={`Caracteristique ${index + 1}`}
                                />
                                <button
                                    type="button"
                                    onClick={() => handleRemoveCaracteristiqueField(index)}
                                    className='bouton-delete-alt'
                                >
                                    Supprimer
                                </button>
                            </div>
                        ))}
                        <button type="button" className='bouton-alt' onClick={handleAddCaracteristiqueField}>
                            Ajoute Caracteristique
                        </button>
                    </div>
                    <label htmlFor="prix">
                        Prix :
                    </label>
                    <input
                        type="number"
                        id="prix"
                        ref={prixRef}
                        autoComplete="off"
                        name="prix"
                        value={carData.prix}
                        onChange={handleChange}
                        required
                    />
                    <label htmlFor="kilometrage">
                        Kilometrage :
                    </label>
                    <input
                        type="number"
                        id="kilometrage"
                        ref={kilometrageRef}
                        autoComplete="off"
                        name="kilometrage"
                        value={carData.kilometrage}
                        onChange={handleChange}
                        required
                    />
                    <label htmlFor="annee">
                        Annee de circulation :
                    </label>
                    <input
                        type="number"
                        id="annee_circulation"
                        ref={anneeRef}
                        autoComplete="off"
                        name="annee_circulation"
                        value={carData.annee_circulation}
                        onChange={handleChange}
                        required
                    />
                    <label htmlFor="numero">
                        Numero de telephone :
                    </label>
                    <input
                        type="Tel"
                        id="numero"
                        ref={numeroRef}
                        autoComplete="off"
                        name='numero'
                        value={carData.numero}
                        onChange={handleChange}
                        required
                    />
                    <label htmlFor="image_url">Image :</label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        ref={imageRef}
                        accept=".jpeg, .png, .jpg"
                        onChange={handleImageUpload}
                        multiple
                        required
                    />

                    <button className='d-flex flex-column p-2 m-2 mt-3 bouton'>
                        Envoyer
                    </button>
                </form>
            </section>
        )}
        </>

    )
}


export default NewCar
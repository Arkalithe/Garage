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




    const [name, setName] = useState("");
    const [prenom, setPrenom] = useState("");
    const [modele, setModele] = useState("");
    const [prix, setPrix] = useState(0);
    const [kilometrage, setKilometrage] = useState(0);
    const [annee, setAnnee] = useState(0);
    const [numero, setNumero] = useState(0);
    const [image_url, setImage_url] = useState(null);

    const [err, setErr] = useState('');
    const [success, setSuccess] = useState(false);

    const Car_url = '/Garage/php/Api/Car/CarCreate.php'



    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const formData = new FormData();
            formData.append('name', name);
            formData.append('prenom', prenom);
            formData.append('modele', modele);
            formData.append('prix', prix);
            formData.append('kilometrage', kilometrage);
            formData.append('annee', annee);
            formData.append('numero', numero);
            formData.append('image_url', image_url);
            const response = await axios.post(Car_url, formData, {
                headers: {
                    'Content-Type' :'multipart/form-data',
                },
            });

            console.log(response?.data)


            setSuccess(true);
            setName('');
            setPrenom('');
            setModele('');
            setKilometrage(0);
            setNumero(0);
            setAnnee(0);
            setPrix(0);
            setImage_url(null);

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

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        setImage_url(file);
      };

    return (
        <>{success ? (
            <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
                <h1 className="d-flex flex-column p-2 m-2">Voiture Ajouté</h1>
                <p >
                    <Link to="/" className="bouton lien"> Retour Acceuil  </Link>
                </p>
            </section>
        ) : (
            <section className="form-cadre d-flex flex-column align-items-center">
                <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
                    {err}
                </p>

                <h1 className='d-flex flex-column p-1 m-2'> Voiture. </h1>
                <form className='d-flex flex-column p-2 m-2' onSubmit={handleSubmit}>
                    <label htmlFor="name">
                        Nom :
                    </label>
                    <input
                        type="text"
                        id="name"
                        ref={nameRef}
                        autoComplete="off"
                        onChange={(e) => setName(e.target.value)}
                        value={name}
                        required
                    />
                    <label htmlFor="prenom">
                        Prenom :
                    </label>
                    <input
                        type="text"
                        id="Prenom"
                        ref={prenomRef}
                        autoComplete="off"
                        onChange={(e) => setPrenom(e.target.value)}
                        value={prenom}
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
                        onChange={(e) => setModele(e.target.value)}
                        value={modele}
                        required
                    />
                    <label htmlFor="prix">
                        Prix :
                    </label>
                    <input
                        type="number"
                        id="prix"
                        ref={prixRef}
                        autoComplete="off"
                        onChange={(e) => setPrix(e.target.value)}
                        value={prix}
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
                        onChange={(e) => setKilometrage(e.target.value)}
                        value={kilometrage}
                        required
                    />
                    <label htmlFor="annee">
                        Annee de circulation :
                    </label>
                    <input
                        type="number"
                        id="annee"
                        ref={anneeRef}
                        autoComplete="off"
                        onChange={(e) => setAnnee(e.target.value)}
                        value={annee}
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
                        onChange={(e) => setNumero(e.target.value)}
                        value={numero}
                        required
                    />
                    <label htmlFor="image">Image:</label>
                    <input
                        type="file"
                        id="image"
                        ref={imageRef}
                        accept="image/*"
                        onChange={handleImageChange}
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
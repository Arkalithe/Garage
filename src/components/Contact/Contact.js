import React, { useState } from 'react';
import axios from '../../api/axios';

export const Contact = ({ car }) => {

    const [mailSetting, setMailSetting] = useState({
        nom: '',
        prenom: '',
        email: '',
        phone: '',
        message: '',
        modele: '',
        prix: '',
        nomProprietaire: '',
        prenomProprietaire: '',
    });

    const url_email = '/Garage/php/Api/Email.php'

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            const formData = new FormData();
            formData.append('nom', mailSetting.nom);
            formData.append('prenom', mailSetting.prenom);
            formData.append('email', mailSetting.email);
            formData.append('phone', mailSetting.phone);
            formData.append('message', mailSetting.message);
            formData.append('modele', car.modele);
            formData.append('prix', car.prix);
            formData.append('nomProprietaire', car.nom);
            formData.append('prenomProprietaire', car.prenom);
           

            await axios.post(url_email, formData ,{
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

            alert('Email sent successfully!');
        } catch (error) {
            console.error('Error sending email:', error);
            alert('Failed to send email. Please try again later.');
        }
    };
    const handleChange = (event) => {
        const { name, value } = event.target;
        setMailSetting({ ...mailSetting, [name]: value });
    };

    return (
        <div className="container">
            <div className="row">
                <div className="">
                    <form
                        className="p-2 m-2"
                        onSubmit={handleSubmit}
                    >
                        <div className="form-group">
                            <label htmlFor="nom">Nom:</label>
                            <input
                                type="text"
                                id="nom"
                                name='nom'
                                className="form-control"
                                autoComplete="off"
                                onChange={handleChange}
                                value={mailSetting.nom}
                                required
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="prenom">Prenom:</label>
                            <input
                                type="text"
                                id="prenom"
                                name='prenom'
                                className="form-control"
                                autoComplete="off"
                                onChange={handleChange}
                                value={mailSetting.prenom}
                                required
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="email">Adresse-mail:</label>
                            <input
                                type="email"
                                id="email"
                                name='email'
                                className="form-control"
                                autoComplete="off"
                                onChange={handleChange}
                                value={mailSetting.email}
                                required
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="phone">Numéro de téléphone:</label>
                            <input
                                type="tel"
                                id="phone"
                                name='phone'
                                className="form-control"
                                autoComplete="off"
                                onChange={handleChange}
                                value={mailSetting.phone}
                                required
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="message">Message:</label>
                            <textarea
                                id="message"
                                name='message'
                                className="form-control"
                                autoComplete="off"
                                onChange={handleChange}
                                value={mailSetting.message}
                                required
                            />
                        </div>

                        <div className="car-information p-2 m-2 d-flex flex-column align-items-center">
                            <label htmlFor="idCar">
                                <input type="hidden" id="idCar" value={car.id} required />
                                <h3>Car Information:</h3>
                            </label>

                            <div className='d-flex'>
                                <p>Model:</p>
                                <div className='mx-1' name="modele" >{car.modele}
                                </div>
                            </div>
                            <div className='d-flex'>
                                <p>Price:</p>
                                <div className='mx-1' name="prix">{car.prix}
                                </div>
                            </div>
                            <div className='d-flex'>
                                <p>Proprietaire:
                                </p>
                                <div className='mx-1' name="nomProprietaire"> {car.nom}
                                </div>
                                <div name="prenomProprietaire">{car.prenom}
                                </div>
                            </div>

                        </div>

                        <div className="form-group">
                            <button type="submit" className="bouton">
                                Envoyez Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

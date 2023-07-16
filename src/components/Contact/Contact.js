import React, { useRef, useState } from 'react';
import axios from '../../api/axios';

export const Contact = (car) => {
    const nameRef = useRef();

    const [name, setName] = useState("");
    const [prenom, setPrenom] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");
    const [message, setMessage] = useState("");

    const url_email = '/Garage/php/Api/Email.php'

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {

            await axios.post(url_email, {
                name,
                prenom,
                email,
                phone,
                message,
                car: car.data,
            });

            setName("");
            setPrenom("");
            setEmail("");
            setPhone("");
            setMessage("");

            alert('Email sent successfully!');
        } catch (error) {
            console.error('Error sending email:', error);
            alert('Failed to send email. Please try again later.');
        }
    };

    return (
        <div className="container">
            <div className="row">
                <div className="">
                    <form
                        className="p-2 m-2"
                        action=''
                    >
                        <div className="form-group">
                            <label htmlFor="name">Nom:</label>
                            <input
                                type="text"
                                id="name"
                                ref={nameRef}
                                className="form-control"
                                autoComplete="off"
                                onChange={(e) => setName(e.target.value)}
                                value={name}
                                required
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="prenom">Prenom:</label>
                            <input
                                type="text"
                                id="prenom"
                                className="form-control"
                                autoComplete="off"
                                onChange={(e) => setPrenom(e.target.value)}
                                value={prenom}
                                required
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="email">Adresse-mail:</label>
                            <input
                                type="email"
                                id="email"
                                className="form-control"
                                autoComplete="off"
                                onChange={(e) => setEmail(e.target.value)}
                                value={email}
                                required
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="phone">Numéro de téléphone:</label>
                            <input
                                type="tel"
                                id="phone"
                                className="form-control"
                                autoComplete="off"
                                onChange={(e) => setPhone(e.target.value)}
                                value={phone}
                                required
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="message">Message:</label>
                            <textarea
                                id="message"
                                className="form-control"
                                autoComplete="off"
                                onChange={(e) => setMessage(e.target.value)}
                                value={message}
                                required
                            />
                        </div>

                        <div className="car-information p-2 m-2 d-flex flex-column align-items-center">
                            <label htmlFor="idCar">
                                <input type="hidden" id="idCar" value={car.data} required />
                                <h3>Car Information:</h3>
                            </label>

                            <p>Model: {car.data.modele}</p>
                            <p>Price: {car.data.prix}</p>
                            <p>
                                Proprietaire: {car.data.nom} {car.data.prenom}
                            </p>
                            <div>
                                <img
                                    src={require(`../../assests/Image/${car.data.voiture_images[0]}`)}
                                    alt="voiture"
                                    className="img-fluid"
                                    style={{ maxWidth: '100%' }}
                                />
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

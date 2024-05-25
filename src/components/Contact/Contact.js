import React, { useState } from 'react';
import config from '../../api/axios';
import { Form, Button } from 'react-bootstrap';

export const Contact = ({ car }) => {
    const [mailSetting, setMailSetting] = useState({
        nom: '',
        prenom: '',
        email: '',
        phone: '',
        message: '',
    });

    const url_email = '/Garage/php/Api/Email.php';

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

            await config.localTestingUrl.post(url_email, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            alert('Envoie du mail reussie');
            setMailSetting({
                nom: '',
                prenom: '',
                email: '',
                phone: '',
                message: '',
            });
        } catch (error) {
            console.error('Erreur envoie du mail:', error);
            alert('Erreur envoie du mail. Essayer plus tard.');
        }
    };

    const handleChange = (event) => {
        const { name, value } = event.target;
        setMailSetting({ ...mailSetting, [name]: value });
    };

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div >
                    <Form onSubmit={handleSubmit}>
                        <Form.Group controlId="nom">
                            <Form.Label>Nom:</Form.Label>
                            <Form.Control
                                type="text"
                                name="nom"
                                value={mailSetting.nom}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Form.Group controlId="prenom">
                            <Form.Label>Prénom:</Form.Label>
                            <Form.Control
                                type="text"
                                name="prenom"
                                value={mailSetting.prenom}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Form.Group controlId="email">
                            <Form.Label>Adresse-mail:</Form.Label>
                            <Form.Control
                                type="email"
                                name="email"
                                value={mailSetting.email}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Form.Group controlId="phone">
                            <Form.Label>Numéro de téléphone:</Form.Label>
                            <Form.Control
                                type="tel"
                                name="phone"
                                value={mailSetting.phone}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Form.Group controlId="message">
                            <Form.Label>Message:</Form.Label>
                            <Form.Control
                                as="textarea"
                                name="message"
                                rows={3}
                                value={mailSetting.message}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Form.Group className='mt-3'>
                            <button type="submit" className='bouton bouton-lien'>
                                Envoyer Email
                            </button>
                        </Form.Group>
                    </Form>
                </div>
            </div>
        </div>
    );
};

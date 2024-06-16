import React from 'react';
import { Form } from 'react-bootstrap';

const BasicInfoForm = ({ voiture, handleChange }) => {
    return (
        <>
            <Form.Group controlId="nom">
                <Form.Label>Nom:</Form.Label>
                <Form.Control
                    type="text"
                    name="nom"
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
                    autoComplete="off"
                    value={voiture.prix}
                    onChange={handleChange}
                    required
                />
            </Form.Group>

            <Form.Group controlId="kilometrage">
                <Form.Label>Kilométrage:</Form.Label>
                <Form.Control
                    type="number"
                    name="kilometrage"
                    autoComplete="off"
                    value={voiture.kilometrage}
                    onChange={handleChange}
                    required
                />
            </Form.Group>

            <Form.Group controlId="annee_circulation">
                <Form.Label>Année mise en circulation:</Form.Label>
                <Form.Control
                    type="number"
                    name="annee_circulation"
                    autoComplete="off"
                    value={voiture.annee_circulation}
                    onChange={handleChange}
                    required
                />
            </Form.Group>

            <Form.Group controlId="numero">
                <Form.Label>Numéro de téléphone:</Form.Label>
                <Form.Control
                    type="tel"
                    name="numero"
                    autoComplete="off"
                    value={voiture.numero}
                    onChange={handleChange}
                    required
                />
            </Form.Group>
        </>
    );
};

export default BasicInfoForm;

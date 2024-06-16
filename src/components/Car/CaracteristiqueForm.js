import React from 'react';
import { Form, Button } from 'react-bootstrap';

const CaracteristiqueForm = ({ voiture, handleChange, setVoiture }) => {
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

    return (
        <div>
            <h3>Caractéristique:</h3>
            {Array.isArray(voiture.caracteristique) ? (
                voiture.caracteristique.map((caracteristique, index) => (
                    <div key={index}>
                        <Form.Control
                            type="text"
                            name={`caracteristique_${index}`}
                            value={caracteristique}
                            placeholder={`Caractéristique ${index + 1}`}
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
                        placeholder="Caractéristique"
                        onChange={handleChange}
                    />
                    <Button type="button" variant="danger">
                        Supprimer
                    </Button>
                </div>
            )}
            <Button type="button" onClick={handleAddCaracteristique} variant="success">
                Ajouter Caractéristique
            </Button>
        </div>
    );
};

export default CaracteristiqueForm;

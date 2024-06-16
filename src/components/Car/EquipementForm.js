import React from 'react';
import { Form, Button } from 'react-bootstrap';

const EquipementForm = ({ voiture, handleChange, setVoiture }) => {
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

    return (
        <div>
            <h3>Équipement:</h3>
            {Array.isArray(voiture.equipement) ? (
                voiture.equipement.map((equipement, index) => (
                    <div key={index}>
                        <Form.Control
                            type="text"
                            name={`equipement_${index}`}
                            value={equipement}
                            placeholder={`Équipement ${index + 1}`}
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
                        placeholder="Équipement"
                        onChange={handleChange}
                    />
                    <Button type="button" variant="danger">
                        Supprimer
                    </Button>
                </div>
            )}
            <Button type="button" onClick={handleAddEquipement} variant="success">
                Ajouter Équipement
            </Button>
        </div>
    );
};

export default EquipementForm;

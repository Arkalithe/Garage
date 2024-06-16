import React from 'react';
import { Button } from 'react-bootstrap';

const ImageGallery = ({ voiture, setVoiture }) => {
    const handleRemoveImage = (index) => {
        setVoiture((prevVoiture) => {
            const updatedImages = [...prevVoiture.voiture_images];
            updatedImages.splice(index, 1);
            return { ...prevVoiture, voiture_images: updatedImages };
        });
    };

    return (
        <div className="container-fluid d-flex row align-items-center justify-content-end">
            {voiture.voiture_images && voiture.voiture_images.length > 0 ? (
                voiture.voiture_images.map((image, index) => (
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

                        <Button type="button" onClick={() => handleRemoveImage(index)} variant="danger">
                            Supprimer
                        </Button>
                    </div>
                ))
            ) : (
                <div>No Images</div>
            )}
        </div>
    );
};

export default ImageGallery;

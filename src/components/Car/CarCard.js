import React from 'react'
import { Link } from "react-router-dom";

const CarCard = ({ car }) => {
    const carImages = car.voiture_images ? car.voiture_images.split(",") : [];
    return (
      <div className="voit card m-3">
        <div className="card-body d-flex flex-column align-items-start">
          <div className="image-container align-self-center p-1">
            {carImages.length > 0 ? (
              <img
                src={require(`../../assests/Image/${carImages[0]}`)}
                alt="cars"
                className="img-fluid"
              />
            ) : (
              <div>No Image</div>
            )}
          </div>
          <div className="ps-2">{car.modele}</div>
          <div className="ps-2">Année: {car.annee_circulation}</div>
          <div className="ps-2">Kilométrage: {car.kilometrage} Km</div>
          <div className="ps-2">Prix: {car.prix} €</div>
          <div className="mt-auto w-100 d-flex justify-content-center">
            <Link className="mt-2 bouton bouton-lien" to={`/Voiture/${car.id}`}>
              Plus d'information
            </Link>
          </div>
        </div>
      </div>
    );
  };
  
  export default CarCard;
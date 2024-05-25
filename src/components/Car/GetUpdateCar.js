import React, { useRef, useState, useEffect } from 'react';
import config from '../../api/axios';
import { Link, useParams } from 'react-router-dom';


export const GetUpdateCar = () => {
    const { idVoiture } = useParams();
    const errRef = useRef();

    const [isLoading, setLoading] = useState(true);
    const [carData, setCarData] = useState([]);

    const [err, setErr] = useState('');
    const [success, setSuccess] = useState(false);
    const get_car = `/Garage/php/Api/Car/CarRead.php`;

    useEffect(() => {
        const fetchVoiture = async () => {
            try {
                const res = await config.localTestingUrl.get(get_car, { params: { id: idVoiture } });
                const car = res.data;
                setCarData(car);
                setLoading(false);
            } catch (err) {
                setLoading(false);
            }
        };
        fetchVoiture();
    }, [get_car, idVoiture]);


    const uniqueCars = Array.from(new Set(carData.map(car => car.id)))
        .map(id => carData.find(car => car.id === id));

    if (isLoading) {
        return <div>Chargement de la page ...</div>;
    }

        const cars = uniqueCars.map((car) => {
            let carImages = [];
            if(car.voiture_images) {
               carImages = car.voiture_images.split(",");
            }
            if (isLoading){
               <div>Chargement de la page ...</div>
            }



        return (
            <div
                className="voit d-flex flex-column align-items-start m-3 px-1 flex-grow-0"
                key={car.id}
            >
                <div className="image-container align-self-center p-1">
                    {carImages.length > 0 ? (
                        <img
                            src={require(`../../assests/Image/${carImages[0]}`)}
                            alt="cars"
                            className="align-self-center py-3 img-fluid"
                            style={{ width: "300px", height: "200px" }}
                        />
                    ) : (
                        <div>No Image</div>
                    )}
                </div>
                <div>Nom: {carData.nom}</div>
                <div>Prenom: {carData.prenom}</div>
                <div>Modele: {carData.modele}</div>
                <div className="ps-2">{car.modele}</div>
                <div className="ps-2">Année: {car.annee_circulation}</div>
                <div className="ps-2">Kilométrage: {car.kilometrage} Km</div>
                <div className="ps-2">Prix: {car.prix} €</div>
                <Link className="align-self-center bouton bouton-lien" to={`/updateVoiture/${car.id}`}>
                    Plus d'information
                </Link>
            </div>
        );
    });

    return (
        <>
            {success ? (
                <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
                    <h1 className="d-flex flex-column p-2 m-2">Car Updated</h1>
                    <p>
                        <Link to="/adminSpace" className="bouton lien">
                            Back to Admin Space
                        </Link>
                    </p>
                </section>
            ) : (
                <section className="d-flex flex-column">
                    <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
                        {err}
                    </p>
                    <h1 className="d-flex flex-column p-1 m-2">Update Car</h1>
                    <div className='d-flex flex-wrap justify-content-center'>
                        {cars.length > 0 ? (
                            cars
                        ) : (
                            <h1 className="m-auto">Aucune voiture correspond à vos critères</h1>
                        )}
                    </div>
                </section>
            )}
        </>
    );
};

export default GetUpdateCar;

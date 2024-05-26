import React, { useRef, useState, useEffect } from 'react';
import config from '../../api/axios';
import { Link, useParams } from 'react-router-dom';
import Pagination from './Pagination';
import CarSlider from './CarSlider';

export const GetUpdateCar = () => {
    const { idVoiture } = useParams();
    const errRef = useRef();

    const [isLoading, setLoading] = useState(true);
    const [carData, setCarData] = useState([]);
    const [err, setErr] = useState('');
    const [success, setSuccess] = useState(false);

    const maxYear = new Date().getFullYear();
    const minPrice = 0;
    const maxPrice = 25000;
    const minKilo = 0;
    const maxKilo = 300000;

    const [currentPage, setCurrentPage] = useState(1);
    const carsPerPage = 5;

    const [priceRangeValue, setPriceRangeValue] = useState([minPrice, maxPrice]);
    const [yearRangeValue, setYearRangeValue] = useState([1960, maxYear]);
    const [kiloRangeValue, setKiloRangeValue] = useState([minKilo, maxKilo]);

    const priceChange = (event, newValue) => setPriceRangeValue(newValue);
    const yearChange = (event, newValue) => setYearRangeValue(newValue);
    const kiloChange = (event, newValue) => setKiloRangeValue(newValue);

    const get_car = `/Garage/php/Api/Car/CarRead.php`;

    useEffect(() => {
        const fetchVoiture = async () => {
            try {
                const res = await config.localTestingUrl.get(get_car, { params: { id: idVoiture } });
                setCarData(res.data);
            } catch (err) {
                setErr('Erreur récupération données voiture');
            } finally {
                setLoading(false);
            }
        };
        fetchVoiture();
    }, [get_car, idVoiture]);

    const resetPriceRange = () => setPriceRangeValue([minPrice, maxPrice]);
    const resetYearRange = () => setYearRangeValue([1960, maxYear]);
    const resetKiloRange = () => setKiloRangeValue([minKilo, maxKilo]);

    const filteredCars = carData.filter((car) => {
        const carPrice = parseFloat(car.prix);
        const carYear = parseInt(car.annee_circulation);
        const carMileage = parseInt(car.kilometrage);
        return (
            carPrice >= priceRangeValue[0] &&
            carPrice <= priceRangeValue[1] &&
            carYear >= yearRangeValue[0] &&
            carYear <= yearRangeValue[1] &&
            carMileage >= kiloRangeValue[0] &&
            carMileage <= kiloRangeValue[1]
        );
    });

    const uniqueCars = Array.from(new Set(filteredCars.map(car => car.id)))
        .map(id => filteredCars.find(car => car.id === id));

    const totalPages = Math.ceil(uniqueCars.length / carsPerPage);

    const indexOfLastCar = currentPage * carsPerPage;
    const indexOfFirstCar = indexOfLastCar - carsPerPage;
    const currentCars = uniqueCars.slice(indexOfFirstCar, indexOfLastCar);

    const handlePreviousPage = () => {
        setCurrentPage((prevPage) => Math.max(prevPage - 1, 1));
    };

    const handleNextPage = () => {
        setCurrentPage((prevPage) => Math.min(prevPage + 1, totalPages));
    };

    if (isLoading) {
        return <div>Chargement de la page ...</div>;
    }

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
                <>
                    <section className="d-flex flex-column my-2" style={{ width: "100%" }}>
                        <CarSlider
                            label="Prix"
                            value={priceRangeValue}
                            onChange={priceChange}
                            min={minPrice}
                            max={maxPrice}
                            resetFunc={resetPriceRange}
                        />
                        <CarSlider
                            label="Année"
                            value={yearRangeValue}
                            onChange={yearChange}
                            min={1960}
                            max={maxYear}
                            resetFunc={resetYearRange}
                        />
                        <CarSlider
                            label="Kilométrage"
                            value={kiloRangeValue}
                            onChange={kiloChange}
                            min={minKilo}
                            max={maxKilo}
                            resetFunc={resetKiloRange}
                        />
                    </section>

                    <section className="d-flex flex-column">
                        <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
                            {err}
                        </p>
                        <h1 className="d-flex flex-column p-1 m-2">Update Car</h1>
                        <div className='d-flex flex-wrap justify-content-center'>
                            {currentCars.length > 0 ? (
                                currentCars.map((car) => {
                                    const carImages = car.voiture_images ? car.voiture_images.split(",") : [];

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
                                            <div>Nom: {car.nom}</div>
                                            <div>Prenom: {car.prenom}</div>
                                            <div>Modele: {car.modele}</div>
                                            <div className="ps-2">Année: {car.annee_circulation}</div>
                                            <div className="ps-2">Kilométrage: {car.kilometrage} Km</div>
                                            <div className="ps-2">Prix: {car.prix} €</div>
                                            <Link className="align-self-center bouton bouton-lien" to={`/updateVoiture/${car.id}`}>
                                                Plus d'information
                                            </Link>
                                        </div>
                                    );
                                })
                            ) : (
                                <h1 className="m-auto">Aucune voiture correspond à vos critères</h1>
                            )}
                        </div>
                        <Pagination
                            currentPage={currentPage}
                            totalPages={totalPages}
                            onPreviousPage={handlePreviousPage}
                            onNextPage={handleNextPage}
                        />
                    </section>

                    <section className='d-flex justify-content-center mt-auto'>
                        <div className="d-flex justify-content-center mt-auto">
                            <Link to="/adminSpace" className="bouton lien">
                                Retour à l'espace Admin
                            </Link>
                        </div>
                    </section>
                </>
            )}
        </>
    );
};

export default GetUpdateCar;

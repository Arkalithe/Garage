import React from "react";
import { useState, useEffect } from "react";
import axios from "../../api/axios";
import { Link } from "react-router-dom";
import { Slider } from "@mui/material";



const GetCar = () => {
    const register_url = '/Garage/php/Api/Car/CarRead.php'
    const [voiture, setVoiture] = useState([]);

    const maxCarPrice = Math.max(...voiture.map(car => parseFloat(car.prix)))
    const maxYear = new Date().getFullYear()

    console.log(maxYear)
    const minmum = 0;
    const maximum = Math.ceil(maxCarPrice);
    const [priceRangeValue, setPriceRangeValue] = useState([0, 1000000]);
    const [yearRangeValue, setYearRangeValue] = useState([1960, maxYear]);
    const [kiloRangeValue, setKiloRangeValue] = useState([0, 300000]);

    const priceChange = (event, newValue) => {
        setPriceRangeValue(newValue);
    };
    const yearChange = (event, newValue) => {
        setYearRangeValue(newValue);
    };
    const kiloChange = (event, newValue) => {
        setKiloRangeValue(newValue);
    };

    useEffect(() => {
        fetchVoiture();
    }, [])

    const fetchVoiture = async (e) => {
        await axios.get(register_url).then((res) => {
            console.log(res.data);
            setVoiture(res.data)
        })
            .catch((err) => {
                console.log(err);
            })
    }

    const carsInRange = voiture.filter((car) => {
        const carPrice = parseFloat(car.prix);
        const carYear = parseInt(car.annee_circulation);
        const carMileage = parseInt(car.kilometrage);
        return (
            carPrice >= priceRangeValue[0] &&
            carPrice <= priceRangeValue[1] &&
            carYear >= yearRangeValue[0] &&
            carYear <= yearRangeValue[1] &&
            carMileage >= kiloRangeValue[0] &&
            carMileage <= kiloRangeValue[1])
    })



    const cars = carsInRange.map(car => {
        return (
            <div className="voit d-flex flex-column align-items-start m-3 flex-grow-0" key={car.id}>
                <div className="image-container align-self-center p-1">
                    <img src={require(`../../assests/Image/${car.image}`)} alt='cars' className="align-self-center py-3 img-fluid" />
                </div>
                <div className="ps-2" > {car.modele} </div>
                <div className="ps-2" >Année: {car.annee_circulation} </div>
                <div className="ps-2" >Killométrage: {car.kilometrage} Km</div>

                <div className="ps-2" >Prix: {car.prix} € </div>
                <Link className="align-self-center bouton lien" to={`/Voiture/${car.id}`} >   Plus d'information</Link>
            </div>


        )
    })



    return (

        <section className="d-flex flex-column">

            <div style={{ width: "50vh" }} className="m-auto ">
                <div>
                    <label htmlFor="priceRange">Prix :</label>
                    <span> {priceRangeValue[0]}€ - {priceRangeValue[1]}€</span>
                </div>
                <Slider
                    getAriaLabel={() => "Price Range"}
                    value={priceRangeValue}
                    onChange={priceChange}
                    valueLabelDisplay='auto'
                    min={minmum}
                    max={maximum}>
                </Slider>

            </div>
            <div style={{ width: "50vh" }} className="m-auto ">
                <div>
                    <label htmlFor="yearRange">Annee :</label>
                    <span> {yearRangeValue[0]} - {yearRangeValue[1]}</span>
                </div>
                <Slider
                    getAriaLabel={() => "Year Range"}
                    value={yearRangeValue}
                    onChange={yearChange}
                    valueLabelDisplay='auto'
                    min={1960}
                    max={maxYear}>
                </Slider>

            </div>
            <div style={{ width: "50vh" }} className="m-auto ">
                <div>
                    <label htmlFor="kiloRange">Kilometrage :</label>
                    <span> {kiloRangeValue[0]} - {kiloRangeValue[1]}</span>
                </div>
                <Slider
                    getAriaLabel={() => "Kilometrage Range"}
                    value={kiloRangeValue}
                    onChange={kiloChange}
                    valueLabelDisplay='auto'
                    min={minmum}
                    max={300000}>
                </Slider>
            </div>

            <div className="d-flex flex-row align-self-center ">
                {cars.length > 0 ? cars : <p className="m-auto">Aucune voiture correspond a vos critère</p>}
            </div>

        </section>




    )
}

export default GetCar
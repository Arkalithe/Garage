import React, { useState, useEffect } from "react";
import axios from "../../api/axios";
import { Link } from "react-router-dom";
import { Slider } from "@mui/material";

const GetCar = () => {
  const register_url = "/Garage/php/Api/Car/CarRead.php";
  const [voiture, setVoiture] = useState([]);
  const maxYear = new Date().getFullYear();
  const minmum = 0;
  const maximum = 25000;
  const [priceRangeValue, setPriceRangeValue] = useState([0, 25000]);
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
  }, []);

  const fetchVoiture = async () => {
    try {
      const res = await axios.get(register_url);
      setVoiture(res.data);
    } catch (err) {
     
    }
  };

  const resetPriceRange = () => {
    setPriceRangeValue([minmum, maximum]);
  };

  const resetYearRange = () => {
    setYearRangeValue([1960, maxYear]);
  };

  const resetKiloRange = () => {
    setKiloRangeValue([minmum, 300000]);
  };

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
      carMileage <= kiloRangeValue[1]
    );
  });

  const uniqueCars = Array.from(new Set(carsInRange.map(car => car.id)))
    .map(id => carsInRange.find(car => car.id === id));



  const cars = uniqueCars.map((car) => {
    let carImages = [];
    if (car.voiture_images) {
      carImages = car.voiture_images.split(",");
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
        <div className="ps-2">{car.modele}</div>
        <div className="ps-2">Année: {car.annee_circulation}</div>
        <div className="ps-2">Kilométrage: {car.kilometrage} Km</div>
        <div className="ps-2">Prix: {car.prix} €</div>
        <Link className="align-self-center bouton bouton-lien" to={`/Voiture/${car.id}`}>
          Plus d'information
        </Link>
      </div>
    )
  })
    ;

  return (
    <>
      <section className="d-flex flex-column my-2" style={{ width: "100%" }}>
        <div className="voit mx-auto" style={{ maxWidth: "600px" }}>
          <div className="mx-1">
            <label htmlFor="priceRange">Prix:</label>
            <span className="mx-1">
              {priceRangeValue[0]}€ - {priceRangeValue[1]}€
            </span>
          </div>
          <div className="d-flex align-items-center ms-2">
            <Slider
              getAriaLabel={() => "Price Range"}
              value={priceRangeValue}
              onChange={priceChange}
              valueLabelDisplay="auto"
              min={minmum}
              max={maximum}
              sx={{ width: "300px", mx: "10px" }}
            />
            <button type="button" className="bouton-alt p-2 mx-3" onClick={resetPriceRange}>
              Reset
            </button>
          </div>
        </div>
        <div className="voit mx-auto" style={{ maxWidth: "600px" }}>
          <div>
            <label htmlFor="yearRange">Année:</label>
            <span className="mx-1">
              {yearRangeValue[0]} - {yearRangeValue[1]}
            </span>
          </div>
          <div className="d-flex align-items-center ms-2">
            <Slider
              getAriaLabel={() => "Year Range"}
              value={yearRangeValue}
              onChange={yearChange}
              valueLabelDisplay="auto"
              min={1960}
              max={maxYear}
              sx={{ width: "300px", mx: "10px" }}
            />
            <button type="button" className="bouton-alt p-2 mx-3" onClick={resetYearRange}>
              Reset
            </button>
          </div>
        </div>
        <div className="voit mx-auto" style={{ maxWidth: "600px" }}>
          <div>
            <label htmlFor="kiloRange">Kilométrage:</label>
            <span className="mx-1">
              {kiloRangeValue[0]} - {kiloRangeValue[1]}
            </span>
          </div>
          <div className="d-flex align-items-center mb-3 ms-2">
            <Slider
              getAriaLabel={() => "Kilométrage Range"}
              value={kiloRangeValue}
              onChange={kiloChange}
              valueLabelDisplay="auto"
              min={minmum}
              max={300000}
              sx={{ width: "300px", mx: "10px" }}
            />
            <button type="button" className="bouton-alt p-2 mx-3" onClick={resetKiloRange}>
              Reset
            </button>
          </div>
        </div>
      </section>

      <section>
        <div className="d-flex flex-wrap justify-content-center">
          {cars.length > 0 ? (
            cars
          ) : (
            <h1 className="m-auto">Aucune voiture correspond à vos critères</h1>
          )}
        </div>
      </section>
    </>
  );
};

export default GetCar;

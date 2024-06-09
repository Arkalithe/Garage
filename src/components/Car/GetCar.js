import React, { useState, useEffect } from "react";
import config from "../../api/axios";
import CarCard from './CarCard';
import CarSlider from './CarSlider';
import Pagination from './Pagination';
import { Col, Row, Container } from "react-bootstrap";

const GetCar = () => {
  const register_url = "/Garage/php/Api/Car/CarRead.php";
  const [voiture, setVoiture] = useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const carsPerPage = 6;

  const maxYear = new Date().getFullYear();
  const minPrice = 0;
  const maxPrice = 25000;
  const minKilo = 0;
  const maxKilo = 300000;

  const [priceRangeValue, setPriceRangeValue] = useState([minPrice, maxPrice]);
  const [yearRangeValue, setYearRangeValue] = useState([1960, maxYear]);
  const [kiloRangeValue, setKiloRangeValue] = useState([minKilo, maxKilo]);

  const priceChange = (event, newValue) => setPriceRangeValue(newValue);
  const yearChange = (event, newValue) => setYearRangeValue(newValue);
  const kiloChange = (event, newValue) => setKiloRangeValue(newValue);

  useEffect(() => {
    fetchVoiture();
  }, [currentPage, priceRangeValue, yearRangeValue, kiloRangeValue]);

  const fetchVoiture = async () => {
    try {
      const res = await config.localTestingUrl.get(register_url);
      setVoiture(Array.isArray(res.data) ? res.data : []);
      console.log(res)
    } catch (err) {
      console.error("Probleme recuperation donnée voiture", err);
    }
  };

  const resetPriceRange = () => setPriceRangeValue([minPrice, maxPrice]);
  const resetYearRange = () => setYearRangeValue([1960, maxYear]);
  const resetKiloRange = () => setKiloRangeValue([minKilo, maxKilo]);

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

  const uniqueCars = Array.from(new Set(carsInRange.map(car => car.id))).map(id => carsInRange.find(car => car.id === id));

  const totalPages = Math.ceil(uniqueCars.length / carsPerPage);
  const startIndex = (currentPage - 1) * carsPerPage;
  const selectedCars = uniqueCars.slice(startIndex, startIndex + carsPerPage);

  const handlePreviousPage = () => {
    if (currentPage > 1) setCurrentPage(currentPage - 1);
  };

  const handleNextPage = () => {
    if (currentPage < totalPages) setCurrentPage(currentPage + 1);
  };

  return (
    <Container fluid className="p-0 mt-2">
      <Col className="p-0 m-0">
        <Col className="p-0 m-0 d-flex align-items-center justify-content-center ">
          <CarSlider
            label="Prix"
            value={priceRangeValue}
            onChange={priceChange}
            min={minPrice}
            max={maxPrice}
            resetFunc={resetPriceRange}
          />
        </Col>
        <Col className="p-0 m-0 d-flex align-items-center justify-content-center ">
          <CarSlider
            label="Année"
            value={yearRangeValue}
            onChange={yearChange}
            min={1960}
            max={maxYear}
            resetFunc={resetYearRange}
          />
        </Col>
        <Col className="p-0 m-0 d-flex align-items-center justify-content-center ">
          <CarSlider
            label="Kilométrage"
            value={kiloRangeValue}
            onChange={kiloChange}
            min={minKilo}
            max={maxKilo}
            resetFunc={resetKiloRange}
          />
        </Col>
      </Col>

      <Col className="d-flex flex-wrap justify-content-center p-0 m-0">
        {selectedCars.length > 0 ? (
          selectedCars.map(car => <CarCard key={car.id} car={car} />)
        ) : (
          <h1 className="m-auto">Aucune voiture correspond à vos critères</h1>
        )}
      </Col>
      <Row className="d-flex justify-content-center p-0 m-0">
        <Pagination
          currentPage={currentPage}
          totalPages={totalPages}
          onPreviousPage={handlePreviousPage}
          onNextPage={handleNextPage}
        />
      </Row>
    </Container>
  );
};

export default GetCar;
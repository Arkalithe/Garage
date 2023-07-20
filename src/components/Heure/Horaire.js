import React, { useEffect, useState } from 'react';
import Footer from '../Footer';
import config from '../../api/axios';

const Horaire = () => {


  const fetch_url = '/Garage/php/Api/Horaire/HoraireRead.php';
  const [businessHours, setBusinessHours] = useState([]);

  useEffect(() => {
    fetchData()
  }, [])

  const fetchData = async (e) => {
    try {
      const response = await config.herokuTesting.get(fetch_url);
      setBusinessHours(response.data)
    } catch (e) {
      console.error('Problème : ', e)
    }
  }

  return (
    <Footer horaire={businessHours} />
  );
};

export default Horaire;
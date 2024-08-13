import React, { useEffect, useState } from 'react';
import Footer from '../Footer';
import config from '../../api/axios';

const Horaire = () => {


  const fetch_url = '/api/horaires';
  const [businessHours, setBusinessHours] = useState([]);

  useEffect(() => {
    fetchData()
  }, [])

  const fetchData = async (e) => {
    try {
      const response = await config.localTestingUrl.get(fetch_url, {withCredentials: true});
      if (Array.isArray(response.data)) {
        setBusinessHours(response.data);      
      } else {
        setBusinessHours([])
      }
    } catch (e) {
      console.error('Problème : ', e)
    }
  }

  return (
    <Footer horaire={businessHours} />
  );
};

export default Horaire;
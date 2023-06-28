import React from "react";
import { useState, useEffect } from "react";
import axios from "../api/axios";



const Car = () => {
    const register_url = '/Garage/php/Api/Car.php'

    const [voiture, setVoiture] = useState([]);


    useEffect(() => {
        fetchVoiture();
    }, [])

    const fetchVoiture = async () => {
        
        await axios.post(register_url).then((res) => {
            console.log(res.data);
            setVoiture(res.data)
        })
        .catch((err) => {
            console.log(err);
        })}


    return (

        <section>

            <div className="voiture"> 
            {voiture.prix}

            
           
            </div>

        </section>




    )
}

export default Car
import React from "react";
import { useState, useEffect } from "react";
import axios from "../api/axios";
import { Link } from "react-router-dom";



const Car = () => {
    const register_url = '/Garage/php/Api/CarRead.php'
    const [voiture, setVoiture] = useState([]);

    const [select, setSelect] = useState(false);

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
    
    const cars = voiture.map(car => {
        return (            
                <div className="voit col-4 d-flex flex-column align-items-start m-3 " key={car.id}>
                    <img src={require(`../assests/Image/${car.image}`)} alt='cars' className="align-self-center py-3" />
                    <div className="ps-2" > Modèle voiture </div>
                    <div className="ps-2" >Prix: {car.prix} € </div>
                    <div className="ps-2" >Killométrage: {car.kilometrage} Km</div>
                    <div className="ps-2" >Année: {car.annee_circulation} </div>
                    
                        <Link className="align-self-center bouton lien" to={`/Voiture/${car.id}`} >   Plus d'information</Link>  
                </div>
            

        )
    })



    return (

        <section className="container-fluid d-flex flex-row">
            {cars}            
        </section>




    )
}

export default Car
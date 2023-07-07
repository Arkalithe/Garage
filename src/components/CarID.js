import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "../api/axios";





const CarId = () => {

    const register_url = '/Garage/php/Api/CarGetSingle.php'

    const [isLoading, setLoading] = useState(true);
    const [voiture, setVoiture] = useState([]);
    const { idVoiture } = useParams()


    useEffect(() => {
        fetchVoiture();
    }, [])

    const fetchVoiture = async (e) => {
        await axios.get(register_url, { params: { id: idVoiture } })
            .then((res) => {
                setVoiture(res.data)
                setLoading(false)
            })
            .catch((err) => {
                console.log(err);
            })
    }

    if (isLoading) {
        return <div>Chargement</div>
    }




    return (
        <section className="container-fluid ">
            <div>
                <img src={require(`../assests/Image/${voiture.image}`)} alt="voiture" />
                <div>{voiture.modele}</div>
                <div>{voiture.prix}</div>
                <div>{voiture.kilometrage}</div>
                <div>{voiture.annee_circulation}</div>
            </div>
        </section>




    )
}

export default CarId
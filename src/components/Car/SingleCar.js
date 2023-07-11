import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "../../api/axios";
import { Contact } from "../Contact/Contact";

const SingleCar = () => {

    const register_url = '/Garage/php/Api/Car/CarGetSingle.php'

    const [isLoading, setLoading] = useState(true);
    const [form, setForm] = useState(false);

    const [voiture, setVoiture] = useState([]);
    const { idVoiture } = useParams()

    const handleClick = () => {
        setForm((prevState) => !prevState)
    }

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
            {form ? (
                <div className="form-cadre d-flex flex-column align-items-center" >
                    <Contact data={voiture.id} ></Contact>
                    <button onClick={handleClick}> Précedent </button>
                </div>
            ) : (
                <div>
                    <img src={require(`../../assests/Image/${voiture.image}`)} alt="voiture" />
                    <div>{voiture.modele}</div>
                    <div>{voiture.prix}</div>
                    <div>{voiture.kilometrage}</div>
                    <div>{voiture.annee_circulation}</div>
                    <button onClick={handleClick}> Contact </button>
                </div>

            )

            }

        </section>




    )
}

export default SingleCar
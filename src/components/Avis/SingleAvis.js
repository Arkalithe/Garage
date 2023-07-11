import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "../../api/axios";

const SingleAvis = () => {

    const avis_url = '/Garage/php/Api/Avis/AvisGetSingle.php'

    const [isLoading, setLoading] = useState(true);
    const [avis, setAvis] = useState([]);
    const { idAvis } = useParams()


    useEffect(() => {
        fetchAvis();
    }, [])

    const fetchAvis = async (e) => {
        await axios.get(avis_url, { params: { id: idAvis } })
            .then((res) => {
                setAvis(res.data)
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
                <div>{avis.name}</div>
                <div>{avis.message}</div>
                <div>{avis.note}</div>
            </div>
        </section>
    )
}

export default SingleAvis
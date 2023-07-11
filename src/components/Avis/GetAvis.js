import React from "react";
import { useState, useEffect } from "react";
import axios from "../../api/axios";
import { Link } from "react-router-dom";



const GetAvis = () => {
    const register_url = '/Garage/php/Api/Avis/AvisRead.php'
    const [avis, setAvis] = useState([]);


    useEffect(() => {
        fetchAvis();
    }, [])

    const fetchAvis = async (e) => {
        await axios.get(register_url).then((res) => {
            console.log(res.data);
            setAvis(res.data)
        })
            .catch((err) => {
                console.log(err);
            })
    }
    
    const avist = avis.map(aviss => {
        return (            
                <div className="voit col-4 d-flex flex-column align-items-start m-3 " key={aviss.id}>                    
                    <div className="ps-2" > Liste Avis</div>
                    <div className="ps-2" >Nom: {aviss.name} € </div>
                    <div className="ps-2" >Message: {aviss.message} </div>
                    <div className="ps-2" >Note: {aviss.note} </div>
                    
                        <Link className="align-self-center bouton lien" to={`/av/${aviss.id}`} >   Plus d'information</Link>  
                </div>
            

        )
    })



    return (

        <section className="container-fluid d-flex flex-row">
            {avist}            
        </section>




    )
}

export default GetAvis
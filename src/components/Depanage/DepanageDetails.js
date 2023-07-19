import React from 'react';
import { useEffect } from 'react';
import { useState } from 'react';
import axios from '../../api/axios';
import { Link } from 'react-router-dom';


const DepanageDetails = () => {

    const [depanageContent, setDepanageContent] = useState([]);
    const depannage_url = "/Garage/php/Api/Depanage/DepanageRead.php"
    useEffect(() => {
        getData()
    }, [])
    const getData = async () => {
        try {
            const response = await axios.get(depannage_url)
            setDepanageContent(response.data);


        } catch (error) {

        }
    }

    const contents = depanageContent.map((Content) => (


        <div className="card form-cadre h-100">
            <div className="pb-2 card-title">
                <h1>{Content.title}</h1>
            </div>
            <div className="pb-3">
                {Content.image.length > 0 ? (
                    <img
                        className="img-fluid"
                        src={require(`../../assests/Image/${Content.image}`)}
                        alt="Depanage"
                        style={{ maxWidth: '300px', maxHeight: '300px' }}
                    />
                ) : (
                    <div>No Image</div>
                )}
            </div>
            <div className="pb-3">

                <p>{Content.intro}</p>
            </div>
            <div className="pb-3">
                <p>{Content.message}</p>
            </div>

        </div>
    ))


    return (
        <div className="col mb-4">{contents}</div>
    );
};


export default DepanageDetails;

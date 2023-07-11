import React, { useRef, useState } from 'react'

export const Contact = (car) => {

    const nameRef = useRef();


    const [name, setName] = useState("");
    const [prenom, setPrenom] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");
    const [message, setMessage] = useState("");


    return (
        <div >

            <form className="d-flex flex-column align-items-center p-2 m-2">

                <label> Nom : </label>
                <input type="text"
                    id="name"
                    ref={nameRef}
                    autoComplete="off"
                    onChange={(e) => setName(e.target.value)}
                    value={name}
                    required
                />

                <label> Prenom :</label>
                <input
                    type="text"
                    id="prenom"
                    autoComplete="off"
                    onChange={(e) => setPrenom(e.target.value)}
                    value={prenom}
                    required
                />

                <label> Adresse-mail : </label>
                <input
                    type="email"
                    id="email"
                    autoComplete="off"
                    onChange={(e) => setEmail(e.target.value)}
                    value={email}
                    required
                />

                <label> Numéro de téléphone :</label>
                <input
                    type="tel"
                    id="phone"
                    autoComplete="off"
                    onChange={(e) => setPhone(e.target.value)}
                    value={phone}
                    required
                />

                <label> Message : </label>
                <textarea
                    id='message'
                    autoComplete='off'
                    onChange={(e) => setMessage(e.target.value)}
                    value={message}
                    required >
                </textarea>
                <label></label>
                <input
                    type='hidden'
                    id='idCar'
                    value={car.data}
                    required
                />

            </form>

        </div>
    )
}

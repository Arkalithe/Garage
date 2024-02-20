import { Rating } from '@mui/material';
import React, { useRef, useState } from 'react'
import config from '../../api/axios';
import { Link } from 'react-router-dom';





export const NewAvis = () => {
  const errRef = useRef();
  const nameRef = useRef();
  const messageRef = useRef();
  const noteRef = useRef();

  const [name, setName] = useState("");
  const [message, setMessage] = useState("");
  const [note, setNote] = useState("");


  const [err, setErr] = useState('');
  const [success, setSuccess] = useState(false);

  const avis_url = '/Api/Avis/AvisCreate.php'



  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await config.localTestingUrl.post(avis_url, JSON.stringify({ name, message, note }));
      setSuccess(true);
      setName('');
      setMessage('')
      setNote('')

    } catch (err) {
      if (!err?.response) {
        setErr('Pas de reponse serveur');        
      } else if (err.response?.status === 422) {
        setErr("Email déja utilisé")        
      } else {
        setErr('Problème Ajoute employé')        
      }
      errRef.current.focus()
    }

  }

  return (
    <>{success ? (
      <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
        <h1 className="d-flex flex-column p-2 m-2">Avis Envoyé</h1>
        <p >
          <Link to="/" className="bouton lien"> Retour Acceuil  </Link>
        </p>
      </section>
    ) : (
      <section className="form-cadre d-flex flex-column align-items-center">
        <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
          {err}
        </p>

        <h1 className='d-flex flex-column p-1 m-2'> Votre Avis</h1>
        <form className='d-flex flex-column p-2 m-2' onSubmit={handleSubmit}>
          <label htmlFor="name">
            Name:
          </label>
          <input
            type="text"
            id="name"
            ref={nameRef}
            autoComplete="off"
            onChange={(e) => setName(e.target.value)}
            value={name}
            required
          />
          <label htmlFor="message">
            Message :
          </label>
          <textarea
            type="text-area"
            id="message"
            ref={messageRef}
            onChange={(e) => setMessage(e.target.value)}
            value={message}
            required>
          </textarea>

          <label htmlFor="note">
            Note :
          </label>

          <Rating
            className='align-self-center'
            type="number"
            id="note"
            name="simple-controlled"
            size='large'
            ref={noteRef}
            autoComplete="off"
            value={note}
            onChange={(e) => setNote(e.target.value)}
            required
          />
          <button className='d-flex flex-column p-2 m-2 mt-3 bouton'>
            Envoyer
          </button>
        </form>
      </section>
    )}
    </>

  )
}


export default NewAvis
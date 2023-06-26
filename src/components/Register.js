import { useRef, useState, useEffect } from "react";
import React from 'react'
import { Link } from "react-router-dom";
import axios from "../api/axios";

const email_regex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
const password_regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#€%*]).{7,24}$/;
const register_url = '/Garage/php/Api/Register.php'


const Register = () => {
  const emailRef = useRef();
  const errReff = useRef();

  const [email, setEmail] = useState("");
  const [validEmail, setValidEmail] = useState(false);
  const [emailFocus, setEmailFocus] = useState(false);

  const [password, setPassword] = useState("");
  const [validPassword, setValidPassword] = useState(false);
  const [passwordFocus, setPasswordFocus] = useState(false);

  const [matchPassword, setMatchPassword] = useState("");
  const [validMatchPassword, setValidMatchPassword] = useState(false);
  const [matchPasswordFocus, setMatchPasswordFocus] = useState(false);

  const [err, setErr] = useState('');
  const [success, setSuccess] = useState(false);

  useEffect(() => {
    emailRef.current.focus();
  }, [])

  useEffect(() => {
    const result = email_regex.test(email);
    setValidEmail(result)
  }, [email])

  useEffect(() => {
    const result = password_regex.test(password);
    setValidPassword(result)
    const match = password === matchPassword
    setValidMatchPassword(match)
  }, [password, matchPassword])

  useEffect(() => {
    setErr("")
  }, [email, password, matchPassword])

  const handleSubmit = async (e) => {
    e.preventDefault();
    const v1 = email_regex.test(email);
    const v2 = password_regex.test(password);
    if (!v1 || !v2) {
      setErr("Mauvaise entrée")
      return;
    }
    try {
      const response = await axios.post(register_url, JSON.stringify({ email, password }),
        {
          headers: { 'Content-Type': 'application/json' },
          withCredentials: true
        }       
      );
      console.log(response?.data)
      
      setSuccess(true);
      setEmail('');
      setPassword('')
      setMatchPassword('')
    } catch (err) {
      if (!err?.response) {
        setErr('Pas de reponse serveur');
        console.log(err.response?.data)
      } else if (err.response?.status === 422) {
        setErr("Email déja utilisé")
        console.log(err.response?.data)
      } else {
        setErr('Problème Ajoute employé')
        console.log(err.response?.data)
      }
      errReff.current.focus()
    }
  }

  return (
    <>
      {
        success ? (
          <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
            <h1 className="d-flex flex-column p-2 m-2">Employé Ajouté</h1>
            <p >
              <Link to="/adminSpace" className="bouton lien"> Retour Espace Admin  </Link>
            </p>
          </section>
        ) : (
          <section className="form-cadre d-flex flex-column align-items-center">
            <p ref={errReff} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
              {err}
            </p>
            <h1 className='d-flex flex-column p-2 m-2'> Ajout employé</h1>
            <form className='d-flex flex-column p-2 m-2' onSubmit={handleSubmit}>
              <label htmlFor="email">
                Email:
                <span className={validEmail ? "valid" : 'hide'}></span>
                <span className={validEmail || !email ? 'hide' : "invalid"}></span>
              </label>

              <input
                type="text"
                id="email"
                ref={emailRef}
                autoComplete="off"
                onChange={(e) => setEmail(e.target.value)}
                value={email}
                required
                aria-invalid={validEmail ? 'false' : 'true'}
                aria-describedby="uidnote"
                onFocus={() => setEmailFocus(true)}
                onBlur={() => setEmailFocus(false)}

              />
              <p id="uidnote" className={emailFocus && email && !validEmail ? "instructions" : "offscreen"}>

                Email incorrect veuillez respecter ce format :<br />
                exemple@exemple.exe
              </p>
              <label htmlFor="password">
                Mot de passe:
              </label>
              <input
                type="password"
                id="password"
                onChange={(e) => setPassword(e.target.value)}
                value={password}
                required
                aria-invalid={validPassword ? "false" : "true"}
                aria-describedby="passwordnote"
                onFocus={() => setPasswordFocus(true)}
                onBlur={() => setPasswordFocus(false)}

              />
              <p id="passwordnote" className={passwordFocus && !validPassword ? "instructions" : "offscreen"}>
                8 a 24 charactère requis. <br />
                Doit inclure une minuscule, une majuscule, un chiffre et un charactère spécial. <br />
                Charactère spécial autorisé : <span aria-label="exclamation mark">!</span>
                <span aria-label="at symbole">@</span><span aria-label="dièse">#</span>
                <span aria-label="dollar">$</span><span aria-label="euro">€</span>
                <span aria-label="etoile">*</span><span aria-label="pourcent">%</span>
              </p>

              <label htmlFor="confirmation_password">
                Comfirmation Mot de Passe :
              </label>
              <input
                type="password"
                id='confirmation_password'
                onChange={(e) => setMatchPassword(e.target.value)}
                value={matchPassword}
                required
                aria-invalid={validMatchPassword ? "false" : "true"}
                aria-describedby="confirmationnote"
                onFocus={() => setMatchPasswordFocus(true)}
                onBlur={() => setMatchPasswordFocus(false)}

              />
              <p id='confirmationnote' className={matchPasswordFocus && !validMatchPassword ? 'instructions' : 'offscreen'}>
                Doit correspondre au Mot de Passe précédent.
              </p>
              <button className='d-flex flex-column p-2 m-2 mt-3 bouton' disabled={!validEmail || !validPassword || !validMatchPassword ? true : false}>
                Ajouté Employé.
              </button>
            </form>


          </section>
        )}
    </>
  )
}

export default Register
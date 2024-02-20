import React, { useRef, useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { Form, Button, Alert } from "react-bootstrap";
import config from "../../api/axios";

const email_regex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
const password_regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#€%*]).{7,24}$/;
const register_url = '/Garage/php/Api/Register.php';

const Register = () => {
  const emailRef = useRef();
  const passwordRef = useRef();
  const matchPasswordRef = useRef();
  const errRef = useRef();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [matchPassword, setMatchPassword] = useState("");
  const [err, setErr] = useState('');
  const [success, setSuccess] = useState(false);

  useEffect(() => {
    emailRef.current.focus();
  }, [])

  useEffect(() => {
    setErr("")
  }, [email, password, matchPassword])

  const handleSubmit = async (e) => {
    e.preventDefault();
    const v1 = email_regex.test(email);
    const v2 = password_regex.test(password);
    if (!v1 || !v2 || password !== matchPassword) {
      setErr("Mauvaise entrée")
      return;
    }
    try {
      await config.localTestingUrl.post(register_url, JSON.stringify({ email, password }));
      setSuccess(true);
      setEmail('');
      setPassword('');
      setMatchPassword('');
    } catch (err) {
      if (!err?.response) {
        setErr('Pas de réponse serveur');
      } else if (err.response?.status === 422) {
        setErr("Email déjà utilisé")
      } else {
        setErr('Problème ajout employé')
      }
      errRef.current.focus();
    }
  }

  return (
    <>
      {success ? (
        <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
          <h1 className="d-flex flex-column p-2 m-2">Employé Ajouté</h1>
          <p>
            <Link to="/adminSpace" className="bouton lien"> Retour Espace Admin  </Link>
          </p>
        </section>
      ) : (
        <section className="form-cadre d-flex flex-column align-items-center">
          <Alert ref={errRef} variant="danger" className={err ? '' : 'offscreen'}>
            {err}
          </Alert>
          <h1 className='d-flex flex-column p-2 m-2'> Ajout employé</h1>
          <Form className='d-flex flex-column p-2 m-2' onSubmit={handleSubmit}>
            <Form.Group controlId="email">
              <Form.Label>Email:</Form.Label>
              <Form.Control
                type="text"
                ref={emailRef}
                autoComplete="off"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
                isInvalid={email && !email_regex.test(email)}
              />
              <Form.Control.Feedback type="invalid">
                Email incorrect. Veuillez respecter ce format : exemple@exemple.exe
              </Form.Control.Feedback>
            </Form.Group>
            <Form.Group controlId="password">
              <Form.Label>Mot de passe:</Form.Label>
              <Form.Control
                type="password"
                ref={passwordRef}
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                isInvalid={password && !password_regex.test(password)}
              />
              <Form.Control.Feedback type="invalid">
                8 à 24 caractères requis. Doit inclure une minuscule, une majuscule, un chiffre et un caractère spécial.
              </Form.Control.Feedback>
            </Form.Group>
            <Form.Group controlId="matchPassword">
              <Form.Label>Confirmation Mot de Passe:</Form.Label>
              <Form.Control
                type="password"
                ref={matchPasswordRef}
                value={matchPassword}
                onChange={(e) => setMatchPassword(e.target.value)}
                required
                isInvalid={matchPassword && password !== matchPassword}
              />
              <Form.Control.Feedback type="invalid">
                Doit correspondre au Mot de Passe précédent.
              </Form.Control.Feedback>
            </Form.Group>
            <Button
              className='d-flex flex-column p-2 m-2 mt-3 bouton'
              type="submit"
              disabled={!email || !password || !matchPassword || !email_regex.test(email) || !password_regex.test(password) || password !== matchPassword}
            >
              Ajouter Employé
            </Button>
          </Form>
        </section>
      )}
    </>
  )
}

export default Register;

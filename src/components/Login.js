import { useRef, useState, useEffect, useContext } from 'react';
import AuthContext from '../context/AuthProvider';
import { Link } from 'react-router-dom';

import axios from '../api/axios';
const login_url = '/Garage/php/Api/Login.php'

const Login = () => {

    const { setAuth } = useContext(AuthContext);
    const emailRef = useRef();
    const errRef = useRef();

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [err, setErr] = useState('');
    const [success, setSucess] = useState(false);

    useEffect(() => {
        emailRef.current.focus();
    }, [])

    useEffect(() => {
        setErr('');
    }, [email, password])

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post(login_url, JSON.stringify({ email, password }),
                {
                    headers: { 'Content-Type': 'application/json' },
                    withCredentials: true
                }
            );
            const accessToken = response?.data?.accessToken;
            const roles = response?.data?.roles;
            setAuth({ email, password, roles, accessToken })
            setEmail('');
            setPassword('');
            setSucess(true);
        } catch (err) {
            if (!err?.response) {
                setErr('Pas de reponse serveur');

            } else if (err.response?.status === 400) {
                setErr("Email ou mot de passe incorect")
            } else if (err.response?.status === 401) {
                setErr("Vous n'avez pas les droits")
            } else {
                setErr('Problème connexion')
            }
            errRef.current.focus();
        }
    }

    return (
        <div className='d-flex flex-column container-fluid align-items-center m-auto' >
            {success ? (
                <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
                    <h1>Vous être connecté</h1>
                    <br />
                    <p>
                        <Link to="/adminSpace" className="bouton lien"> Retour Espace Admin  </Link> </p>
                </section>
            ) : (
                <section className="form-cadre d-flex flex-column align-items-center justify-content-start">
                    <p ref={errRef} className={err ? "errmsg" : 'offscreen'} aria-live='assertive'> {err} </p>
                    <h1 className='d-flex flex-column p-2 m-2'>Connexion</h1>
                    <form className='d-flex flex-column p-2 m-2' onSubmit={handleSubmit}>
                        <label htmlFor='email' >Email:</label>
                        <input type='text'
                            id='email'
                            ref={emailRef}
                            autoComplete='off'
                            onChange={(e) => setEmail(e.target.value)}
                            value={email}
                            required
                        />

                        <label htmlFor='password' >Password:</label>
                        <input  type='password'
                            id='password'
                            onChange={(e) => setPassword(e.target.value)}
                            value={password}
                            required
                        />

                        <button className='d-flex flex-column p-2 m-2 mt-3 bouton' > Connexion </button>
                    </form>
                </section>
            )

            }
        </div>
    )


}

export default Login;
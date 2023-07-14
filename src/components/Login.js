import { useRef, useState, useEffect } from 'react';
import useAuth from '../hooks/useAuth';
import { Link, useNavigate, useLocation } from 'react-router-dom';

import axios from '../api/axios';
import jwtDecode from 'jwt-decode';

const login_url = '/Garage/php/Api/Login.php'

const Login = () => {

    const { setAuth } = useAuth();

    const navigate = useNavigate();
    const location = useLocation();
    const from = location.state?.from?.pathname || "/";

    const emailRef = useRef();
    const errRef = useRef();

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [err, setErr] = useState('');

    const [formErrors, setFormErrors] = useState({ email: '', password: '' });
    const [isSubmitting, setIsSubmitting] = useState(false);

    useEffect(() => {
        emailRef.current.focus();
    }, [])

    useEffect(() => {
        setErr('');
    }, [email, password])

    const validateForm = () => {
        let isValid = true;
        const errors = {};
    
        if (!email) {
          errors.email = 'Email Obligatoire';
          isValid = false;
        }
    
        if (!password) {
          errors.password = 'Mots de passe obligatoire';
          isValid = false;
        }
    
        setFormErrors(errors);
        return isValid;
      };

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (validateForm()) {
            setIsSubmitting(true);

        try {
            const response = await axios.post(login_url,
                JSON.stringify({ email, password, })
            );

            const accessToken = response.data[0];
            const dcode = jwtDecode(accessToken)
            const role = dcode.data.role

            setAuth({ email, password, role, accessToken })
            setEmail('');
            setPassword('');

            if (role === 'Employee') {
                navigate('/employeSpace');
              } else if (role === 'Admin') {
                navigate('/adminSpace');
              } else {
                navigate(from, { replace: true });
              }
        } catch (err) {
            if (!err?.response) {
                setErr('Pas de reponse serveur');

            } else if (err.response?.status === 422) {
                setErr("Email ou mot de passe incorect")
            } else if (err.response?.status === 401) {
                setErr("Vous n'avez pas les droits")
            } else {
                setErr('Problème connexion')
            }
            errRef.current.focus();
        } finally {
            setIsSubmitting(false);
        }
    }
}

    return (
        <div className="d-flex flex-column container-fluid align-items-center m-auto">
        <section className="form-cadre d-flex flex-column align-items-center justify-content-start m-auto">
          <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
            {err}
          </p>
          <h1 className="d-flex flex-column p-2 m-2">Connexion</h1>
          <form className="d-flex flex-column p-2 m-2" onSubmit={handleSubmit}>
            <label htmlFor="email">Email:</label>
            <input
              type="text"
              id="email"
              ref={emailRef}
              autoComplete="off"
              onChange={(e) => setEmail(e.target.value)}
              value={email}
              required
            />
            {formErrors.email && <p className="error-msg">{formErrors.email}</p>}
  
            <label htmlFor="password">Password:</label>
            <input
              type="password"
              id="password"
              onChange={(e) => setPassword(e.target.value)}
              value={password}
              required
            />
            {formErrors.password && <p className="error-msg">{formErrors.password}</p>}
  
            <button className="d-flex flex-column p-2 m-2 mt-3 bouton" disabled={isSubmitting}>
              {isSubmitting ? 'Submitting...' : 'Connexion'}
            </button>
          </form>
        </section>
      </div>
    );
  };

export default Login;
import { useRef, useState, useEffect } from 'react';
import useAuth from '../hooks/useAuth';
import { useNavigate, useLocation } from 'react-router-dom';
import { Container, Form, Button, Alert } from 'react-bootstrap';
import config from '../api/axios';
import jwtDecode from 'jwt-decode';

const login_url = '/Api/Login.php'

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

    useEffect(() => {
        emailRef.current.focus();
    }, [])

    useEffect(() => {
        setErr('');
    }, [email, password])

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            const response = await config.herokuTesting.post(login_url,
                JSON.stringify({ email, password, })
            );
            const accessToken = response.data[0];
            const dcode = jwtDecode(accessToken)
            const role = dcode.data.role           

            setAuth({ email, password,role, accessToken})
            setEmail('');
            setPassword('');
            navigate(from, { replace: true });
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
        }
    }

    return (
        <Container className='d-flex flex-column align-items-center m-auto'>

            <section className="form-cadre d-flex flex-column align-items-center justify-content-start m-auto">
                <Alert ref={errRef} variant="danger" className={err ? '' : 'offscreen'} aria-live='assertive'> {err} </Alert>
                <h1 className='d-flex flex-column p-2 m-2'>Connexion</h1>
                <Form className='d-flex flex-column p-2 m-2' onSubmit={handleSubmit}>
                    <Form.Group controlId='email'>
                        <Form.Label>Email:</Form.Label>
                        <Form.Control
                            type='text'
                            ref={emailRef}
                            autoComplete='off'
                            onChange={(e) => setEmail(e.target.value)}
                            value={email}
                            required
                        />
                    </Form.Group>

                    <Form.Group controlId='password'>
                        <Form.Label>Password:</Form.Label>
                        <Form.Control
                            type='password'                            
                            onChange={(e) => setPassword(e.target.value)}
                            value={password}
                            required
                        />
                    </Form.Group>

                    <Button className='d-flex flex-column p-2 m-2 mt-3 bouton' type='submit'> Connexion </Button>
                </Form>
            </section>
        </Container>
    )
}

export default Login;
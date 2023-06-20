import {useContext, useState} from 'react'
import {Link} from 'react-router-dom'
import {UserContext} from '../context/UserContext';


const Register = () => {
    const  {registerUser, wait}  = useContext(UserContext);
    const  [errMsg, setErrMsg]  = useState(false);
    const  [successMsg, setSuccessMsg]  = useState(false);
    const  [formData, setFormData]  = useState({
        email: '',
        password: ''
    });

    const onChangeInput = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        })
    }

    const submitForm = async (e) => {
        e.preventDefault();

        if (!Object.values(formData).every(val => val.trim() !== '')) {
            setSuccessMsg(false);
            setErrMsg('Veuillez remplire les information requise');
            return;
        }

        const data = await registerUser(formData);
        if (data.success) {
            e.target.reset();
            setSuccessMsg("Vous avec bien ajoute l'employe");
            setErrMsg(false);
        }
        else if (!data.success && data.message) {
            setSuccessMsg(false);
            setErrMsg(data.message);
        }


    }

    return (
        <div className='d-flex flex-column form-cadre m-auto p-3'>
            <h1>Ajouté Employe</h1>

            <form onSubmit={submitForm}>
                <label className='py-2 my-2' htmlFor='email'>
                    <p >Adresse Mail</p>
                    <input type="email" name="email" onChange={onChangeInput} placeholder="Your email" id="email" value={formData.email} required />
                </label>
                <br />
                <label className='py-2 my-2' htmlFor="password">
                    <p>Mot de passe</p>
                    <input type='password' name="password" id="rpassword" onChange={onChangeInput} placeholder="Mot de passe" 
                    value={formData.password} required />
                </label>
                {successMsg && <div className="success-msg">{successMsg}</div>}
                {errMsg && <div className="err-msg">{errMsg}</div>}
                <div>
                    <button type='submit' disabled={wait} name='register' id='register' value="register" 
                    className='bouton py-2 mt-2 mb-3'> Nouvelle Employe </button>
                </div>
            </form>
            <div className="bottom-link"><Link to="/register">Login</Link></div>
        </div>
    )
}

export default Register
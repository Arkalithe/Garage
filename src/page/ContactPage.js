import React, { useRef, useState } from 'react';
import config from '../api/axios';

const ContactPage = () => {
  const nameRef = useRef();

  const [mailSetting, setMailSetting] = useState({
    nom: '',
    prenom: '',
    email: '',
    phone: '',
    message: '',
  });

  const url_email = '/Garage/php/Api/Email.php';

  const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData();

    try {
      formData.append('nom', mailSetting.nom);
      formData.append('prenom', mailSetting.prenom);
      formData.append('email', mailSetting.email);
      formData.append('phone', mailSetting.phone);
      formData.append('message', mailSetting.message);

       await config.localTestingUrl.post(url_email, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      alert('Email sent successfully!');
    } catch (error) {
      console.error('Error sending email:', error);
      alert('Failed to send email. Please try again later.');
    }
  };

  const handleChange = (event) => {
    const { name, value } = event.target;
    setMailSetting({ ...mailSetting, [name]: value });
  };

  return (
    <div className="container voit">
      <div>
        <h3>Contactez-nous</h3>
      </div>
      <div className="row">
        <div className="col-md-6 d-flex align-items-center">
          <form className="p-2 m-2" onSubmit={handleSubmit}>
            <div className="form-group">
              <label htmlFor="nom">Nom:</label>
              <input
                type="text"
                id="nom"
                name="nom"
                ref={nameRef}
                className="form-control"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.nom}
                required
              />
            </div>

            <div className="form-group">
              <label htmlFor="prenom">Prenom:</label>
              <input
                type="text"
                id="prenom"
                name="prenom"
                className="form-control"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.prenom}
                required
              />
            </div>

            <div className="form-group">
              <label htmlFor="email">Adresse e-mail:</label>
              <input
                type="email"
                id="email"
                name="email"
                className="form-control"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.email}
                required
              />
            </div>

            <div className="form-group">
              <label htmlFor="phone">Numéro de téléphone:</label>
              <input
                type="tel"
                id="phone"
                name="phone"
                className="form-control"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.phone}
                required
              />
            </div>

            <div className="form-group">
              <label htmlFor="message">Message:</label>
              <textarea
                id="message"
                name="message"
                className="form-control"
                autoComplete="off"
                onChange={handleChange}
                value={mailSetting.message}
                required
              />
            </div>

            <div className="form-group">
              <button type="submit" className="bouton">
                Envoyer Email
              </button>
            </div>
          </form>
        </div>
        <div className="col-md-6 d-flex align-items-center justify-content-center">
          <div className="card cadre-admin  ">
            <div className="card-body text-center">
              <h5 className="card-title ">Informations de contact</h5>
              <p className="card-text">
                Numéro de téléphone: <strong>07-77-56-78-90</strong>
              </p>
              <p className="card-text">
                Adresse: <strong>26 Rue Richard Wagner,Toulouse, France</strong>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ContactPage;

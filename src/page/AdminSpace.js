import React from 'react';
import { Link } from 'react-router-dom';


const AdminSpace = () => {
  return (
    <div className=' form-cadre p-1'>
      <div className=' d-flex flex-column container '>
        <div className='row justify-content-center'>

          <div className='d-flex flex-column col-lg-5 col-md-5 col-sm-12 align-items-center cadre-admin m-1'>
            <h3>Gestion Employé</h3>
            <Link to='/employe' className='bouton bouton-lien'>Modifié</Link>
          </div>

          <div className='d-flex flex-column col-lg-5 col-md-5 col-sm-12 align-items-center cadre-admin m-1'>
            <h3>Gestion Horaire</h3>
            <Link to='/horaire' className='bouton bouton-lien'>Modifié</Link>
          </div>
        </div>

        <div className='row justify-content-center'>
          <div className='d-flex flex-column col-lg-5 col-md-5 col-sm-12 align-items-center cadre-admin m-1'>
            <h3>Moderation avis</h3>
            <Link to='/avis' className='bouton bouton-lien'>Modifié</Link>
          </div>

          <div className='d-flex flex-column col-lg-5 col-md-5 col-sm-12 align-items-center cadre-admin m-1'>
            <h3>Creation Voiture</h3>
            <Link to='/creationVoiture' className='bouton bouton-lien'>Modifié</Link>
          </div>
        </div>

        <div className='row justify-content-center'>
          <div className='d-flex flex-column col-lg-5 col-md-5 col-sm-12 align-items-center cadre-admin m-1'>
            <h3>Moderation Voiture</h3>
            <Link to='/updateVoiture' className='bouton bouton-lien'>Modifié</Link>
          </div>
        </div>


      </div>
    </div>
  );
};

export default AdminSpace;

import React from 'react';
import { Link } from 'react-router-dom';


const ContentSpace = () => {
  return (
    <div className=' form-cadre p-1'>
      <div className=' d-flex flex-column container '>
        <div className='row justify-content-center'>

          <div className='d-flex flex-column col-lg-5 col-md-5 col-sm-12 align-items-center cadre-admin m-1'>
            <h3>Gestion Depannage</h3>
            <Link to='/editDepanage' className='bouton bouton-lien'>Modifié</Link>
          </div>

          <div className='d-flex flex-column col-lg-5 col-md-5 col-sm-12 align-items-center cadre-admin m-1'>
            <h3>Gestion Repartion</h3>
            <Link to='/editReparation' className='bouton bouton-lien'>Modifié</Link>
          </div>
        </div>

        <div className='row justify-content-center'>
          <div className='d-flex flex-column col-lg-5 col-md-5 col-sm-12 align-items-center cadre-admin m-1'>
            <h3>Gestion Ocasion</h3>
            <Link to='/editOcasion' className='bouton bouton-lien'>Modifié</Link>
          </div>
        </div>


      </div>
    </div>
  );
};

export default ContentSpace;

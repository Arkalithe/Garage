import React from 'react';
import useHoraire from '../hooks/useHoraire';

const Footer = () => {
    const { businessHours } = useHoraire();

  return (
    <footer className="mt-auto">
      <div className="container-fluid">
        <div className="col-md-4 d-flex align-items-center pt-2">
          <a className="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" href="/">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" className="bi bi-clock" viewBox="0 0 16 16">
              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
            </svg>
          </a>

          <div className="mb-3 mb-md-0 text-body-secondary">
            <ul className="mb-2 mb-md-0 align-items-center">
              <li className="d-flex align-items-start"><p>Lundi-Vendredi : {businessHours.lundiVendredi}  H</p></li>
              <li className="d-flex align-items-start"><p>Samedi :  H</p>{businessHours.samedi}</li>
              <li className="d-flex align-items-start"><p>Dimanche : </p>{businessHours.dimanche}</li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
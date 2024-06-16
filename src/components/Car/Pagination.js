import React from 'react';

const Pagination = ({ currentPage, totalPages, onPreviousPage, onNextPage }) => (
  <div className="d-flex justify-content-center my-3 form-cadre p-3">
    <button
      className="btn btn-secondary me-2"
      onClick={onPreviousPage}
      disabled={currentPage === 1}
    >
      Précédente
    </button>
    <span className="align-self-center mx-2">
      Page {currentPage} sur {totalPages}
    </span>
    <button
      className="btn btn-secondary"
      onClick={onNextPage}
      disabled={currentPage === totalPages}
    >
      Suivante
    </button>
  </div>
);

export default Pagination;

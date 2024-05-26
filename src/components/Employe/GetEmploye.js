import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import config from "../../api/axios";
import { Form, Container, Row, Col } from 'react-bootstrap';
import Pagination from "../Car/Pagination";


const GetEmploye = () => {
  const employe_url = "/Garage/php/Api/User/UserRead.php";
  const delete_url = "/Garage/php/Api/User/UserDelete.php";

  const [user, setUser] = useState([]);
  const [selectedIds, setSelectedIds] = useState([]);
  const [error, setError] = useState(null);

  const [currentPage, setCurrentPage] = useState(1); 
  const itemsPerPage = 6;

  const handleCheckboxChange = (event, id) => {
    setSelectedIds(prevIds =>
      event.target.checked ? [...prevIds, id] : prevIds.filter(selectedId => selectedId !== id)
    );
  };

  const fetchEmploye = async () => {
    try {
      const response = await config.localTestingUrl.get(employe_url);
      setUser(response.data);
    } catch (error) {
      setError("Erreur recupération des Employe", error)
    }
  };

  const deleteEmploye = async () => {
    try {
      const filteredIds = selectedIds.filter((id) => {
        const employe = user.find((user) => user.id === id);
        return employe.role !== "Admin";
      });

      await config.localTestingUrl.post(delete_url, { ids: filteredIds });
      fetchEmploye(currentPage);
      setSelectedIds([]);
    } catch (error) {
      setError("Erreur suppresion des Employe", error)
    }
  };

  useEffect(() => {
    fetchEmploye(currentPage);
  }, [currentPage]);

  const totalPages = Math.ceil(user.length / itemsPerPage);

  const handlePreviousPage = () => {
    setCurrentPage(prevPage => Math.max(prevPage - 1, 1));
  };

  const handleNextPage = () => {
    setCurrentPage(prevPage => Math.min(prevPage + 1, totalPages));
  };

  return (
    <>
    <Container className="form-cadre py-4">
      <h3 className="pb-2">Liste Employe</h3>
      {error && <div className="alert alert-danger">{error}</div>}
      {user.length > 0 ? (
        user.map((employe, index) => (
          <React.Fragment key={employe.id}>
            <Row className="align-items-center mb-3">
              <Col xs={1}>
                <Form.Check
                  type="checkbox"
                  checked={selectedIds.includes(employe.id)}
                  onChange={e => handleCheckboxChange(e, employe.id)}
                />
              </Col>
              <Col>
                <Link className="align-self-center d-flex lien flex-row" to={`/employe/update/${employe.id}`}>
                  <div className="ps-2">Id: {employe.id}</div>
                  <div className="ps-2">Email: {employe.email}</div>
                </Link>
              </Col>
            </Row>
            {index < user.length - 1 && <hr />}
          </React.Fragment>
        ))
      ) : (
        <div>No employes found.</div>
      )}

      {selectedIds.length > 0 && (
        <button variant="danger" className="bouton-delete" onClick={deleteEmploye}>
          Supprimer
        </button>
      )}

      <Link className="text-white text-decoration-none" to="/signup">
        <button className="align-self-center bouton">
          Ajouter
        </button>
      </Link>
    </Container>

    <Container className="d-flex justify-content-center mt-4">
      <Pagination 
        currentPage={currentPage}
        totalPages={totalPages}
        onPreviousPage={handlePreviousPage}
        onNextPage={handleNextPage}
      />
    </Container>

    <Container className="d-flex justify-content-center mt-4">
      <Link to="/adminSpace">
        <button className="align-self-center bouton">
          Précédent
        </button>
      </Link>
    </Container>
  </>
);
};

export default GetEmploye;
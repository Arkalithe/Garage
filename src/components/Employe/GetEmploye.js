import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import {Button } from "react-bootstrap";
import config from "../../api/axios";
import { Checkbox } from "@mui/material";

const GetEmploye = () => {
  const employe_url = "/Garage/php/Api/User/UserRead.php";
  const delete_url = "/Garage/php/Api/User/UserDelete.php";

  const [user, setUser] = useState([]);
  const [selectedIds, setSelectedIds] = useState([]);

  const handleCheckboxChange = (event, id) => {
    if (event.target.checked) {
      setSelectedIds((prevIds) => [...prevIds, id]);
    } else {
      setSelectedIds((prevIds) => prevIds.filter((selectedId) => selectedId !== id));
    }
  };

  const fetchEmploye = async () => {
    try {
      const response = await config.localTestingUrl.get(employe_url);
      setUser(response.data);
    } catch (error) {}
  };

  const deleteEmploye = async () => {
    try {
      const filteredIds = selectedIds.filter((id) => {
        const employe = user.find((user) => user.id === id);
        return employe.role !== "Admin";
      });

      await config.localTestingUrl.post(delete_url, { ids: filteredIds });
      fetchEmploye();
      setSelectedIds([]);
    } catch (error) {}
  };

  useEffect(() => {
    fetchEmploye();
  }, []);

  const employes = user.map((employe) => (
    <div className="voit container d-flex flex-row align-items-start m-3 " key={employe.id}>
      <div className="d-flex flex-row">
        <Checkbox
          className=""
          checked={selectedIds.includes(employe.id)}
          onChange={(e) => handleCheckboxChange(e, employe.id)}
        />
        <Link className="align-self-center d-flex lien flex-row" to={`/employe/update/${employe.id}`}>
          <div className="ps-2">Id: {employe.id}</div>
          <div className="ps-2">Email: {employe.email}</div>
        </Link>
      </div>
    </div>
  ));

  return (
    <section className="container">
      <h3 className="ps-2 align-self-center d-flex">Liste Employe</h3>
      {employes}

      {selectedIds.length > 0 && (
        <Button className="align-self-center bouton lien" onClick={deleteEmploye}>
          Supprimer
        </Button>
      )}

      <Button className="align-self-center bouton lien m-auto">
        <Link className=" lien" to="/signup">
          Ajouter
        </Link>
      </Button>
    </section>
  );
};

export default GetEmploye;

import React from 'react'
import Register from '../components/Employe/Register'
import { Link } from 'react-router-dom'

const AdminSpace = () => {



  return (
    <div className='d-flex flex-column container-fluid align-items-center m-auto'>
      <div className='form-cadre'>

        <div className='d-flex flex-row container-fluid align-items-center m-auto'>
          <Link to='/employe' className='d-flex flex-column p-2 m-2 mt-3 bouton'>Employé</Link>
          <Link to='/horaire' className='d-flex flex-column p-2 m-2 mt-3 bouton'>Horaire</Link>
        </div>

        <div className='d-flex flex-row container-fluid align-items-center m-auto'>
          <button className='d-flex flex-column p-2 m-2 mt-3 bouton'>Employé</button>
          <button className='d-flex flex-column p-2 m-2 mt-3 bouton'>Employé</button>
        </div>
        <div className='d-flex flex-row container-fluid align-items-center m-auto'>
          <button className='d-flex flex-column p-2 m-2 mt-3 bouton'>Employé</button>
          <button className='d-flex flex-column p-2 m-2 mt-3 bouton'>Employé</button>
        </div>
      </div >
    </div>
  )

}



export default AdminSpace
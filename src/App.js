
import './App.css';
import { Routes, Route, } from 'react-router-dom';

import Home from './page/Home';
import AdminSpace from './page/AdminSpace';
import { Car } from './page/Car';

import Header from './components/Header';
import Footer from './components/Footer';
import Login from './components/Login';
import Register from './components/Employe/Register';
import SingleCar from './components/Car/SingleCar';
import RequireAuth from './components/RequireAuth';
import Layout from './components/Layout';
import Unauthorized from './page/Unauthorized';
import NewAvis from './components/Avis/NewAvis';
import GetAvis from './components/Avis/GetAvis';
import SingleAvis from './components/Avis/SingleAvis';
import GetEmploye from './components/Employe/GetEmploye'
import UpdateEmploye from './components/Employe/UpdateEmploye';
import Horaire from './components/Heure/Horaire';



function App() {

  const ROLE = {
    'Admin': 'Admin',
    'Employe': 'Employe'
  }


  return (
    <div className='App d-flex flex-column'>

      <Header />
      <Routes>
        <Route path="/" element={<Layout />} >

          <Route path="/" element={<Home />} exact />
          <Route path='/avis' element={<NewAvis />} exact />
          <Route path="/unauthorized" element={<Unauthorized />} />
          <Route path="/login" element={<Login />} />
          <Route exact path="/Voiture" element={<Car />} />
          <Route path="/Voiture/:idVoiture" element={<SingleCar />} />
          <Route path='/horaire' element={<Horaire />} /> 

            <Route path="/signup" element={<Register />} />
            <Route path="/adminSpace" element={<AdminSpace />} />
            <Route path='/employe' element={<GetEmploye />} />
            <Route path='/employe/update/:idEmploye' element={ <UpdateEmploye />} />

            <Route path="/av" element={<GetAvis />} />
            <Route path="/av/:idAvis" element={<SingleAvis />} />
          <Route element={<RequireAuth allowedRoles={[ROLE.Employe, ROLE.Admin]} />}>

          </Route>

          <Route element={<RequireAuth allowedRoles={[ROLE.Admin]} />}>

          </Route>
        </Route>
        
      </Routes>

      <Footer />

    </div>
  )
}



export default App;

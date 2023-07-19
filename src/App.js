import './App.css';
import { Routes, Route, } from 'react-router-dom';

import Home from './page/Home';
import AdminSpace from './page/AdminSpace';
import { Car } from './page/Car';
import Unauthorized from './page/Unauthorized';
import ContactPage from './page/ContactPage';

import Header from './components/Header';
import Login from './components/Login';
import Register from './components/Employe/Register';
import SingleCar from './components/Car/SingleCar';
import RequireAuth from './components/RequireAuth';
import Layout from './components/Layout';
import NewAvis from './components/Avis/NewAvis';
import GetAvis from './components/Avis/GetAvis';
import SingleAvis from './components/Avis/SingleAvis';
import GetEmploye from './components/Employe/GetEmploye'
import UpdateEmploye from './components/Employe/UpdateEmploye';
import Horaire from './components/Heure/Horaire';
import HoraireUpdate from './components/Heure/HoraireUpdate';
import ModerateAvis from './components/Avis/ModerateAvis';
import { NewCar } from './components/Car/NewCar';
import UpdateCar from './components/Car/UpdateCar';
import GetUpdateCar from './components/Car/GetUpdateCar';
import ReparationDetails from './components/Reparation/ReparationDetails';
import DepanageDetails from './components/Depanage/DepanageDetails';
import EditReparation from './components/Reparation/EditReapartion';
import EditDepanage from './components/Depanage/EditDepanage';
import EditOcasion from './components/Ocasion/EditOccasion';





function App() {


  const ROLE = {
    'Admin': 'Admin',
    'Employe': 'Employe'
  }


  return (
    <div className='App d-flex flex-column '>

      <Header />
      <Routes>
        <Route path="/" element={<Layout />} >
          <Route path="/" element={<Home />} exact />
          <Route path='/newavis' element={<NewAvis />} exact />
          <Route path="/unauthorized" element={<Unauthorized />} />
          <Route path="/login" element={<Login />} />
          <Route exact path="/Voiture" element={<Car />} />
          <Route path="/Voiture/:idVoiture" element={<SingleCar />} />
          <Route path="/av" element={<GetAvis />} />
          <Route path='/contactPage' element={<ContactPage />} />
          <Route path='/reparation' element={<ReparationDetails />} />
          <Route path='/depanage' element={<DepanageDetails />} />
<Route path='editDepanage' element={<EditDepanage />} />
<Route path='editOcasion' element={<EditOcasion />} />

          <Route element={<RequireAuth allowedRoles={[ROLE.Employe, ROLE.Admin]} />}>
            <Route path='updateVoiture/:idVoiture' element={<UpdateCar />} />
            <Route path='updateVoiture' element={<GetUpdateCar />} />
            <Route path='avis' element={<ModerateAvis />} />
            <Route path="/avis/:idAvis" element={<SingleAvis />} />
            <Route path="creationVoiture" element={<NewCar />} />
          </Route>

          <Route element={<RequireAuth allowedRoles={[ROLE.Admin]} />}>
            <Route path="/adminSpace" element={<AdminSpace />} />
            <Route path='horaire' element={<HoraireUpdate />} />
            <Route path='/employe' element={<GetEmploye />} />
            <Route path='/employe/update/:idEmploye' element={<UpdateEmploye />} />
            <Route path="/signup" element={<Register />} />
            <Route path='editReparation' element={<EditReparation />} />
            
          </Route>
        </Route>

      </Routes>
      <Horaire />


    </div>
  )
}



export default App;

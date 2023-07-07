
import './App.css';
import {  Routes, Route, } from 'react-router-dom';
import Header from './components/Header';
import Footer from './components/Footer';
import Home from './page/Home';
import Login from './components/Login';
import Register from './components/Register';
import AdminSpace from './page/AdminSpace';
import Car from './components/Car';
import CarId from './components/CarID';
import RequireAuth from './components/RequireAuth';
import Layout from './components/Layout';
import Unauthorized from './page/Unauthorized';



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

            <Route path="/" element={<Home />} exact/>
            <Route path="/unauthorized" element={<Unauthorized />} />
            <Route path="/login" element={<Login />} />
            <Route exact path="/Voiture" element={<Car />} />
            <Route path="/Voiture/:idVoiture" element={<CarId />} />

            <Route element={<RequireAuth allowedRoles={[ROLE.Employe, ROLE.Admin]} />}>
              <Route path="/signup" element={<Register />} />
            </Route>
            
            <Route element={<RequireAuth allowedRoles={[ROLE.Admin]} />}>
              <Route path="/adminSpace" element={<AdminSpace />} />
            </Route>
          </Route>


        </Routes>

        <Footer />
      
    </div>
  )
}



export default App;

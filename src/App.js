
import './App.css';
import { Routes, Route, Navigate } from 'react-router-dom';
import Header from './components/Header';
import Footer from './components/Footer';
import Home from './page/Home';
import Login from './page/Login';
import DetailsCar from './page/DetailsCar';
import AdminSpace from './page/AdminSpace';
import Contact from './page/Contact';
import EmployeSpace from './page/EmployeSpace';
import Service from './page/Service';
import Voiture from './page/Voiture';
import Register from './components/Register';
import { UserContext } from './context/UserContext';
import { useContext } from 'react';


function App() {
  const { user } = useContext(UserContext);

  return (
    <div className='App d-flex flex-column'>

        <Header />
        <Routes>
          {user &&
            <>
              <Route path='/' element={<Home />} />
              <Route path='/contact' element={<Contact />} />
              <Route path='/detailsCar' element={<DetailsCar />} />
              <Route path='/login' element={<Login />} />
              <Route path='/service' element={<Service />} />
              <Route path='/voiture' element={<Voiture />} />
              <Route path='/employeSpace' element={<EmployeSpace />} />
              <Route path='/adminSpace' element={<AdminSpace />} />
              <Route path='/register' element={<Register />} />
            </>}
          {!user &&
            <>
              <Route path='/' element={<Home />} />
              <Route path='/contact' element={<Contact />} />
              <Route path='/detailsCar' element={<DetailsCar />} />
              <Route path='/login' element={<Login />} />
              <Route path='/service' element={<Service />} />
              <Route path='/voiture' element={<Voiture />} />
              <Route path='/adminSpace' element={<AdminSpace />} />
              <Route path='/register' element={<Register />} />
            </>}
            <Route Path='*' element={<Navigate to={user ? '/':'/login'} />} /> 
        </Routes>
        <Footer />

    </div>
  )
}



export default App;

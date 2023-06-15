
import './App.css';
import { Routes, Route } from 'react-router-dom';
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


function App() {
  return (
    <div className='App d-flex flex-column'>   
    <Header />
      <Routes>
        <Route path='/' element={<Home />} />
        <Route path='/contact' element={<Contact />} />
        <Route path='/detailsCar' element={<DetailsCar />} />
        <Route path='/employeSpace' element={<EmployeSpace />} />
        <Route path='/login' element={<Login />} />
        <Route path='/service' element={<Service />} />
        <Route path='/voiture' element={<Voiture />} />
        <Route path='/adminSpace' element={<AdminSpace />} />
      </Routes>
    <Footer />  
      </div>  
  )
}



export default App;

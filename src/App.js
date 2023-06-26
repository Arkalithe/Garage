
import './App.css';
import {BrowserRouter ,Routes, Route, } from 'react-router-dom';
import Header from './components/Header';
import Footer from './components/Footer';
import Home from './page/Home';
import Login from './components/Login';
import Register from './components/Register';
import AdminSpace from './page/AdminSpace';



function App() { 

    
  return (
    <div className='App d-flex flex-column'>
      <BrowserRouter>
        <Header />        
          <Routes>
             <Route path="/" element={<Home/>} />      
              <Route path="/login" element={<Login/>} />
              <Route path="/signup" element={<Register/>} /> 
              <Route path="/adminSpace" element={<AdminSpace />} />
          </Routes>
        
        <Footer />
</BrowserRouter>
    </div>
  )
}



export default App;

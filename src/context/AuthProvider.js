import React, { createContext, useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import config from '../api/axios';

const AuthContext = createContext({});

export const AuthProvider = ({ children }) => {
  const [auth, setAuth] = useState(() => {
    const storedAuth = localStorage.getItem('auth');
    return storedAuth ? JSON.parse(storedAuth) : { isLoggedIn: false };
  });

  const navigate = useNavigate();

  const login = async (email, password) => {
    try {
      const response = await config.localTestingUrl.post('/login', JSON.stringify({ email, password }));
      const { token, user } = response.data;
      console.log(response);
      setAuth({ isLoggedIn: true, token, user });
      localStorage.setItem('auth', JSON.stringify({ isLoggedIn: true, token, user }));

      navigate('/');
    } catch (error) {
      console.error('Login failed:', error);
      throw error;
    }
  };

  const logout = () => {
    setAuth({ isLoggedIn: false });
    localStorage.removeItem('auth');
    navigate('/login');
  };

  const checkAuth = () => {
    return auth.isLoggedIn;
  };

  useEffect(() => {
    // Auto-logout on token expiration or manual logout
    const storedAuth = JSON.parse(localStorage.getItem('auth'));
    if (storedAuth?.isLoggedIn) {
      setAuth(storedAuth);
    } else {
      setAuth({ isLoggedIn: false });
    }
  }, []);

  return (
      <AuthContext.Provider value={{ auth, login, logout, checkAuth }}>
        {children}
      </AuthContext.Provider>
  );
};

export default AuthContext;

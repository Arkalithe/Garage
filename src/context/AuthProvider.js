import jwtDecode from "jwt-decode";
import { createContext, useState } from "react";

const AuthContext = createContext({});

export const AuthProvider = ({ children }) => {
  const [auth, setAuth] = useState(() => {
    const accessToken = localStorage.getItem('accessToken');
    let role = null;
    
    
    if (accessToken) {
      const decodedToken = jwtDecode(accessToken);
      role = decodedToken.data.role;
      console.log(role)
    }
    
    return { accessToken, role };
  });

  return (
    <AuthContext.Provider value={{ auth, setAuth }}>
      {children}
    </AuthContext.Provider>
  );
};

export default AuthContext;
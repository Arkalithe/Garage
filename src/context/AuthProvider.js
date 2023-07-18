import jwtDecode from "jwt-decode";
import { createContext, useState } from "react";

const AuthContext = createContext({});

export const AuthProvider = ({ children }) => {
  const [auth, setAuth] = useState(() => {
    const accessToken = localStorage.getItem('accessToken');
    const currentTimestamp = Math.floor(Date.now() / 1000);

    let role = null;

    if (accessToken) {
      try {
        const decodedToken = jwtDecode(accessToken);
        const expToken = decodedToken.exp;

        if (expToken >= currentTimestamp) {
          role = decodedToken.data.role;
        } else {
          localStorage.removeItem('accessToken');
        }
      } catch (error) {
        console.error("Invalid token:", error);
        localStorage.removeItem('accessToken');
      }
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

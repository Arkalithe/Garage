import { useContext } from "react";
import AuthContext from "../context/AuthProvider";


const useAuth = () => {
  const { auth, setAuth } = useContext(AuthContext);

  const setAuthData = (data) => {
    setAuth(data);
    localStorage.setItem('accessToken', data.accessToken);
  };

  const logout = () => {
    setAuth({});
    localStorage.removeItem('accessToken');
  };

  return {
    auth: auth,   
    setAuth: setAuthData,
    logout: logout,
  };
}

export default useAuth;

import {createContext, useState, useEffect} from 'react'
import axios from 'axios'

export const UserContext = createContext();

export const Axios = axios.create({
    baseURL: 'http://localhost/garage/',
})

export const UserContextProvider = ({children}) => {
    const [theUser, setUser] = useState(null);
    const [wait, setWait] = useState(false);

    const registerUser = async ({email, password}) => {
        setWait(true);
        try{
            const {data} = await Axios.post('http://localhost/Garage/php/Register.php', {
                email,
                password
            });
            setWait(false);
            return data
        }
        catch(err){
            setWait(false);
            return{success:0, message:"Erreur Serveur"};
        }
    }

const loginUser = async ({email,password}) => {
    setWait(true);
    try{
        const {data} = await Axios.post('/php/Login.php', {
            email,
            password
        });
        if(data.success && data.token){
            localStorage.setItem('loginToken', data.token);
            setWait(false);
            return {success:1}
        }
        setWait(false);
        return {success:0, message:data.message};
    }
    catch(err){
        setWait(false);
        return{success:0, message:"Erreur Serveur"};
    }
}

const loggedInCheck = async () => {
    const loginToken = localStorage.getItem('loginToken');
    Axios.defaults.headers.common['Authorization'] = 'Bearer '+loginToken;
    if(loginToken){
        const {data} = await Axios.get('/php/getUser.php');
        if(data.success && data.user) {
            setUser(data.user);
            return;
        }
        setUser(null);
    }
}

useEffect(() => {
    async function asyncCall(){
        await loggedInCheck();
    }
    asyncCall();
}, []);

const logout = () => {
    localStorage.removeItem('loginToken');
    setUser(null);
}

return <UserContext.Provider value={{registerUser,loginUser,wait, user:theUser,loggedInCheck,logout}}>
    {children}
</UserContext.Provider>

}

export default UserContextProvider;
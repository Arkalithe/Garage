import axios from "axios";

export default axios.create({
    baseURL:"http://localhost/NewGarage",
    headers : {
        'Content-Type': 'application/json'        
    },
    withCredentials: true
});
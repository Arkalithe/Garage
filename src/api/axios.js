import axios from "axios";

export default axios.create({
    baseURL:"http://localhost/Garage",
    headers : {
        'Content-Type': 'application/json'        
    },
    withCredentials: true
});
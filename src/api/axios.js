import axios from "axios";

const localhost = axios.create({
    baseURL:"http://localhost",
    headers : {
        'Content-Type': 'application/json'        
    },
    withCredentials: true
});

const herokuUrl = axios.create({
    baseURL:"https://garagevparrotstudi-15b74863d868.herokuapp.com",
    headers : {
        'Content-Type': 'application/json'        
    },
    withCredentials: true
});

const config = {
    localTestingUrl: localhost,
    herokuTesting: herokuUrl

}

export default config
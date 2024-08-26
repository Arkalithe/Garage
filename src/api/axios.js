import axios from "axios";


const localhost = axios.create({
    baseURL:"https://127.0.0.1:8000",
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

localhost.interceptors.request.use(config => {
    return config;
}, error => {
    return Promise.reject(error);
});

herokuUrl.interceptors.request.use(config => {
    return config;
}, error => {
    return Promise.reject(error);
});

const config = {
    localTestingUrl: localhost,
    herokuTesting: herokuUrl

}
export default config
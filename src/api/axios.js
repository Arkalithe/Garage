import axios from "axios";

const localhost = axios.create({
    baseURL:"http://localhost/Garage",
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
    const token = localStorage.getItem('accessToken');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

herokuUrl.interceptors.request.use(config => {
    const token = localStorage.getItem('accessToken');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

const config = {
    localTestingUrl: localhost,
    herokuTesting: herokuUrl

}
export default config
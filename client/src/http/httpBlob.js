import axios from 'axios'

const $hostBlob = axios.create({
     baseURL: 'http://localhost:8000/', //process.env.REACT_APP_API_URL
     responseType: 'blob'
})

export {
    $hostBlob
}
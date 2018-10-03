import axios from 'axios'

const url = 'http://localhost:8000/'

export default axios.create({
    baseURL: url
})

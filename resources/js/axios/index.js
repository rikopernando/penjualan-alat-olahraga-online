import axios from 'axios'

const url = 'http://localhost:8000/'

const instance = axios.create({
    baseURL: url
})

export default instance.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': 'Bearer ' + Laravel.apiToken,
};

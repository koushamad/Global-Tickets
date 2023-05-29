import axios from 'axios'
import cookie from 'js-cookie'

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://' + window.location.host + '/api'
axios.defaults.headers.common['Authorization'] = 'Bearer ' + cookie.get('api-token')
axios.defaults.headers.post['Accept'] = 'application/json'
axios.defaults.headers.put['Content-Type'] = 'application/json'

export default axios


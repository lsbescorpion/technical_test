import Vue from 'vue'
import App from './components/App'
import router from './router/main'
import store from './store/main'
import axios from  'axios'


Vue.config.productionTip = false
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

new Vue({
  	router,
	store,
	render: h=> h(App)
}).$mount('#root')
require('./bootstrap');

import pay from './components/pay';

const app = new Vue({
	el: '#app',
	components: { pay }
});
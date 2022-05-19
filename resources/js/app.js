require('./bootstrap');

import cart from './components/cart';

const app = new Vue({
	el: '#app',
	components: { cart }
});
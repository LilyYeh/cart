require('./bootstrap');

import cart from './components/cart';
import user from './components/user';
import pay from './components/pay';

const app = new Vue({
	el: '#app',
	components: { cart, user, pay }
});
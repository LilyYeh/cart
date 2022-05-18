<style>
	.product{
		width:100%;
		height:210px;
		margin-bottom: 30px;
		text-align: center;
		border: 1px #cfd2d4 solid;
	}
	.product > div{
		float:left;
		width:23%;
		margin:1%;
	}
	.product input{
		width:60px;
	}
	#check{
		float: right;
	}
</style>

<template>
	<section>
		<h5>商品列表</h5>
		<div class="product">
			<div v-for="(p,index) in myProducts" :key="p.id">
				<p>
					<strong>{{p.name}}</strong><br>
					數量：<input type="number" :id="'qty'+p.id" :value="1" min="1" max="20"><br>
					顏色：{{p.color}}<br>
					價格：{{p.price}}
				</p>
				<button @click="addCart(p.id)">+購物車</button>
			</div>

			<div style="width:100%;text-align: center">
				<button @click="getProducts(-1)" :disabled="page <= 1">◀︎</button>
				<button @click="getProducts(1)" :disabled="page >= totalPage">▶︎</button>
			</div>
		</div>

		<h5>購物明細</h5>
		<table class="table">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>商品名稱</th>
					<th>數量</th>
					<th>顏色</th>
					<th>價格</th>
					<th>小計</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(c,index) in cart">
					<td>
						<button @click="deleteCart(c.id)">刪除</button>
					</td>
					<td>{{c.id}}</td>
					<td>{{c.name}}</td>
					<td><input type="number" :id="'c_qty'+c.id" :value="c.qty" min="1" max="20" @change="editCart($event,c.id)"></td>
					<td>{{c.color}}</td>
					<td>${{numberFormat(c.price)}}</td>
					<td>${{numberFormat(c.price*c.qty)}}</td>
				</tr>
				<tr>
					<td colspan="5"></td>
					<th>總計</th>
					<th>${{numberFormat(totalPay)}}</th>
				</tr>
			</tbody>
		</table>

		<a href="/user" id="check" type="button">結帳</a>
	</section>
</template>

<script>
	export default {
		//props: ['cart'],
		data: function () {
			return{
				domain:'/',
				products:[
					{
						id:1,
						name:'iphone SE',
						qty:2,
						color:'gold',
						price:1000
					},{
						id:2,
						name:'iphone 5',
						qty:2,
						color:'silver',
						price:500
					},{
						id:3,
						name:'iphone 6',
						qty:1,
						color:'gold',
						price:500
					},{
						id:4,
						name:'iphone 6s',
						qty:1,
						color:'rose gold',
						price:500
					},{
						id:5,
						name:'iphone 7',
						qty:3,
						color:'silver',
						price:200
					},{
						id:6,
						name:'iphone 7plus',
						qty:1,
						color:'rose gold',
						price:500
					},{
						id:7,
						name:'iphone 8',
						qty:1,
						color:'rose gold',
						price:500
					},{
						id:8,
						name:'iphone 8plus',
						qty:1,
						color:'gold',
						price:500
					},{
						id:9,
						name:'iphone XR',
						qty:1,
						color:'red',
						price:500
					},{
						id:10,
						name:'iphone 11pro',
						qty:3,
						color:'silver',
						price:200
					},{
						id:11,
						name:'iphone 11',
						qty:1,
						color:'silver',
						price:300
					}
				],
				myProducts:[],
				page:1,
				perPage:4,
				cart:[]
			}
		},
		computed: {
			totalPage: function() {
				let t1 = parseInt((this.products.length)/this.perPage);
				let t2 = (this.products.length)%this.perPage;
				if(t2>0) return t1+1;
				return t1;
			},
			totalPay: function() {
				let total=0;
				for(let i=0; i < this.cart.length; i++){
					total += this.cart[i].price * this.cart[i].qty;
				}
				return total;
			}
		},
		methods: {
			getAllProducts: function () {
				let self = this;
				axios.get(self.domain+'get/products')
					.then(function (response) {
						self.products = response.data;
						self.getProducts(0);
					})
					.catch(function (response) {
						console.log(response);
					});
			},
			getProducts: function (i) {
				let p_length = this.products.length;
				this.page = (this.page + i + p_length) % p_length;
				let start = (this.page-1)*this.perPage;
				let end = start+4;
				this.myProducts = this.products.slice(start,end);
			},
			getCart: function () {
				let self = this;
				axios.get(self.domain+'get/cart')
					.then(function (response) {
						let re = response.data.products;
						self.cart = Object.values(re).reverse();
					})
					.catch(function (response) {
						console.log(response);
					});
			},
			addCart: function (id) {
				let self = this;
				let mypro = this.products.find(el => el.id == id);
				mypro.qty = document.querySelector('#qty'+id).value;
				axios.put(self.domain+'add/cart', mypro)
					.then(function (response) {
						let re = response.data;
						if(re.status == "ok"){
							self.cart = Object.values(re.data.products).reverse();
						}else{
							alert(re.msg);
						}
					})
					.catch(function (response) {
						console.log(response);
					});
			},
			editCart: function (event,id) {
				let self = this;
				let qty = event.target.value;
				axios.post(self.domain+'edit/cart', {p_id: id, qty: qty})
					.then(function (response) {
						let re = response.data;
						if (re.status == "ok") {
							self.cart = Object.values(re.data.products).reverse();
						} else {
							alert(re.msg);
						}
					})
					.catch(function (response) {
						console.log(response);
					});
			},
			deleteCart: function (id) {
				let self = this;
				axios.delete(self.domain+'delete/cart', { params: { p_id:id }})
					.then(function (response) {
						let re = response.data.products;
						self.cart = Object.values(re).reverse();
					})
					.catch(function (response) {
						console.log(response);
					});
			},
			numberFormat: function (number) {
				return new Intl.NumberFormat('en-US', { maximumSignificantDigits: 3 }).format(number)
			}
		},
		mounted: function () {
			this.getAllProducts();
			this.getCart();
		}
	}
</script>

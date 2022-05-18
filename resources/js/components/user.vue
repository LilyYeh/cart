<template>
	<section>
		<h5>訂購人</h5>
		<p>姓名：<input type="text" value="name" v-model="name"></p>
		<p>聯絡電話：<input type="text" value="phone" v-model="phone"></p>
		<p>地址：<input type="text" style="width:300px" value="address" v-model="address" ></p>
		<p>email：<input type="text" style="width:300px" value="email" v-model="email" ></p>

		{{name}} | {{phone}} | {{address}} | {{email}}
	</section>
</template>

<script>
	export default {
		data: function () {
			return{
				name:'Lily Yeh',
				phone:'0932-298279',
				address:'台北市信義區信義路五段7號51樓',
				email:'lilyyeh@core-tech.com.tw'
			}
		},
		computed: {

		},
		methods: {

		},
		mounted: function () {

		}
	}
</script>
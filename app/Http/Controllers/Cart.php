<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Session;

class Cart extends BaseController
{
	public function get(){
		if(!Session::has('cart')){
			Session::put('cart',array('total'=>0,'products'=>array()));
		}
		$cart = Session::get('cart');

		$total = 0;
		foreach ($cart['products'] as $c){
			$total+=$c['price']*$c['qty'];
		}
		$cart['total'] = $total;
		Session::put('cart',$cart);
		return json_encode($cart);
	}
	
	public function add(Request $request){
		$result = array();
		$myproduct = $request->all();
		
		if($myproduct['qty']<=0){
			$result["status"] = "fail";
			$result["msg"] = "加入購物車至少一樣商品";
			return json_encode($result);
		}
		
		$cart = Session::get('cart');
		//$cart = empty($cart)? array() : $cart;
		$incart = false;
		foreach($cart['products'] as $k=>$c){
			if($myproduct['id']==$c['id']){
				$cart['products'][$k]['qty']+=$myproduct['qty'];
				$incart = true;
				break;
			}
		}
		if(!$incart){
			array_push($cart['products'],$myproduct);
		}
		
		Session::put('cart',$cart);
		$result["status"] = "ok";
		$result["data"] = Session::get('cart');
		return json_encode($result);
	}
	
	public function edit(Request $request){
		$result = array();
		$p_id = $request->input('p_id');
		$qty = $request->input('qty');
		
		if($qty<=0){
			$result["status"] = "fail";
			$result["msg"] = "加入購物車至少一樣商品";
			return json_encode($result);
		}
		
		$cart = Session::get('cart');
		foreach($cart['products'] as $k=>$c){
			if($p_id==$c['id']){
				$cart['products'][$k]['qty']=$qty;
				break;
			}
		}
		
		Session::put('cart',$cart);
		$result["status"] = "ok";
		$result["data"] = Session::get('cart');
		return json_encode($result);
	}
	
	public function delete(Request $request){
		$p_id = $request->input('p_id');
		$cart = Session::get('cart');
		$delete_key = "";
		foreach ($cart['products'] as $k=>$c){
			if($p_id==$c['id']){
				$delete_key = $k;
				break;
			}
		}
		
		unset($cart['products'][$delete_key]);
		array_values($cart['products']);
		Session::put('cart',$cart);
		return json_encode($cart);
	}
}

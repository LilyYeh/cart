<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Session;

class PayFlow extends BaseController
{
	public function createOrder(){
		$MerchantTradeNo = Session::get('MerchantTradeNo');
		$MerchantTradeNo = empty($MerchantTradeNo)? 1 : $MerchantTradeNo;
		Session::put('MerchantTradeNo',$MerchantTradeNo+1);
		
		$cart = Cart::get();
		
		$url = "https://payment-stage.ecpay.com.tw/SP/CreateTrade";
		//$url = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";
		$data= array(
			'ChoosePayment'=>'ALL', //固定傳 ALL
			'ClientBackURL'=>'http://google.com.tw', //付款後導回特店付款成功頁面
			'EncryptType'=>1,
			'ExpireDate'=>3, //ATM 允許繳費有效天數
			'ItemName'=>'手機20元X2#隨身碟60元X1', //*商品名稱
			'MerchantID' => '2000132', //*特店編號
			'MerchantTradeDate'=>date('Y/m/d H:i:s'), //*特店交易時間
			'MerchantTradeNo'=>'ecPay'.date('Ymd').($MerchantTradeNo+1), //*特店交易編號
			'PaymentInfoURL'=>'http://google.com.tw', //ATM 綠界回傳付款相關資訊
			'PaymentType'=>'aio', //*固定填入 aio
			'ReturnURL'=>'http://google.com.tw', //*付款完成通知回傳網址(Server POST)
			'TotalAmount'=>10, //*交易金額
			'TradeDesc'=>'LilyYeh購物商城', //*交易描述
		);

		//製造檢查碼
		$a = array('HashKey=5294y06JbISpM5x9');
		foreach ($data as $k=>$v){
			array_push($a,$k."=".$v);
		}
		array_push($a,'HashIV=v77hoKGq4kWxNNIS');
		$CheckMacValue = implode('&', $a);
		$CheckMacValue = urlencode($CheckMacValue);
		$CheckMacValue = strtolower($CheckMacValue);
		$CheckMacValue = str_replace("%20","+", $CheckMacValue);
		$CheckMacValue = hash('sha256', $CheckMacValue);
		$CheckMacValue = strtoupper($CheckMacValue);
		$data['CheckMacValue'] = $CheckMacValue;
		//var_dump($data);
		
		//產生綠界訂單
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		$re = json_decode($output,true);
		
		return view('pay',['SPToken'=>$re['SPToken']]);
	}
}
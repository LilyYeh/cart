<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;

class Products extends BaseController
{
	public function get(){
		$products = DB::table('products')->get();
		return json_encode($products);
	}
}
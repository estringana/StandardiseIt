<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Standard;

class StandardsController extends Controller
{
	public function show($id)
	{
		$standard = Standard::find($id);

		return view('standards.show', ['standard' => $standard]);
	} 
}

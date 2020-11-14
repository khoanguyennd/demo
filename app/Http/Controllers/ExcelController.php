<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
class ExcelController extends Controller
{
    public function getExcel(){
    	return view('uploadExcel');
    }
    public function postExcel(Request $request){

    	$file=$request->file;

    	Excel::Import(new ExcelImport, $file);
    	
    }
}

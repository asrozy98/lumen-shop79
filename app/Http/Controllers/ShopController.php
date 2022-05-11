<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Imports\ShopImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ShopController extends Controller
{
    public function index()
    {
        $shop = Shop::paginate(10);

        return view('shop.index', compact('shop'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Format File not valid.']);
        }
        $file = $request->file('file');
        Excel::import(new ShopImport, $file);

        return response()->json(['success' => true, 'message' => 'Data Imported successfully.']);
    }
}

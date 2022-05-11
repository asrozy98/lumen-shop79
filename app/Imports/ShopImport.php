<?php

namespace App\Imports;

use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;

HeadingRowFormatter::default('none');

class ShopImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $shop = Shop::where('code', $row['Product_Code'])->first();
        if ($shop) {
            $shop->increment('stock', $row['Product_Stock']);
        } else {
            $shop = new Shop;
            $shop->name = $row['Product_Name'];
            $shop->code = $row['Product_Code'];
            $shop->stock = $row['Product_Stock'];
            $shop->price = $row['Price'];
            $shop->description = $row['Description'];
            $shop->save();
        }

        return $shop;
    }

    // public function rules(): array
    // {
    //     return [
    //         'Nama' => 'required|string|min:2|max:100',
    //         '*.Nama' => 'required|string|min:2|max:100',
    //         'NIM' => 'required|min:2|max:15',
    //         '*.NIM' => 'required|min:2|max:15',
    //         'Email' => 'required|string|email|max:100|unique:users',
    //         '*.Email' => 'required|string|email|max:100|unique:users',
    //         'Password' => 'required|min:6',
    //         '*.Password' => 'required|min:6',
    //         'Alamat' => 'required|string|min:2|max:100',
    //         '*.Alamat' => 'required|string|min:2|max:100',
    //         'Tanggal Lahir' => 'required|date',
    //         '*.Tanggal Lahir' => 'required|date',
    //         'Jurusan' => 'required|string|min:2|max:100',
    //         '*.Jurusan' => 'required|string|min:2|max:100',
    //     ];
    // }
}

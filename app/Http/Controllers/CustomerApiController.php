<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'telp' => 'numeric',
        ]);

        try {
            $customer = Customer::create($input);
        } catch (QueryException $e) {
            logger($e);
            return response(['errors' => [
                'kode' => [ 'Kode Customer duplikat!' ],
            ]], 422);
        }

        return $customer;
    }
}

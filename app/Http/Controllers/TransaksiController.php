<?php

namespace App\Http\Controllers;

use App\Facades\TransaksiFacade;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\SaleItems;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $transaksiList = [];
        if ($request->query('q')) {
            $transaksiList = Sales::rightJoin('customers', 'sales.customer_id', '=', 'customers.id')
                ->where('customers.nama', 'like', "%$request->q%")
                ->get([
                'sales.kode', 'sales.tgl', 'customers.nama as namaCustomer', 'sales.jumlah_barang', 'sales.subtotal', 'sales.diskon', 'sales.ongkir', 'sales.total_bayar'
                ]);
        } else {
            $transaksiList = Sales::with('customer')->get();
        }

        return inertia('Transaksi/Index', [
            'semuaTransaksi' => $transaksiList,
            'grandTotal' => Sales::select(DB::raw('SUM(total_bayar) as grandTotal'))->with('customer')->first(),
        ]);
    }

    public function create()
    {
        return inertia('Transaksi/Create', [
            'semuaCustomer' => Customer::all(),
            'semuaBarang' => Barang::all(),
        ]);
    }

    public function store(Request $request, TransaksiFacade $transaksiFacade)
    {
        $input = $request->validate([
            'tgl' => 'date|required',
            'customer_id' => 'integer|required',
            'barang' => 'array|required',
            'diskon' => 'integer',
            'ongkir' => 'integer',
        ]);

        $input['user_id'] = auth()->user()->id;
        $input['kode'] = str_replace('-', '', $input['tgl']);
        $input['jumlah_barang'] = 0;
        $input['subtotal'] = 0;
        $input['total_bayar'] = 0;

        $transaksiFacade->store($input);

        return redirect(route('transaksi.index'));
    }
}

<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
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

        DB::beginTransaction();
        $sale = Sales::create($input);

        $potongan = fn ($harga, $diskon) => ($harga / 100 * $diskon);
        $hargaDiskon = fn ($harga, $diskon) => $harga - $potongan($harga, $diskon);
        $total = fn ($harga, $qty) => $harga * $qty;
        
        foreach ($input['barang'] as $v) {
            $saleItems = SaleItems::create([
                'sale_id' => $sale->id,
                'barang_id' => $v['id'],
                'harga_bandrol' => $v['harga'],
                'qty' => $v['qty'],
                'diskon_persen' => $v['diskon'],
                'diskon_nilai' => $potongan($v['harga'], $v['diskon']),
                'harga_diskon' => $hargaDiskon($v['harga'], $v['diskon']),
                'total' => $total($hargaDiskon($v['harga'], $v['diskon']), $v['qty']),
            ]);

            $sale->subtotal += $saleItems->total;
            $sale->jumlah_barang += $saleItems->qty;
        }
        $sale->kode = $sale->kode . $sale->id;
        $sale->total_bayar = $sale->subtotal - $sale->diskon + $sale->ongkir;
        $sale->save();
        DB::commit();

        return redirect(route('transaksi.index'));
    }
}

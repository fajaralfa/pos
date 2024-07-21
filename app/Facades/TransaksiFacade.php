<?php

namespace App\Facades;

use App\Models\SaleItems;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;

class TransaksiFacade
{
    public function store($input)
    {
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
    }
}
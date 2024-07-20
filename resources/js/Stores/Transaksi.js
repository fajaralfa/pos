import { defineStore } from "pinia";

export const useTransaksiStore = defineStore('transaksi', {
    state: () => ({
        no: 0,
        tgl: '',
        customer: null,
        barang: [],
        diskon: 0,
        ongkir: 0,
    }),

    getters: {
        requestPayload: (state) => ({
            tgl: state.tgl,
            customer_id: state.customer?.id,
            barang: state.barang.map(v => ({ id: v.id, harga: v.harga, qty: v.qty, diskon: v.diskon })),
            diskon: state.diskon,
            ongkir: state.ongkir,
        }),
        customerIsSelected: (state) => Boolean(state.customer),
        potonganBarang: (state) => {
            return (index) => state.barang[index].harga / 100 * state.barang[index].diskon
        },
        hargaDiskonBarang: function (state) {
            return (index) => state.barang[index].harga - this.potonganBarang(index)
        },
        subtotalBarang: function (state) {
            return (index) => this.hargaDiskonBarang(index) * state.barang[index].qty
        },
        subtotal: function (state) {
            let subtotal = 0
            for (let i = 0; i < state.barang.length; i++) {
                subtotal += this.hargaDiskonBarang(i) * state.barang[i].qty
            }
            return subtotal
        },
        total: function (state) {
            return this.subtotal - state.diskon + Number(state.ongkir) // bug type ongkir string
        },
        barangIsEmpty: function() {
            return this.requestPayload.barang.length === 0
        },
    },

    actions: {
        setTanggal(tgl) {
            this.tgl = tgl
        },
        setCustomer(customer) {
            this.customer = customer
        },
        pushBarang(barang) {
            this.barang.push(barang)
        },
        removeBarang(index) {
            this.barang.splice(index, 1)
        },
        replaceBarang(index, barang) {
            this.barang[index] = barang
        },
        setDiskon(diskon) {
            this.diskon = diskon
        },
        setOngkir(ongkir) {
            this.ongkir = ongkir
        },
    }
})
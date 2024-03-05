<template>
    <div class="q-pa-md">
        <q-card bordered>
            <q-card-section>
                <div class="row q-col-gutter-sm">
                    <div class="col-12 col-md-4">
                        <q-input v-model="cari" dense outlined label="cari pelanggan" @keypress="cariData">
                            <template v-slot:append>
                                <q-icon name="search" />
                            </template>
                        </q-input>
                    </div>
                </div>
                <q-separator class="q-my-sm"/>
                <div class="text-uppercase">
                    <q-input label="NAMA PELANGGAN" v-model="pelanggan.namaPelanggan" readonly>
                        <template v-slot:prepend>
                                <q-icon name="person" />
                            </template>
                    </q-input>
                    <q-input label="ALAMAT" v-model="pelanggan.alamat" readonly>
                        <template v-slot:prepend>
                                <q-icon name="contact_mail" />
                            </template>
                    </q-input>
                    <q-input label="NOMOR HANDPHONE" v-model="pelanggan.nomorTelpon" readonly>
                        <template v-slot:prepend>
                                <q-icon name="call" />
                            </template>
                    </q-input>
                </div>
            </q-card-section>
        </q-card>
        <q-card class="q-mt-md">
            <q-card-section>
                <div class="row justify-end">
                    <div>
                        <q-btn @click="modal=true" label="Tambah Produk" icon="add" color="blue"/>
                    </div>
                </div>
            </q-card-section>
            <q-card-section>
                <q-markup-table separator="cell">
                    <thead class="bg-blue-10">
                        <tr class="text-white">
                            <th>NAMA PRODUK</th>
                            <th>HARGA SATUAN</th>
                            <th>JUMLAH</th>
                            <th>TOTAL</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-for="lst in details" :key="lst.id">
                            <td>{{ lst.namaProduk }}</td>
                            <td>{{ lst.harga }}</td>
                            <td>{{ lst.jumlahProduk }}</td>
                            <td class="text-center">
                                <!-- <q-input outlined v-model="form.total" dense/> -->
                                Rp.{{ lst.harga*lst.jumlahProduk }}
                            </td>
                            <td class="text-center q-pa-xs">
                                <total :subtotal="lst.harga*lst.jumlahProduk" :produk_id="lst.id"/>
                                <q-btn  @click="hapusList(lst.id)"  round flat color="red" class="q-ml-xs" icon="delete"></q-btn>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-bold text-left">JUMLAH: Rp. {{ totalHarga }}</td>
                        </tr>
                    </tbody>
                </q-markup-table>
            </q-card-section>
        </q-card>
    </div>
    <q-dialog v-model="modal"> d
        <q-card style="width:500px">
            <q-toolbar>
                <q-toolbar-title>Tambah Barang</q-toolbar-title>
                <q-space/>
                <q-btn icon="cancel" @click="batal" round flat unelevated/>
            </q-toolbar>
            <q-card-section>
                <q-form class="q-gutter-sm">
                    <q-select :options="pilihans"
                    outlined
                    label="Pilih Barang"
                    emit-value option-value="id" v-model="form.produk_id" option-label="namaProduk" map-options/>
                    <q-input outlined label="jumlah"  type="number" v-model="form.jumlah" />
                    <div class="text-right q-gutter-sm">
                        <q-btn @click="simpanProduk" label="simpan" icon="save" color="primary"/>
                        <q-btn @click="batal" label="batal"  icon="cancel" color="grey"/>
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script>

import layout from '../layout/layout.vue';
import axios from "axios";
import { onMounted, reactive, ref, computed } from 'vue';
import total from '../components/total.vue'
import { useControll } from '../store/control';
export default {
    layout: layout,

components:{
    total,
},

setup(){
    const controll=useControll();
    const cari=ref(null)
    const stok = ref(null);
    const pelanggan=ref("")
    function cariData(){
        axios.get('/caripelanggan',{params:{ cari:cari.value }}).then((res)=>{
            pelanggan.value=res.data
            form.pelanggan_id=res.data.id
            getDetail()
            return res
        })
    }
    const pilihans=ref([])
    function getBarang(){
        axios.get('/setbarang').then((res)=>{
            pilihans.value=res.data
            // console.log(res.data)
            return res
        })
    }
    const rows=ref([])

    const modal=ref(false)
 
    const form=reactive({
        id:"",
        np:"",
        harga:"",
        produk_id:"",
        jumlah:"",
        subTotal:"",
        pelanggan_id:"",
        total:""
    })
    function batal(){
        form.id=""
        form.produk_id=""
        form.jumlah=""
        modal.value=false
         
    }
    function simpanProduk(){
        const produk = pilihans.value.find(produk => produk.id === form.produk_id);
        const stokTersedia = produk.stok;

        if (form.jumlah > stokTersedia) {
        alert('Stok tidak mencukupi! Stok tersedia: ' + stokTersedia); 
        return; 
    }

        axios.post('/produkSimpan', form).then((res)=>{
            batal()
            getDetail()
            controll.trigger=!controll.trigger
            return res
        })
    }

    function tambah(){
        axios.post('/')
    }
    const details=ref([])
    const totalHarga=ref(0)
    function getDetail(){
        axios.get('/detailproduk/'+form.pelanggan_id).then((res)=>{
            details.value=res.data
            totalHarga.value=computed(()=>{
                return details.value.reduce((acc,tot)=>{
                    return acc+(tot.harga*tot.jumlahProduk)
                },0)
            })
            details.value=res.data
        })
    }
    function updateTotal(total){
        axios.get('/updatetotal/'+total).then((res)=>{
            return res
        })
    }

    function hapusList(id){
        axios.get('/hapusList/'+id).then((res)=>{
                batal()
                getDetail()
                return res
             })
    }
    
    onMounted(()=>{
        getBarang()
    })

    return{
        stok,
        cariData,
        batal,
        tambah,
        simpanProduk,
        getDetail,
        updateTotal,
        details,
        rows,
        modal,
        form,
        hapusList,
        pelanggan,
        cari,
        pilihans,
        totalHarga,
        controll,
    }

    
}


};
</script>
<style></style>

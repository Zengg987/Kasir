<template>
 <div class="q-pa-md">
        <div class="row justify-end">
            <div>
                <q-btn label="Tambah Barang" @click="modal=true" icon="add" color="green-10" class="q-my-sm"/>
            </div>
        </div>
        <q-markup-table separator="cell" bordered flat class="shadow-2 text-center"> 
            <thead class="bg-blue-10">
                <tr class="text-white">
                    <th>No</th>
                    <th>Produk</th>
                    <th>harga</th>
                    <th>stok</th>
                    <!-- <th>sisa stok</th> -->
                    <th>aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in rows" :key="index++">  
                    <td>{{ index }}</td>
                    <td>{{ row.namaProduk }}</td>
                    <td> Rp.{{ row.harga }}</td>
                    <td>{{ row.stok }}</td>
                    <!-- <td>
                        <stok :stok="row.stok" :id="row.id"/>
                    </td> -->
                  
                    
                    <td>
                        <q-btn @click="hapus(row.id)" icon="delete" round flat color="red"></q-btn>
                        <q-btn @click="edit(row.id)" icon="edit" round flat class="q-mx-xs" square color="blue"></q-btn>
                    </td>
                                               
                </tr>
            </tbody>
        </q-markup-table>
    </div>
<q-dialog v-model="modal" >
    <q-card style="width:500px">
        <q-toolbar>
          <q-toolbar-title>Barang Detail</q-toolbar-title>
         <q-btn roind flat icon="close" @click="batal" unlevated></q-btn>
    </q-toolbar>
        <q-card-section>
            <q-form class="q-gutter-sm">
                <q-input outlined v-model="form.nama" label="Nama Produk"/>
                <q-input outlined v-model="form.harga" label="Harga" type="number"/>
                <q-input outlined v-model="form.stok" label="Stok" type="number"/>
                
                <div class="text-right q-gutter-sm">
                    <q-btn label="simpan" @click="simpan" icon="save" color="green"/>
                    <q-btn label="batal" @click="batal" icon="cancel" color="red" />
                </div>
            </q-form>
        </q-card-section>
    </q-card>
</q-dialog>


</template>

<script>

import layout from '../layout/layout.vue';
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
export default {
    layout: layout,

    setup() {
      
        const modal = ref(false)
        const form = reactive({
            id: "",
            nama: "",
            harga: "",
            stok: 0,
           
        });

        function batal() {
         form.id =""
         form.nama=""
         form.harga=""
         form.stok=0
         modal.value = false
        }

        const rows = ref([]);
        function getData(){
            axios.get('/barang/tampil').then((res)=>{
                rows.value=res.data;
                return res
            })
        }

        onMounted(()=>{
            getData()
        }) 

        function simpan(){
            axios.post('/barang/tambah', form).then((res)=>{
                batal()
                getData()
                return res
            }) 
        }

        function edit(id){
            axios.get('/barang/edit/'+id).then((res)=>{
                batal()
                modal.value=true
                form.id=res.data.id
                form.nama=res.data.namaProduk
                form.harga=res.data.harga
                form.stok=res.data.stok
                return res
            }) 
            
        }

        function hapus(id){
             axios.get('/barang/hapus/'+id).then((res)=>{
                batal()
                getData()
                return res
             })
        }
        

        return {
           form,
           modal,
           batal,
            rows,
           simpan,
           edit,
           hapus
        }

    }

}
</script>

<style>

</style>
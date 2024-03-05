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
                     <th>Nama</th>
                     <th>Alamat</th>
                     <th>No Telp</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
             <tbody>
                 <tr v-for="(row,index) in rows" :key="index++">  
                     <td>{{ index }}</td>
                     <td>{{ row.namaPelanggan }}</td>
                     <td>{{ row.alamat }}</td>
                     <td>{{ row.nomorTelpon }}</td>
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
           <q-toolbar-title>Pelanggan</q-toolbar-title>
          <q-btn roind flat icon="close" @click="batal" unlevated></q-btn>
     </q-toolbar>
         <q-card-section>
             <q-form class="q-gutter-sm">
                 <q-input outlined v-model="form.nama" label="Nama pelanggan"/>
                 <q-input outlined v-model="form.alamat" label="Alamat" />
                 <q-input outlined v-model="form.noTelp" label="Nomor telpon" />
                 
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
             alamat: "",
             noTelp: "",
            
         });
 
         function batal() {
          form.id =""
          form.nama=""
          form.alamat=""
          form.noTelp=""
          modal.value = false
         }
 
         const rows = ref([]);
         function getData(){
             axios.get('/pelanggan/view').then((res)=>{
                 rows.value=res.data;
                 return res
             })
         }
 
         onMounted(()=>{
             getData()
         }) 
 
         function simpan(){
             axios.post('/pelanggan/tambah', form).then((res)=>{
                 batal()
                 getData()
                 return res
             }) 
         }
 
         function edit(id){
             axios.get('/pelanggan/edit'+id).then((res)=>{
                 batal()
                 modal.value=true
                 form.id=res.data.id
                 form.nama=res.data.namaPelanggan
                 form.alamat=res.data.alamat
                 form.noTelp=res.data.nomorTelpon
                 return res
             }) 
             
         }
 
         function hapus(id){
              axios.get('/pelanggan/hapus'+id).then((res)=>{
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
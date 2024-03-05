<template>
    <div class="q-pa-md">
        <div class="row justify-end">
            <div>
                <q-btn label="Tambah User" @click="modal=true" icon="add" color="green-10" class="q-my-sm"/>
            </div>
        </div>
        <q-markup-table separator="cell" bordered flat class="shadow-2 text-center"> 
            <thead class="bg-blue-10">
                <tr class="text-white">
                    <th>Name</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in rows" :key="row.id">  
                    <td>{{ row.name }}</td>
                    <td>{{ row.username }}</td>
                    <td>{{ row.email }}</td>
                    <td>{{ row.role }}</td> 
                    <td>
                        <q-btn @click="hapus(row.id)" icon="delete" round flat color="red"></q-btn>
                        <q-btn @click="edit(row.id)" icon="edit" round flat class="q-mx-xs" square color="blue"></q-btn>
                    </td>
                                               
                </tr>
            </tbody>
        </q-markup-table>
    </div>
<q-dialog v-model="modal">
    <q-card style="width:500px">
        <q-toolbar>
          <q-toolbar-title>User</q-toolbar-title>
         <q-btn roind flat icon="close" @click="batal" unlevated></q-btn>
    </q-toolbar>
        <q-card-section>
            <q-form class="q-gutter-sm">
                <q-input outlined v-model="form.name" label="nama"/>
                <q-input outlined v-model="form.username" label="username"/>
                <q-input outlined v-model="form.email" label="e-mail"/>
                <q-input outlined v-model="form.password" label="password" :rules="[val => val.length >= 12 || 'Password minimal 12 karakter']" />
                <q-select v-model="form.role" label="role" :options="['admin','petugas']" outlined rounded/>
                <div class="text-right q-gutter-sm">
                    <q-btn label="simpan" @click="simpan" icon="save" color="green"/>
                    <q-btn label="batal" @click="batal" icon="save" color="red" />
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
            name: "",
            username: "",
            email: "",
            role: "",
            password: "",
        })

        function batal() {
                form.id = "",
                form.name = "",
                form.username = "",
                form.email = "",
                form.role = "",
                form.password = "",
                modal.value = false 


        }

        function simpan(){
            axios.post('/addUser', form).then((res)=>{
                batal()
                getData()
                return res
            }) 
        }

        

        function edit(id){
            axios.get('/addUser/edit/'+id).then((res)=>{
            modal.value=true
              form.id=res.data.id
              form.name=res.data.name
              form.username=res.data.username
              form.email=res.data.email
              form.password=res.data.password
              form.role=res.data.role
              return res

            })
        }

        function hapus(id){
            axios.get('/addUser/delete/'+id).then((res)=>{
             batal()
             getData()
             return res

            })
        }

        const rows=ref([])
        function getData(){
            axios.get('/userGet').then((res)=>{
                rows.value = res.data

                return res
            })
        }

        onMounted(()=>{
            getData()
        
        })

        return {
            modal,
            form,
            batal,
            simpan,
            rows,
            edit,
            hapus
        
        }

    }

}
</script>

<style></style>
<template>
    <div class="q-pa-md ">
        <div class="row q-col-gutter-md">

            <div class="col-12 col-md-3 font-mono">
                <q-card>
                    <q-card-section class="bg-green text-white">
                        <div class="text-h3 text-center">{{ barang }}</div>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <div class="text-subtitle1 text-center">TOTAL BARANG</div>
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-md-3 font-mono">
                <q-card>
                    <q-card-section class="bg-blue text-white">
                        <div class="text-h3 text-center">{{ pelanggan }}</div>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <div class="text-subtitle1 text-center">JUMLAH PELANGGAN</div>
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-md-3 font-mono">
                <q-card>
                    <q-card-section class="bg-primary text-white ">
                        <div class="text-h3 text-center">Rp.{{ total_pemasukan }}</div>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <div class="text-subtitle1 text-center">TOTAL PEMASUKAN</div>
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-md-3 font-mono">
                <q-card>
                    <q-card-section class="bg-red text-white ">
                        <div class="text-h3 text-center">{{ topa }}</div>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <div class="text-subtitle1 text-center">PETUGAS</div>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </div>
</template>
    
<script>
import { computed, onMounted, ref } from 'vue'
import layout from '../layout/layout.vue'
import axios from 'axios'
export default {
    layout: layout,
    setup() {
        const barang = ref(0)
        const pelanggan = ref(0)
        const pemasukan = ref([])
        const topa =ref(0)

        const total_pemasukan=computed(()=>{
    return pemasukan.value.reduce((acc,pem)=>{
      return acc+parseFloat(pem.subTotal)
    },0)
  })    

        function getData() {
            axios.get('/info').then((res) => {
                barang.value = res.data.tobar
                pelanggan.value = res.data.jupel
                pemasukan.value = res.data.tomas
                topa.value = res.data.topa
                return res
            })
        }
        onMounted(() => {
            getData()
        })

        return {
            barang,
            pelanggan,
            pemasukan,
            total_pemasukan,
            topa,
        }
    }
}
</script>
    
<style></style>
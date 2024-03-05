<template>
    <q-layout>
        <q-page-container>
            <q-page class="bg-slate-800 row justify-center items-center">
                <img src="" alt="">
                <div class="column">
                    <div class="row">
                        <q-card style="width: 500px;" bordered class="q-pa-lg shadow-current shadow-lg ">
                            <q-card-section>
                                <p class="text-center font-bold text-2xl underline font-mono">LOGIN KANG</p>
                                <q-form class="q-py-md">
                                    <q-input v-model="form.username" label="username" fillded outlined square
                                        class="mb-3" />
                                    <q-input v-model="form.password" label="password" type="password" fillded outlined
                                        square />
                                    <div class="q-py-md">
                                        <q-btn @click="login"  label="L O G I N" class="full-width mt-4" color="blue" />
                                    </div>
                                </q-form>
                            </q-card-section>

                        </q-card>
                    </div>
                </div>
            </q-page>
        </q-page-container>
    </q-layout>
</template>

<script>
import { router } from '@inertiajs/vue3'
import { reactive, ref, } from 'vue'
export default {
    setup() {
        const form = reactive({
            username: '',
            password: '',
        })
        function reset(){
            form.username = '',
            form.password = ''
        }
        function login() {
            router.post('/login',form)
            reset()
        }
        return {
            form,
            login,
            reset
        }
    }
}
</script>

<style></style>
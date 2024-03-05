import { defineStore } from "pinia";
export const useControll=defineStore('controll',{
    state:()=>({
        trigger:false,
    })
})
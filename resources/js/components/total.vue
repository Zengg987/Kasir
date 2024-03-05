<template>
 
</template>
<script>
import { reactive,onMounted,watch} from 'vue'
import axios from 'axios'
import { useControll } from '../store/control'
export default {
props:["produk_id","subtotal"],
setup(props){
  const controll=useControll();
const form=reactive({
  total:""
})
function updateSub(){
  axios.get('/subtotalUpdate/'+props.subtotal+'/'+props.produk_id).then((res)=>{
      console.log(res.data)
      return res
      
  })
}

watch(()=>controll.trigger,()=>{
        updateSub()
    })

    onMounted(()=>{
        updateSub()
    })
return{
  form,
  updateSub,
  controll,
}
}
}
</script>

<style>

</style>

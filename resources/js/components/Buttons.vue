<template>
    <div v-if="getValues.length" class="container pt-1">
        <div class="d-flex flex-column bd-highlight mb-3">
            <div class="p-1">
                <button @click="postData('operaterUp-OPERATER_UP')" 
                type="button" 
                class="btn btn-success btn-block bd-button btn-height"
                >Dizanje balona</button>
            </div>
            <div class="p-1 ">
                <button @click="postData('operaterDown-OPERATER_DOWN')" 
                type="button"  
                class="btn btn-danger btn-block bd-button-danger btn-height"
                >Spuštanje balona</button>
            </div>
            <div class="p-1 ">
                <button @click="postData('ledOn-LED_ON')"
                type="button" 
                class="btn btn-success btn-block bd-button btn-height"
                >Uključi svetla</button>
            </div>
            <div class="p-1 ">
                <button @click="postData('ledOff-LED_OFF')" 
                type="button"  
                class="btn btn-danger btn-block bd-button-danger btn-height"
                >Isključi svetla</button>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
    name: "Buttons",
    data () {
        return {
            data: ''
        }
    },
    computed:mapGetters(["getValues"]),
    methods:{
      async postData(val){
        const arr = [val];
        const obj = {};
        arr.forEach(string => {
        const [key, value] = string.split("-");
        obj[key] = value;
        });
      await axios.post('/api/settings', {
         obj
      },
      )
        .catch(function (error) {
      });
    } 
    }
}
</script>
<style scoped>
    .bd-button {
        border: 2px solid black !important;
        color: black;
        background:#F8FAFC !important;
        outline: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }
    .bd-button:hover{
         color: white;
         background:#38c172 !important;
    }
    .bd-button:active{
         color: white;
         background:#0b9946 !important;
    }
    .bd-button-danger {
        border: 2px solid black !important;
        color: black;
        background:#F8FAFC !important;
        outline: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }
    .bd-button-danger:hover{
         color: white;
         background:#e6241d !important;
    }
    .bd-button-danger:active{
         color: white;
         background:#860c08 !important;
    }
    .btn-height{
        height:57px
    }
    .bd-highlight{
        padding-top: 6px !important;
    }
</style>
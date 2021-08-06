<template>
  <div id="form">
    <form @submit.prevent="postData" novalidate="true">
    <div v-if="errors.length" class="alert alert-danger text-justify" role="alert">
      <p class="text-center">
      <strong >{{ errors }}</strong>
     </p>
    </div>
    <div v-if="success.length" class="alert alert-success text-justify" role="alert">
      <p class="text-center">
      <strong >{{ success }}</strong>
     </p>
    </div>
    <div class="form-group form-input">
      <label for="avregingTime">Broj odbiraka za usrednjavanje</label>
      <input  type="number" class="form-control form-input" name="avregingTime" id="avregingTime" v-model="data.avregingTime" :placeholder="data.avregingTime">
    
      <label for="risingWindTreshold">Donja granica brzine vetra</label>
      <div class="input-group">
        <input type="number" class="form-control" name="risingWindTreshold" id="risingWindTreshold"  v-model="data.risingWindTreshold" :placeholder="data.risingWindTreshold" aria-describedby="inputGroupPrepend" required step="any">
        <div class="input-group-prepend form-input">
          <span class="input-group-text" id="inputGroupapend">km/h</span>
        </div>
      </div>
    
      <label for="fallingWindTreshold">Gornja granica brzine vetra</label>
      <div class="input-group">
        <input type="number" class="form-control" name="fallingWindTreshold" id="fallingWindTreshold"  v-model="data.fallingWindTreshold" :placeholder="data.fallingWindTreshold" aria-describedby="inputGroupPrepend" required step="any">
        <div class="input-group-prepend form-input">
          <span class="input-group-text" id="inputGroupapend">km/h</span>
        </div>
      </div>
    
      <label for="risingWindTimeDelay">Vremenski interval procene za podizanje balona</label>
      <div class="input-group">
       <vue-timepicker  input-class="time-picker" input-width="100%"  name="risingWindTimeDelay" id="risingWindTimeDelay" format="HH:mm:ss" v-model="data.risingWindTimeDelay" :placeholder="this.ifIsNull(data.risingWindTimeDelay)"></vue-timepicker>

      <label for="fallingWindTimeDelay">Vremenski interval procene za spuštanje balona</label>
       <vue-timepicker input-width="100%"  name="fallingWindTimeDelay" id="fallingWindTimeDelay" format="HH:mm:ss" v-model="data.fallingWindTimeDelay" :placeholder="this.ifIsNull(data.fallingWindTimeDelay)"></vue-timepicker>
    </div>
    
      <label for="ledDelay">Interval za isključivanje ledova</label>
       <vue-timepicker input-class="time-picker" input-width="100%"  name="ledDelay" id="ledDelay" format="HH:mm:ss" v-model="data.ledDelay" :placeholder="this.ifIsNull(data.ledDelay)"></vue-timepicker>
   
      <label for="risingInterval">Period podizanja balona</label>
       <vue-timepicker input-class="time-picker" input-width="100%"  name="risingInterval" id="risingInterval" format="HH:mm:ss" v-model="data.risingInterval" :placeholder="this.ifIsNull(data.risingInterval)"></vue-timepicker>
    
      <label for="loweringInterval">Period spuštanja balona</label>
       <vue-timepicker input-class="time-picker" input-width="100%"  name="loweringInterval" id="loweringInterval" format="HH:mm:ss" v-model="data.loweringInterval" :placeholder="this.ifIsNull(data.loweringInterval)"></vue-timepicker>
   
    </div> 
        <button  class="btn btn-primary" type="submit">Pošalji</button>
    </form>
  </div>
</template>
<script>

import VueTimepicker from 'vue2-timepicker'
import moment from 'moment';
export default {
  name: "Form",
   created(){  
    this.getDate();
  }
  ,
  data () {
    return {
      success: '',
      errors: '',
      data :{ 
        avregingTime: '1',
        risingWindTreshold: '2',
        fallingWindTreshold: '3',
        risingWindTimeDelay: '00:00:01',
        fallingWindTimeDelay: '00:00:02',
        ledDelay: '00:00:03',
        risingInterval: '00:00:04',
        loweringInterval: '00:00:05',
      }
    }
  },

   methods:{
 
    ifIsNull(value){ 
      // I have to use this function to check if value is null because timepicker trows an error 
      if (value === undefined || value === null){
        return '00:00:00'
      }else{
        return value
      }
    },
  
    async getDate(){ 
      const response = await axios.get('/api/settings')
      if (response){
       let value = response.data
        let i;
        for (i = 0; i < 3; i++) {  // prefill the data for the numbers
            this.data[Object.keys(this.data)[i]]=value[i].split(":")[1];
        }
        for (i = 3; i < 8; i++) { // prefill the data for the time string
            this.data[Object.keys(this.data)[i]]=
            moment().startOf('day').seconds(value[i].split(":")[1]).format('HH:mm:ss');  
        }   
      }
    },
    succesFunc(){
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
      setTimeout(()=>{   
      this.success = ''
    },2000)
    },
    async postData()
    {
  
      if (!this.data.avregingTime       
      || !this.data.risingWindTreshold 
      || !this.data.fallingWindTreshold 
      || !this.data.risingWindTimeDelay 
      || !this.data.fallingWindTimeDelay 
      || !this.data.ledDelay            
      || !this.data.risingInterval 
      || !this.data.loweringInterval
      ) {
       document.body.scrollTop = 0;
       document.documentElement.scrollTop = 0;
       return this.errors = "POPUNITE SVA POLJA";
      }else{
        this.errors = "";
      }
      await axios.post('/api/settings', {
         data: this.data,
      },
      )
        .then(response => (this.success = response.data),this.succesFunc())
        .catch(function (error) {
      });
    }  
  },
  components: {
    VueTimepicker
  }

}  

</script>

<style lang="css">
.time-picker input[type="text"] {
    height:40px;
    border-radius: 5px;
    margin-bottom: 1rem;
}
.form-input {
  margin-bottom: 1rem;
}
</style>


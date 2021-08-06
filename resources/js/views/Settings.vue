<template>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
          <FormPage /> 
    </div>     
  </div>
</div>
</template>
<script>
import FormPage from "../components/Form";
export default {
  name: 'Form',
  components:{
    FormPage
  }
};
</script>
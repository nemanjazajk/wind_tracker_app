<template>
<div class= "container">
    <div class= "row ">
        <div class= "col-md-12 nopadding">
            <Calendar />
            <History />
        </div>
    </div>
</div>
</template>
<script>
import Calendar from "../components/Calendar";
import History from "../components/HistoryGraph";
export default {
  name: 'HistoryGraph',
  components:{
    History,
    Calendar
  }
};
</script>
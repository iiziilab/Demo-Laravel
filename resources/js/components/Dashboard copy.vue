<template>
  <div>
    <h2>Dashboard ...</h2>
    <input type="submit" value="Logout" @click="logout" />
    <!-- <p>{{$store.state.userSubjects}}</p> -->
    <form @submit.prevent="subjectadd">
      Subject Name: <input type="text" name="subject" id="" v-model="form.subject" />
      <br /><br />
      <input type="submit" value="Add" />
    </form>
    <button @click="userSubjects"></button>
  </div>
</template>
<script>
import axios from "axios";
import { reactive, inject, ref, onMounted } from "vue";
export default {
  name: "Dashboard",
  setup() {
    let cookies = inject("cookies");
    let isAuthenticated = ref(false);
    
    const form = reactive({
      subject: "",
    });

    const subjectadd = async () => {
      let res = await axios
        .post("api/addsubject", form)
        .then((res) => {
            console.log(res)
          if (res.data.result == true) {
            // this.$router.push({name:'Dashboard'})
          }
        })
        .catch(function (error) {
            console.log(error)
          }
        )
    };

    const checkLogin = () => {
      if (cookies.get("access_token")) {
        isAuthenticated.value = true;
      }
    };

    const logout = () => {
      if (cookies.get("access_token")) {
        cookies.set("access_token", "");
        console.log(cookies.get("access_token"));
        isAuthenticated.value = false;
      }
    };
    onMounted(checkLogin);
    return {
      logout,
      isAuthenticated,
    };
  },
  methods:{
    // userSubjects(){
    //     this.$store.dispatch({
    //         type:'calluserSubjects',userSubject:'new data'
    //     })
    // }
  }
};
</script>
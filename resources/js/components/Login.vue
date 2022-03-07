<template>
  <div style="display:flex; justify-content: center;">
            <div class="col-sm-4">
                <form @submit.prevent="login">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" v-model="form.email">
                <!-- <input type="text" name="email" id="" v-model="form.email" /> -->
                <br /><br />
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" v-model="form.password">
                <!-- Password<input type="password" name="password" id="" v-model="form.password" /> -->
                <br /><br />
                <button type="submit" class="btn btn-primary">Submit</button>
                <!-- <input type="submit" value="Login" /> -->
                </form>
            </div>
  </div>
</template>
<script>
import axios from "axios";
import { reactive, inject, ref, onMounted } from "vue";
import router from "../routes"
export default {
  name: "Login",
  setup() {
    let cookies = inject("cookies");
    let isAuthenticated = ref(false);
    const form = reactive({
      email: "",
      password: "",
    });

    const login = async () => {
       await axios
        .post("api/login", form)
        .then((res) => {
          if (res.data.token) {
            cookies.set("access_token", res.data.token);
            console.log(cookies.get("access_token"));
            isAuthenticated.value = true;
            router.push({name:'Dashboard'})
          }
        })
        .catch(function (error) {
            console.log(error)
          }
        )
    };
    const checkLogin = () => {
        console.log(this)
      if (cookies.get("access_token")) {
        isAuthenticated.value = true;
        router.push({name:'Dashboard'})
      }
    };
    onMounted(checkLogin);
    return {
      form,
      login,
      isAuthenticated,
    };
  },
};
</script>
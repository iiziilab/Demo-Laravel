<template>
  <div>
    <form @submit.prevent="login" v-if="isAuthenticated == false">
      Email: <input type="text" name="email" id="" v-model="form.email" />
      <br /><br />
      Password:
      <input type="password" name="password" id="" v-model="form.password" />
      <br /><br />
      <input type="submit" value="Login" />
    </form>
    <div v-else>
      <h2>Dashboard ...</h2>
      <input type="submit" value="Logout" @click="logout" />
    </div>
  </div>
</template>
<script>
// import { reactive , inject } from '@vue/reactivity'
import axios from "axios";
import { reactive, inject, ref, onMounted } from "vue";
export default {
  setup() {
    let cookies = inject("cookies");
    let isAuthenticated = ref(false);
    const form = reactive({
      email: "",
      password: "",
    });

    const login = async () => {
      let res = await axios
        .post("api/login", form)
        .then((res) => {
          if (res.data.token) {
            cookies.set("access_token", res.data.token);
            console.log(cookies.get("access_token"));
            isAuthenticated.value = true;
            this.$router.push({name:'Dashboard'})
          }
        })
        .catch(function (error) {
            console.log("error")
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
        isAuthenticated.value = false;
      }
    };
    onMounted(checkLogin);
    return {
      form,
      login,
      logout,
      isAuthenticated,
    };
  },
};
</script>
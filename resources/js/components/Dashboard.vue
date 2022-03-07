<template>
  <div>
    <nav class="navbar navbar-light bg-light justify-content-between ">
    <a class="navbar-brand">Dashboard ...</a>
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" @click="logout">Logout</button>
    </nav>
    <!-- <input type="submit" value="Logout" @click="logout" /> -->
    <!-- <p>{{$store.state.userSubjects}}</p> -->
    <!-- <button @click="subjectadd">Add Subject</button> -->
    <!-- <button @click="userSubjects">Subject list</button> -->
    <br /><br />
    <form @submit.prevent="subjectadd">
      <input type="text" name="subject" id="" v-model="form.subject" />
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Subject Add</button>
      <!-- <input type="submit" value="Subject Add" /> -->
    </form>
    <br /><br />
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Subject Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in $store.state.userSubjects" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import axios from "axios";
import { reactive, inject, ref, onMounted } from "vue";
import store from "../store/subject";
import router from "../routes";
export default {
  name: "Dashboard",
  data() {
    return {
      list: [],
    };
  },
  async mounted() {
    let cookies = inject("cookies");
    await axios
      .get("api/usersubject", {
        headers: { Authorization: "Bearer " + cookies.get("access_token") },
      })
      .then((res) => {
        console.log(res);
        if (res.data.result == true) {
          //   this.list = res.data.subjects;
          //   this.$store.state.userSubjects = res.data.subjects;
          this.$store.commit("setUserSubjects", res.data.subjects);
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  },
  setup() {
    let cookies = inject("cookies");
    let isAuthenticated = ref(false);
    // console.log(this.list);
    const form = reactive({
      subject: "",
    });

    const subjectadd = async () => {
      await axios
        .post(
          "api/addsubject",
          {
            subject: form.subject,
          },
          {
            headers: { Authorization: "Bearer " + cookies.get("access_token") },
          }
        )
        .then((res) => {
          store.dispatch("updateUserSubjects", res.data.subjects);
        })
        .catch(function (error) {
          console.log(error);
        });
    };

    const checkLogin = () => {
      if (cookies.get("access_token")) {
        isAuthenticated.value = true;
      } else {
        router.push({ name: "Login" });
      }
    };

    const logout = async () => {
      if (cookies.get("access_token")) {
        await axios
          .get("api/logout", {
            headers: { Authorization: "Bearer " + cookies.get("access_token") },
          })
          .then((res) => {
            console.log(res);
            cookies.set("access_token", "");
            router.push({ name: "Login" });
          })
          .catch(function (error) {
            console.log(error);
          });
        cookies.set("access_token", "");
        console.log(cookies.get("access_token"));
        router.push({ name: "Login" });
        isAuthenticated.value = false;
      }
    };
    onMounted(checkLogin);
    return {
      form,
      logout,
      isAuthenticated,
      subjectadd,
      //   userSubjects,
    };
  },
  methods: {
    // userSubjects(){
    //     this.$store.dispatch({
    //         type:'calluserSubjects',userSubject:'new data'
    //     })
    // }
  },
};
</script>
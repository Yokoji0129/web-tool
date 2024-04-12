<script setup>
import { RouterLink, useRouter } from "vue-router";

const router = useRouter();

const logout = () => {
  axios
    .post("/logout", {})
    .then((response) => {
      router.push("/");
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>

<template>
  <div class="logout-box">
    <button class="logout" @click="logout">ログアウト</button>
  </div>
</template>

<style scoped>
.logout-box {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 999;
}

.logout {
  background-color: #ffffff;
  border: 1px solid #ced4da;
  padding: 35px;
}

.logout:hover {
  background-color: #c9c9c9;
}

/**タブレット**/
@media screen and (max-width: 768px) {
  .logout {
    padding: 20px;
  }
}

/**スマホ**/
@media screen and (max-width: 450px) {
  .logout {
    padding: 20px 10px;
  }
}
</style>
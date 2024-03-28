<template>
  <div>
    <header class="header">
      <h1 class="header-title">旅行日記</h1>
    </header>
    <RouterView />
    <footer class="footer">
      <p>&copy; 2024 旅行日記</p>
    </footer>
  </div>
</template>

<style scoped>
p{
  margin: 0;
}
/* ヘッダーのスタイル */
.header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #ced4da;
  padding: 20px;
  text-align: center;
}

.header-title {
  margin: 0;
  font-size: 2rem;
  font-family: "Georgia", serif;
  color: #2f3439;
}

.footer {
  background-color: #5a646d;
  color: #ffffff;
  padding: 20px;
  text-align: center;
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
}

/* ウィンドウ幅が750px以下の場合のヘッダーのスタイル */
@media screen and (max-width: 750px) {
  .header {
    padding: 10px;
  }
  .footer {
    padding: 5px;
  }
}
</style>

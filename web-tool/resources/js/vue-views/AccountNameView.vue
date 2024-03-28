<template>
  <div class="account-name-box">
    <h2>アカウント名作成</h2>
    <form>
      <input type="text" placeholder="アカウント名" />
      <!--まだどこに飛ぶか決めてない-->
      <button class="decision">決定</button>
    </form>
  </div>
</template>
  
<style scoped>
.account-name-box {
  width: 700px;
  margin: 120px auto;
  padding: 20px;
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.account-name-box h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.account-name-box input[type="text"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #fff;
}

.decision{
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.decision:hover{
  background-color: #0056b3;
}

/*ウィンドウ幅が750px以下の場合*/
@media screen and (max-width: 750px) {
  .account-name-box {
    width: 300px;
    margin: 100px auto;
    margin-top: 100px;
  }
}
</style>
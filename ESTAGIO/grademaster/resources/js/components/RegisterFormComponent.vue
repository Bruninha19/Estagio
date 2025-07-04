<template>
  <form @submit.prevent="register" class="register-form">
    <div class="form-group">
      <label for="fullName">Nome completo</label>
      <input type="text" id="fullName" v-model="form.name" required>
    </div>

    <div class="form-group">
      <label for="educationalEmail">E-mail educacional</label>
      <input type="email" id="educationalEmail" v-model="form.email" required>
    </div>

    <div class="form-group">
      <label for="password">Senha</label>
      <input type="password" id="password" v-model="form.password" required>
    </div>

    <div class="form-group">
      <label for="confirmPassword">Confirmar senha</label>
      <input type="password" id="confirmPassword" v-model="form.password_confirmation" required>
    </div>

    <button type="submit" class="btn-register">CADASTRAR</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      // Pode adicionar mensagens de erro ou sucesso aqui
      errors: {},
      message: ''
    };
  },
  methods: {
    async register() {
      this.errors = {}; // Limpa erros anteriores
      this.message = ''; // Limpa mensagens anteriores

      if (this.form.password !== this.form.password_confirmation) {
        this.errors.password_confirmation = 'As senhas não coincidem.';
        return;
      }

      try {

        // Aqui você enviará os dados para uma API Laravel
        // Exemplo usando axios (certifique-se de que axios está no app.js/bootstrap.js)
        const response = await axios.post('http://127.0.0.1:8000/cadastrar', this.form);
        alert('Conta criada com sucesso!')
        this.message = 'Conta criada com sucesso!';
        // Limpar formulário ou redirecionar
        this.form = {
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
        };
        console.log(response.data);
      } catch (error) {
        alert('Erro ao cadastrar usuário')
        alert(error);
        if (error.response && error.response.status === 422) {
          // Erros de validação do Laravel
          this.errors = error.response.data.errors;
          this.message = 'Por favor, corrija os erros no formulário.';
        } else {
          this.message = 'Ocorreu um erro ao criar a conta. Tente novamente.';
          console.error(error);
        }
      }
    }
  }
};
</script>


<style scoped>
.register-form {
  margin-left: 40px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  background-color: #ffffff;
}
.form-group {
  display: flex;
  flex-direction: column;
  text-align: left;
}
.form-group label {
  margin-bottom: 8px;
  font-weight: bold;
  color: #555;
}
.form-group input {
  background-color: #EFEFEF;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 1em;
  width: 400px;
}
.form-group input:focus {
  border-color: #000;
  outline: none;
}
.btn-register {
  grid-column: 1 / -1; /* Ocupa as duas colunas */
  padding: 11px 11px 11px 11px;
  background-color: #1E88DA; /* Cor azul do botão */
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 0.9em;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 50px;
  width: 170px;
  height: 42px;
}
.btn-register:hover {
  background-color: #0056b3;
}
</style>
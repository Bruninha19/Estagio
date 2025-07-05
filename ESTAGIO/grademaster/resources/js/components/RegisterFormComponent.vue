<template>
  <div class="container">
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

<table>
  <thead>
    <tr>
      <th>Nome</th>
      <th>Email</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="usuario in usuarios" :key="usuario.id">
      <td>{{ usuario.name }}</td>
      <td>{{ usuario.email }}</td>
      <td>
        <button @click="deletar(usuario.id)">Excluir</button>
      </td>
    </tr>
  </tbody>
</table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      usuarios: [],
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
        this.fetchUsuarios();
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
    },

      async deletar(id) {
      if (confirm('Tem certeza que deseja excluir este usuário?')) {
      try {
        await axios.delete(`http://127.0.0.1:8000/usuarios/${id}`);
        this.fetchUsuarios(); // Atualiza a lista
        alert('Usuário excluído com sucesso!');
      } catch (error) {
        console.error('Erro ao excluir usuário:', error);
        alert('Erro ao excluir usuário.');
      }
    }
  },
    
    async fetchUsuarios() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/usuarios');
        this.usuarios = response.data;
      } catch (error) {
        console.error('Erro ao buscar usuários:', error);
      }
    }
  },
  

  mounted() {
    this.fetchUsuarios();
  }
};
</script>


<style scoped>
.container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 40px;
  padding: 40px;
}
.register-form {
  margin-left: 20px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
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
table {
  width: 90%;
  margin: 40px auto;
  border-collapse: collapse;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden;
}

thead {
  background-color: #1E88DA;
  color: white;
}

thead th {
  padding: 12px 16px;
  text-align: left;
  font-size: 16px;
}

tbody td {
  padding: 12px 16px;
  border-bottom: 1px solid #eee;
}

tbody tr:hover {
  background-color: #f5f5f5;
}

table button {
  margin-right: 6px;
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
  transition: 0.3s ease;
}

table button:hover {
  opacity: 0.85;
}



table button:nth-child(1) {
  background-color: #E53935; /* vermelho para excluir */
  color: black;
}
</style>
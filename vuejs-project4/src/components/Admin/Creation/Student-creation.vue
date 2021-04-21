<template>
    <div class="card-body">
        <h5 class="card-title text-center">Create Student</h5>
        <form @submit.prevent="createStudent" class="form-signin">
            <div class="form-label-group">
                <input type="name" id="inputName" v-model="name" class="form-control" placeholder="Full name" required autofocus>
                <br>
            </div>
            <div class="form-label-group">
                <input type="email" id="inputEmail" v-model="email" class="form-control" placeholder="Email address" required autofocus>
                <br>
            </div>

            <div class="form-label-group">
                <input type="password" id="inputPassword" v-model="password" class="form-control" placeholder="Password" required>
                <br>
            </div>

            <button class="btn btn-lg btn-warning btn-block text-uppercase" type="submit">Create</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            
            name: null,
            email: null,
            password: null,
            role: 'student'
            
        }
    },
    methods: {
      async createStudent() {
        // console.log(this.name)
        // console.log(this.email)
        // console.log(this.password)
        // console.log(this.role)
        
        const baseURI = 'http://127.0.0.1:8000/api/create-student'
        this.$http.post(baseURI, {
          name : this.name,
          email: this.email,
          password: this.password,
          role: this.role
        })
        .then((res)=>{
            alert(res.data.msg)
        })
      }
    }
}
</script>
<style>

</style>
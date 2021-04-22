<template>
    <div>
        <h5 class="card-title text-center">Marks Distribution</h5>
        <form @submit.prevent="createDist">
            <div class="form-group">
                <label for="">Select Session</label>
                <select class="form-control" @change="sessionChange" v-model="session">
                  <option disabled value="">Please select one</option>
                  <option v-for="s in sessions" :key="s.id" :value="s.id">{{s.name}}</option>
                </select>
            </div>
            <div v-if="courses" class="form-group">
                <label for="">Select Course</label>
                <select class="form-control" @change="courseChange" v-model="course">
                  <option disabled value="">Please select one</option>
                  <option v-for="c in courses" :key="c.id" :value="c.id">{{c.name}}</option>
                </select>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
          sessions: [],
          session: null,
          courses: [],
          course: null
        }
    },
    async created() {
        const token = localStorage.getItem('token');
        const baseURI = 'http://127.0.0.1:8000/api/get-assigned-teacher-session/' + token;
        const response = await this.$http.get(baseURI);
        // console.log(response.data);
        this.sessions = response.data.session;
        console.log(this.sessions);
    },
    methods: {
        async sessionChange () {
          const token = localStorage.getItem('token');
            const baseURI = 'http://127.0.0.1:8000/api/get-assigned-teacher-course/' + token;
            const response = await this.$http.post(baseURI, {
              session_id: this.session
            });
            // console.log(response.data);
            this.courses = response.data.course;
        },
        courseChange () {

        },
        createDist () {

        }
    }
}
</script>
<style>
:root {
  --input-padding-x: 1.5rem;
  --input-padding-y: .75rem;
}

.card-signin {
  border: 0;
  border-radius: 1rem;
  box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
}

.card-signin .card-title {
  margin-bottom: 2rem;
  font-weight: 300;
  font-size: 1.5rem;
}

.card-signin .card-body {
  padding: 2rem;
}

.form-signin {
  width: 100%;
}

.form-signin .btn {
  font-size: 80%;
  border-radius: 5rem;
  letter-spacing: .1rem;
  font-weight: bold;
  padding: 1rem;
  transition: all 0.2s;
}

.form-label-group {
  position: relative;
  margin-bottom: 1rem;
}

.form-label-group input {
  height: auto;
  border-radius: 2rem;
}

.form-label-group>input,
.form-label-group>label {
  padding: var(--input-padding-y) var(--input-padding-x);
}

.form-label-group>label {
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0;
  /* Override default `<label>` margin */
  line-height: 1.5;
  color: #495057;
  border: 1px solid transparent;
  border-radius: .25rem;
  transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-group input:-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-moz-placeholder {
  color: transparent;
}

.form-label-group input::placeholder {
  color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
  padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
  padding-bottom: calc(var(--input-padding-y) / 3);
}

.form-label-group input:not(:placeholder-shown)~label {
  padding-top: calc(var(--input-padding-y) / 3);
  padding-bottom: calc(var(--input-padding-y) / 3);
  font-size: 12px;
  color: #777;
}
</style>
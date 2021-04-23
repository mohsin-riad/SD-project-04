<template>
    <div>
        <h5 class="card-title text-center">Marks Distribution</h5>
        <form @submit.prevent="createDist">
            
            <div class="form-group">
                <label for="">Select Session</label>
                <select class="form-control text-white bg-dark" :required="true" @change="sessionChange" v-model="session">
                  <option :selected="true">Please select one</option>
                  <option v-for="s in sessions" :key="s.id" :value="s.id">{{s.name}}</option>
                </select>
            </div>

            <div v-if="fg1" class="form-group">
                <label for="">Select Course</label>
                <select class="form-control text-white bg-dark" :required="true" @change="courseChange" v-model="course">
                  <option :selected="true">Please select one</option>
                  <option v-for="c in courses" :key="c.id" :value="c.id">{{c.name}}</option>
                </select>
            </div>

            <div v-if="fg2" class="form-group" @change="sectionChange">
                <label class="form-check-label" for="">Select Sections: </label> 
                <div  v-for="s in sections" :key="s.id">
                   &emsp;<input :value="s.id" type="checkbox" v-model="section"> &emsp;{{ s.name}}
                </div>
            </div>

            <div v-if="fg3">
                <div class="row">
                    <div class="col-md-4 portlets">
                        <button type='button' class="btn btn-info" @click="addNewRow">
                            <i class="fas fa-plus-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </i>
                            Add
                        </button>
                    </div>
                    <div class="col-md-4 portlets">
                        <label for=""> Total Marks:</label>
                    </div>
                    <div class="col-md-4">
                        <input readonly class="form-control bg-dark text-white" type="number" v-model="total_marks"/>
                    </div>
                </div>

                <hr>

                <table @change="categoryChange">
                    <tr v-for="(category, k) in categories" :key="k">
                        <td scope="row" class="btn btn-warning">
                            <i @click="deleteRow(k, category)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                </svg>
                            </i>
                        </td>
                        <td>
                            <input class="form-control" type="text" v-model="category.name" />
                        </td>
                        <td>
                            <input class="form-control text-right" type="number" min="0" step=".01" v-model="category.value" @change="calculateLineTotal(category)"
                            />
                        </td>
                        <td hidden>
                            <input readonly class="form-control text-right" type="number" v-model="category.line_total" />
                        </td>
                    </tr>
                </table>
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
          course: null,
          sections: [],
          section: [],
          fg1: false,
          fg2: false,
          fg3: false,

          total_marks: 0,
          categories: [{
              name: '',
              value: '',
              line_total: 0
          }]
        }
    },
    async created() {
        const token = localStorage.getItem('token');
        const baseURI = 'http://127.0.0.1:8000/api/get-assigned-teacher-session/' + token;
        const response = await this.$http.get(baseURI);
        // console.log(response.data);
        this.sessions = response.data.session;
        // console.log(this.sessions);
        console.log(this.section);
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
            this.fg1 = true;
        },
        async courseChange () {
            const token = localStorage.getItem('token');
            const baseURI = 'http://127.0.0.1:8000/api/get-assigned-teacher-section/' + token;
            const response = await this.$http.post(baseURI, {
              session_id: this.session,
              course_id: this.course
            });
            console.log(response.data);
            this.sections = response.data.section;
            this.fg2 = true;
        },
        async sectionChange () {
            console.log(this.section);
            this.fg3 = true;
        },

        addNewRow() {
            this.categories.push({
                name: '',
                value: '',
                line_total: 0
            });
        },
        calculateTotal() {
            var subtotal;
            subtotal = this.categories.reduce(function (sum, category) {
                var lineTotal = parseFloat(category.line_total);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0);

            this.total_marks = subtotal;
        },
        calculateLineTotal(category) {
            var total = category.value;
            if (!isNaN(total)) {
                category.line_total = total;
            }
            this.calculateTotal();
        },
        deleteRow(index, category) {
            var idx = this.categories.indexOf(category);
            console.log(idx, index);
            if (idx > -1) {
                this.categories.splice(idx, 1);
            }
            this.calculateTotal();
        },
        categoryChange () {}
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
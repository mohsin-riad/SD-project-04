<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-11 col-md-11 col-lg-11 mx-auto">
                <div class="card text-white bg-dark">
                    <div class="card-header">Marks assignation</div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Select Available Session</label>
                                    <select class="form-control text-white bg-dark" :required="true" @change="sessionChange" v-model="session">
                                        <option :selected="true" :value="0">Please select one</option>
                                        <option v-for="s in sessions" :key="s.id" :value="s.id">{{s.name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <div v-show="session" class="form-group">
                                    <label for="">Select Available Course</label>
                                    <select class="form-control text-white bg-dark" :required="true" @change="courseChange" v-model="course">
                                        <option :selected="true" :value="0">Please select one</option>
                                        <option v-for="c in courses" :key="c.id" :value="c.id">{{c.name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <div v-show="course && session" class="form-group">
                                    <label for="">Select Available Section</label>
                                    <select class="form-control text-white bg-dark" :required="true" @change="sectionChange" v-model="section">
                                        <option :selected="true" :value="0">Please select one</option>
                                        <option v-for="s in sections" :key="s.id" :value="s.id">{{s.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div v-show="session && course && section">
                            <h5 class="card-title text-center"> Enrolled Students </h5>
                            <form @submit.prevent="updateStdMarks">
                                <table class="table table-hover table-dark">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" v-for="i in data" :key="i.id">{{i.name+'('+i.marks+')'}}</th>
                                        <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="i in list" :key="i.id">
                                            <td>{{ i.i }}</td>
                                            <td>{{ i.id }}</td>
                                            <td>{{ i.name }}</td>
                                            <td v-for="mark in i.marks" :key="mark.id">
                                                <input class="form-control text-center text-white bg-dark" type="number" v-model="mark.numbers" @change="calculateLineTotal(mark,i)"/>
                                            </td>
                                            <td>
                                                <input readonly disabled class="form-control text-center  input-box" type="number" min="0"  v-model="i.line_total" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            section: null,
            fg: false,
            total_marks: 0,
            data: [],
            list: [{
                i: null,
                id: null,
                marks: [{
                    id: null,
                    numbers: null
                }],
                name: '',
                line_total: 0
            }]
        }
    },
    async created() {
        const token = localStorage.getItem('token');
        const baseURI = 'http://127.0.0.1:8000/api/get-assigned-dist-teacher-session/' + token;
        const response = await this.$http.get(baseURI);
        this.sessions = response.data.session;
    },
    methods: {
        async sessionChange () {
            const token = localStorage.getItem('token');
            const baseURI = 'http://127.0.0.1:8000/api/get-assigned-dist-teacher-course/' + token;
            const response = await this.$http.post(baseURI, {
              session_id: this.session
            });
            this.courses = response.data.course;
            console.log(this.courses);
        },
        async courseChange () {
            const token = localStorage.getItem('token');
            const baseURI = 'http://127.0.0.1:8000/api/get-assigned-dist-teacher-section/' + token;
            const response = await this.$http.post(baseURI, {
              session_id: this.session,
              course_id: this.course
            });
            this.sections = response.data.section;
        },
        async sectionChange () {
            const token = localStorage.getItem('token');
            const baseURI = 'http://127.0.0.1:8000/api/get-assigned-dist-teacher/' + token;
            const response = await this.$http.post(baseURI, {
              session_id: this.session,
              course_id: this.course,
              section_id: this.section
            });
            this.data = response.data.obj;
            this.list = response.data.list;
            console.log(this.list);
            console.log(this.list.marks);
        },
        async calculateLineTotal(mark,list) {
            var total = parseFloat(mark.numbers);
            if (!isNaN(total)) {
                list.line_total = total;
            }
            var subtotal = this.list.reduce(function (sum, list) {
                var lineTotal = parseFloat(list.line_total);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0);
            this.list.line_total = subtotal;
        },
        async updateStdMarks() {

        }
    }
}
</script>

<style>
:root {
  --input-padding-x: 1.5rem;
  --input-padding-y: .75rem;
}

body {
  background: #525252;
  background: linear-gradient(to right, #e2e2e2ee, #1d1d1d);
}

</style>
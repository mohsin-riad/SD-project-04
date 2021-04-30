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
                                <div v-show="course" class="form-group">
                                    <label for="">Select Available Section</label>
                                    <select class="form-control text-white bg-dark" :required="true" @change="sectionChange" v-model="section">
                                    <option :selected="true" :value="0">Please select one</option>
                                    <option v-for="s in sections" :key="s.id" :value="s.id">{{s.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5 class="card-title text-center"> My Marks Distributions </h5>
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                <th scope="col">#S/N</th>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="dist in dist_list"   :key="dist.id">
                                  <td scope="row" ><strong>{{dist.id}}</strong></td>
                                  <td>{{ dist.course_name }}</td>
                                  <td>{{ dist.session_name }}</td>
                                  <td>{{ dist.section_name }}</td>
                                  <td>{{ dist.catagory_name }}</td>
                                  <td>{{ dist.marks }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
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
            fg1: 0,
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
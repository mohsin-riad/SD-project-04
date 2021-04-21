<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-6 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <div>
                            <h5 class="card-title text-center" >Distribution</h5>
                            <hr>
                        </div>
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</template>

<script>
export default {

}
</script>

<style>
:root {
  --input-padding-x: 1.5rem;
  --input-padding-y: .75rem;
}

body {
  background: #4f0452;
  background: linear-gradient(to right, #0f0000, #46034e);
}

.card-signin {
  border: 0;
  border-radius: 1rem;
  box-shadow: 2rem 2rem 2rem 0 rgba(0, 0, 0, 0.1);
}

.card-signin .card-title {
  margin-bottom: 2rem;
  font-weight: 300;
  font-size: 1.5rem;
}

.card-signin .card-body {
  padding: 2rem;
}

</style>

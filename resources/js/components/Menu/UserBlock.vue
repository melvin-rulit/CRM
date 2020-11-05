<template>
    <div>

        <div class="navbar-user d-none d-md-flex" id="sidebarUser">

            <a href="#sidebarModalActivity" class="navbar-user-link" data-toggle="modal">
                <span class="icon">
                  <i class="fe fe-bell"></i>
                </span>
            </a>


            <div class="dropup">
                <a href="#" class="dropdown-toggle" role="button">
                    <div class="avatar avatar-xl avatar-online">
                        <img src="http://62.109.26.106//images/photo_LI.jpg" class="avatar-img rounded-circle" alt="...">
                    </div>
                </a>
            </div>

            <!-- Icon -->
            <a href="#" @click.prevent="logout()" class="navbar-user-link" data-toggle="modal">
                    <span class="icon">
                        <i class="fe fe-log-out"></i>
                    </span>
            </a>

        </div>

        <div class="text-center">
            <h2 class="card-title">
                {{ user.surname }}
            </h2>
        </div>

    </div>
</template>

<script>

    export default {
        data(){
            return {
                user: ''
            }
        },

        mounted() {
          this.getUserName()
        },

        methods: {
            getUserName(){
                axios.get('api/v2/getUserName')
                .then(response => this.user = response.data)
            },

            logout() {
                axios.post('/logout')
                .catch(error => {
                    window.location.href = '/login';
                });
            }
        }
}

</script>


<style scoped>
    .navbar-user {
        border-top-color: #ffffff;
    }
</style>

<template>
    <div>

<!--        <showuser-component :can="can" @get-method="fol" ref="getmodal"></showuser-component>-->

        <div class="navbar-user d-none d-md-flex" id="sidebarUser">

            <a href="#sidebarModalActivity" class="navbar-user-link" data-toggle="modal">
                <span class="icon">
                  <i class="fe fe-bell"></i>
                </span>
            </a>


            <div class="dropup" ref="mod">
                <a href="#"  @click.prevent="getShowModal(user.id)" class="dropdown-toggle" role="button">
                    <div v-if="user.avatar" class="avatar-online">
                        <b-img
                            @click="$refs.avatar.click()"
                            center
                            thumbnail
                            fluid
                            :src="siteURL + user.avatar"
                            class="avatar-img rounded-circle">
                        </b-img>
                    </div>

                    <div v-else>
                        <b-img
                            center
                            thumbnail
                            fluid
                            src="http://127.0.0.1:8000/images/no.png"
                            alt="?"
                            class="avatar-img rounded-circle"
                            >
                        </b-img>

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
                {{ user.surname }} {{ user.name }}
            </h2>
        </div>

    </div>
</template>

<script>

    export default {
        data(){
            return {
                user: '',
                siteURL: "http://127.0.0.1:8000/",

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

            // getShowModal(id){
            //
            //      this.$refs.getmodal.addNewUserModal(id)
            //
            // },

            logout() {
                axios.post('/logout')
                .catch(error => {
                    window.location.href = '/login';
                });
            },

        }
}

</script>


<style scoped>
    .navbar-user {
        border-top-color: #ffffff;
    }
</style>

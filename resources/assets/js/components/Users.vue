<template>
    <div class="w-full">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-medium">Users</h2>

            <a class="leading-none no-underline text-grey-dark hover:text-grey-darkest cursor-pointer" @click="showNewUserModal">
                <i class="fas fa-user-plus fa-fw fa-2x"></i>
            </a>
        </div>

        <div class="flex flex-wrap">
            <user v-for="user in data.users" :user=user :key="user.id" @deactivate="deactivateUser"></user>
        </div>

        <modal name="new-user" classes="shadow rounded border bg-white p-8" width="66%" height="auto">
            <h3 class="font-medium mb-8">New User</h3>

            <form @submit.prevent="submitNewUserForm">
                <div class="flex flex-wrap items-center">
                    <div class="flex flex-col self-start w-full md:w-1/2">
                        <div class="p-2">
                            <label class="hidden block text-grey-darker text-sm font-bold mb-2" for="name">Name</label>
                            <input v-model="data.new_user.name" :class="'shadow appearance-none ' + (utilities.error.name ?  'border border-red' : 'border') + ' rounded w-full py-3 px-3 text-grey-darker leading-tight'" id="name" name="name" type="text" placeholder="Name" required autocomplete="off">

                            <span class="text-red text-sm font-medium pt-2" v-if="utilities.error.name">
                            {{ utilities.error.name[0] }}
                        </span>
                        </div>
                    </div>

                    <div class="flex flex-col self-start w-full md:w-1/2">
                        <div class="p-2">
                            <label class="hidden block text-grey-darker text-sm font-bold mb-2" for="email">Email Address</label>
                            <input v-model="data.new_user.email" :class="'shadow appearance-none ' + (utilities.error.email ?  'border border-red' : 'border') + ' rounded w-full py-3 px-3 text-grey-darker leading-tight'" id="email" name="email" type="email" placeholder="Email Address" required autocomplete="off">

                            <span class="text-red text-sm font-medium pt-2" v-if="utilities.error.email">
                            {{ utilities.error.email[0] }}
                        </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center">
                    <div class="flex flex-col self-start  w-full md:w-1/2">
                        <div class="p-2">
                            <label class="hidden block text-grey-darker text-sm font-bold mb-2" for="password">Password</label>
                            <input v-model="data.new_user.password" :class="'shadow appearance-none ' + (utilities.error.password ?  'border border-red' : 'border') + ' rounded w-full py-3 px-3 text-grey-darker leading-tight'" id="password" name="password" type="password" placeholder="Password" required autocomplete="off">

                            <span class="text-red text-sm font-medium pt-2" v-if="utilities.error.password">
                            {{ utilities.error.password[0] }}
                        </span>
                        </div>
                    </div>

                    <div class="flex flex-col self-start  w-full md:w-1/2">
                        <div class="p-2">
                            <label class="hidden block text-grey-darker text-sm font-bold mb-2" for="password_confirmation">Password</label>
                            <input v-model="data.new_user.password_confirmation" :class="'shadow appearance-none ' + (utilities.error.password ?  'border border-red' : 'border') + ' rounded w-full py-3 px-3 text-grey-darker leading-tight'" id="password_confirmation" name="password_confirmation" type="password" placeholder="Password Confirmation" required autocomplete="off">
                        </div>
                    </div>

                </div>

                <div class="flex flex-wrap items-center">
                    <div class="flex flex-col self-start w-full md:w-1/2">
                        <div class="p-2">
                            <label class="hidden block text-grey-darker text-sm font-bold mb-2" for="role">Role</label>

                            <div class="inline-block relative w-full">
                                <select v-model="data.new_user.role_id" class="block appearance-none w-full bg-white border border-grey-light text-grey-darker py-3 px-3 pr-8 rounded shadow leading-tight" id="role" name="role">
                                    <option v-for="role in data.roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                                </select>

                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-start">
                    <button class="w-full md:w-1/2 bg-none text-green hover:font-bold p-4" type="submit">Save</button>
                    <a class="w-full md:w-1/2 text-center text-grey hover:text-red cursor-pointer p-4" @click="$modal.hide('new-user')">Cancel</a>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
    export default {
        computed: {},
        data() {
            return {
                data: {
                    new_user: {
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: '',
                        role_id: null,
                    },
                    roles: [],
                    users: [],
                },
                utilities: {
                    error: '',
                },
            }
        },
        methods: {
            deactivateUser(user) {
                let self = this

                axios.post('/api/users/' + user.id + '/destroy')
                    .then(function (response) {
                        if (response.status === 200) {
                            self.data.users.splice(self.data.users.indexOf(user), 1)
                        }
                    })
            },
            getData() {
                let self = this

                axios.get('/api/users')
                    .then(function (response) {
                        self.data.users = response.data
                    })
            },
            showNewUserModal() {
                this.$modal.show('new-user')
            },
            submitNewUserForm() {
                let self = this

                axios.post('api/user', self.data.new_user)
                    .then(function (response) {
                        self.data.users.push(response.data)

                        self.$modal.hide('new-user')
                    }).catch(function (error) {
                    if (error.response && error.response.status === 422) {
                        self.utilities.error = error.response.data.errors
                    }
                })
            },
        },
        mounted() {
            let self = this

            self.getData()

            axios.get('/api/roles')
                .then(function (response) {
                    self.data.roles = response.data

                    let role = _.find(self.data.roles, function (role) {
                        return role.slug === 'user'
                    })

                    self.data.new_user.role_id = role.id
                })

            setInterval(function () {
                self.getData()
            }, 60000)
        },
    }
</script>

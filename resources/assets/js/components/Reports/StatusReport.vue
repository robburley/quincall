<template>
    <div class="w-full">
        <div class="flex flex-wrap mb-4">
            <div class="w-full mb-4">
                <p class="font-medium mb-1 text-grey-darker group-hover:text-grey-darkest">
                    Busy
                </p>
            </div>

            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4" v-for="user in busy">
                <div class="mr-8 mb-4 shadow rounded bg-white px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex flex-col">
                            <p class="font-bold text-grey-darkest">{{ user.name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <p v-if="user.online && ! user.available" class="text-red text-xs">Busy</p>
                        <p v-if="user.online && user.available" class="text-green text-xs">Available</p>
                        <p v-if=" ! user.online && ! user.available" class="text-grey text-xs">Offline</p>

                        <from-time :time="user.availability_changed_at" @updated="setOrder(user, $event)"></from-time>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap mb-4">
            <div class="w-full mb-4">
                <p class="font-medium mb-1 text-grey-darker group-hover:text-grey-darkest">
                    Available
                </p>
            </div>

            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4" v-for="user in available">
                <div class="mr-8 mb-4 shadow rounded bg-white px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex flex-col">
                            <p class="font-bold text-grey-darkest">{{ user.name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <p v-if="user.online && ! user.available" class="text-red text-xs">Busy</p>
                        <p v-if="user.online && user.available" class="text-green text-xs">Available</p>
                        <p v-if=" ! user.online && ! user.available" class="text-grey text-xs">Offline</p>

                        <from-time :time="user.availability_changed_at" @updated="setOrder(user, $event)"></from-time>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap mb-4">
            <div class="w-full mb-4">
                <p class="font-medium mb-1 text-grey-darker group-hover:text-grey-darkest">
                    Offline
                </p>
            </div>

            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4" v-for="user in offline">
                <div class="mr-8 mb-4 shadow rounded bg-white px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex flex-col">
                            <p class="font-bold text-grey-darkest">{{ user.name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <p v-if="user.online && ! user.available" class="text-red text-xs">Busy</p>
                        <p v-if="user.online && user.available" class="text-green text-xs">Available</p>
                        <p v-if=" ! user.online && ! user.available" class="text-grey text-xs">Offline</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            busy() {
                let data = _.filter(this.data.users, function (user) {
                    return user.online && !user.available
                })

                data = _.sortBy(data, function (user) {
                    return user.order
                })

                return data
            },
            available() {
                let data = _.filter(this.data.users, function (user) {
                    return user.online && user.available
                })

                data = _.sortBy(data, function (user) {
                    return user.order
                })

                return data
            },
            offline() {
                return _.filter(this.data.users, function (user) {
                    return !user.online && !user.available
                })

            },
        },
        data() {
            return {
                data: {
                    users: [],
                },
                utilities: {
                    error: '',
                },
            }
        },
        methods: {
            setOrder(user, timestamp) {
                user.order = timestamp
            },
            getData() {
                let self = this

                axios.get('/api/reports/status')
                    .then(function (response) {
                        self.data.users = response.data
                    })
            },
        },
        mounted() {
            let self = this

            self.getData()

            setInterval(function () {
                self.getData()
            }, 3000)
        },
    }
</script>

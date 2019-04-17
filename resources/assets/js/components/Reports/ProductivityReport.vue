<template>
    <div class="flex flex-wrap">
        <form class="w-full flex flex-wrap items-center mb-6" @submit.prevent="getData()">
            <div class="w-full sm:w-2/5 flex flex-col px-4 mb-2 sm:mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="start_time">Start Time</label>

                <datetime v-model="data.query.start" value-zone="local" type="datetime" :format="utilities.dateTimeFormat" input-class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight"></datetime>
            </div>

            <div class="w-full sm:w-2/5 flex flex-col px-4 mb-2 sm:mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="end_time">End Time</label>

                <datetime v-model="data.query.end" value-zone="local" type="datetime" :format="utilities.dateTimeFormat" input-class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight"></datetime>
            </div>

            <div class="w-full sm:w-1/5 flex flex-col px-4 mb-2 sm:mb-6">
                <label class="invisible block text-grey-darker text-sm font-bold mb-2" for="submit">Search</label>
                <button class="w-full bg-blue hover:bg-blue-dark border border-blue hover:border-blue-dark text-white font-light py-3 rounded" type="submit">Search</button>
            </div>
        </form>

        <div class="w-full mx-4 mb-8 rounded-t overflow-x-scroll">
            <table class="w-full" cellspacing="0">
                <tr class="bg-grey-light text-grey-darkest font-medium ">
                    <th class="px-6 py-6 text-left font-medium">User</th>
                    <th class="px-6 py-6 text-left font-medium">First Call</th>
                    <th class="px-6 py-6 text-left font-medium">Last Call</th>
                    <th class="px-6 py-6 text-left font-medium">Inbound</th>
                    <th class="px-6 py-6 text-left font-medium">Outbound</th>
                    <th class="px-6 py-6 text-left font-medium">Call Time</th>
                    <th class="px-6 py-6 text-left font-medium">Average Duration</th>
                </tr>

                <tr class="bg-white text-grey-darker text-sm items-center" v-for="user in data.users">
                    <td class="px-6 py-6 border-b border-grey-lighter">
                        {{ user.name }}
                    </td>

                    <td class="px-6 py-6 border-b border-grey-lighter">
                        {{ user.first_call.date | moment('HH:mm') }}
                    </td>

                    <td class="px-6 py-6 border-b border-grey-lighter">
                        {{ user.last_call.date | moment('HH:mm') }}
                    </td>

                    <td class="px-6 py-6 border-b border-grey-lighter">
                        {{ user.inbound_calls }}
                    </td>

                    <td class="px-6 py-6 border-b border-grey-lighter">
                        {{ user.outbound_calls}}
                    </td>

                    <td class="px-6 py-6 border-b border-grey-lighter">
                        {{ user.total_call_time ? (new Date(user.total_call_time * 1000)).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0] : '00:00:00' }}
                    </td>

                    <td class="px-6 py-6 border-b border-grey-lighter">
                        {{ user.average_call_duration ? (new Date(user.average_call_duration * 1000)).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0] : '00:00:00' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {},
        data() {
            return {
                data: {
                    query: {
                        start: window.moment().startOf('day').format(),
                        end: window.moment().endOf('day').format(),
                    },
                    users: [],
                },
                utilities: {
                    error: '',
                    dateTimeFormat: {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: '2-digit',
                    },
                },
            }
        },
        methods: {
            getData() {
                let self = this

                axios.get('/api/reports/productivity', {params: self.data.query})
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
            }, 10000)
        },
    }
</script>

<style>
    .selected-tag {
        position: absolute;
    }
</style>

<template>
    <div class="flex flex-wrap">
        <form class="w-full flex flex-wrap items-center mb-2" @submit.prevent="getData()">
            <div class="w-full sm:w-1/3 lg:w-1/6 flex flex-col px-4 mb-2 sm:mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="start_time">Start Time</label>

                <datetime v-model="data.query.start" value-zone="local" type="datetime" :format="utilities.dateTimeFormat" input-class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight"></datetime>
            </div>

            <div class="w-full sm:w-1/3 lg:w-1/6 flex flex-col px-4 mb-2 sm:mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="end_time">End Time</label>

                <datetime v-model="data.query.end" value-zone="local" type="datetime" :format="utilities.dateTimeFormat" input-class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight"></datetime>
            </div>

            <div class="w-full sm:w-1/3 lg:w-1/6 flex flex-col px-4 mb-2 sm:mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="from">From</label>
                <input v-model="data.query.from" class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight" id="from" name="from" type="text">
            </div>

            <div class="w-full sm:w-1/3 lg:w-1/6 flex flex-col px-4 mb-2 sm:mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="to">To</label>
                <input v-model="data.query.to" class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight" id="to" name="to" type="text">
            </div>

            <div class="w-full sm:w-1/3 lg:w-1/6 flex flex-col px-4 mb-2 sm:mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="user">User</label>

                <div class="relative">
                    <select v-model="data.query.user_id" class="shadow appearance-none border rounded w-full py-3 px-3 text-grey-darker leading-tight bg-white">
                        <option value=""></option>
                        <option v-for="(name, id) in users" v-bind:value="id">
                            {{ name }}
                        </option>
                    </select>

                    <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="w-full sm:w-1/3 lg:w-1/6 flex flex-col px-4 mb-2 sm:mb-4">
                <label class="invisible block text-grey-darker text-sm font-bold mb-2" for="submit">Search</label>
                <button class="w-full bg-blue hover:bg-blue-dark border border-blue hover:border-blue-dark text-white font-light py-3 rounded" type="submit">Search</button>
            </div>
        </form>

        <div class="w-full flex mx-4 mb-4 bg-red text-white px-6 pt-3 shadow rounded" v-if="utilities.errors">
            <ul class="list-reset">
                <li class="mb-3"
                    v-for="error in utilities.errors"
                >
                    {{ error[0] }}
                </li>
            </ul>
        </div>


        <div class="w-full mx-4 mb-8 rounded-t overflow-x-scroll">
            <table class="w-full" cellspacing="0">
                <tr class="bg-grey-light text-grey-darkest font-medium ">
                    <th class="px-6 py-6 text-left font-medium">Timestamp</th>
                    <th class="px-6 py-6 text-left font-medium">From</th>
                    <th class="px-6 py-6 text-left font-medium">To</th>
                    <th class="px-6 py-6 text-left font-medium">Duration</th>
                    <th class="px-6 py-6 text-left font-medium">User</th>
                    <th class="px-6 py-6 text-left font-medium">Direction</th>
                    <th class="px-6 py-6 text-left font-medium">Status</th>
                    <th class="px-6 py-6 text-left font-medium">Recording</th>
                </tr>

                <tr class="bg-white text-grey-darker text-sm items-center" v-for="call in data.calls">
                    <td class="px-6 py-3 border-b border-grey-lighter">
                        {{ call.timestamp | moment('DD/MM/YYYY HH:mm:ss') }}
                    </td>

                    <td class="px-6 py-3 border-b border-grey-lighter">
                        0{{ call.from.substring(2) }}
                    </td>

                    <td class="px-6 py-3 border-b border-grey-lighter">
                        0{{ call.to.substring(2) }}
                    </td>

                    <td class="px-6 py-3 border-b border-grey-lighter">
                        {{ call.duration ? (new Date(call.duration * 1000)).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0] : '' }}
                    </td>

                    <td class="px-6 py-3 border-b border-grey-lighter">
                        {{ call.user_name }}
                    </td>

                    <td class="px-6 py-3 border-b border-grey-lighter">
                        {{ call.direction === 'inbound' ? 'Inbound' : 'Outbound' }}
                    </td>

                    <td class="px-6 py-3 border-b border-grey-lighter">
                        {{ call.status }}
                    </td>

                    <td class="px-6 py-3 border-b border-grey-lighter text-center">
                        <a class="text-grey-darker hover:text-blue" :href="call.recording_url" v-if="call.recording_url">
                            <i class="fas fa-cloud-download-alt fa-fw"></i>
                        </a>
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
                    calls: [],
                    query: {
                        start: window.moment().startOf('day').format(),
                        end: window.moment().endOf('day').format(),
                        from: '',
                        to: '',
                        user_id: null,
                    },
                },
                utilities: {
                    errors: null,
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

                self.utilities.errors = null

                axios.get('/api/reports/calls', {params: self.data.query})
                    .then(function (response) {
                        self.data.calls = response.data
                    })
                    .catch(function (error) {
                        if (error.response && error.response.status === 422) {
                            self.utilities.errors = error.response.data.errors
                        }
                    })
            },
        },
        mounted() {
            let self = this

            self.getData()
        },
        props: [
            'users',
        ],
    }
</script>

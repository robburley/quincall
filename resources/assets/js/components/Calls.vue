<template>
    <div class="w-full">
        <div :class="'w-full shadow rounded bg-white border-solid border-l-4 border-' + (call.direction === 'inbound' ?  'purple' : 'blue') + ' mb-4 p-4 flex flex-col justify-between leading-normal'" v-for="call in data.calls">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-grey-dark">{{ call.direction === 'inbound' ? 'Inbound' : 'Outbound' }}</p>

                <p class="text-xs text-grey-dark">{{ call.created_at | moment('HH:mm') }}</p>
            </div>

            <div class="text-black font-bold text-xl mb-2">
                {{ call.direction === 'inbound' ? 'From 0' + call.from.substring(2) : 'To 0' + call.to.substring(2) }}
            </div>

            <div class="flex items-center justify-between">
                <p class="text-sm text-grey-dark">{{ call.duration }} seconds</p>

                <p class="text-sm text-grey-dark">
                    <a class="no-underline text-blue" :href="call.recording_url" target="_blank" v-if="call.recording_downloaded_at">Play</a>
                    <a class="no-underline text-blue" :href="call.recording_external_url" target="_blank" v-else>Play</a>
                </p>
            </div>
        </div>

        <div class="w-full mb-4" v-if="data.calls.length === 0">
            <p class="font-thin text-grey-dark">Make your first call of today!</p>
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
                },
                utilities: {
                    error: '',
                },
            }
        },
        methods: {
            getData() {
                let self = this

                axios.get('/api/calls')
                    .then(function (response) {
                        self.data.calls = response.data
                    })
                    .catch(function (error) {
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

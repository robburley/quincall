<template>
    <div class="flex flex-wrap container mx-auto mt-2">
        <div class="w-full lg:w-1/3 text-center py-8">
            <div class="border-r-0 lg:border-r">
                <div class="text-grey-darker mb-2">
                    <span class="text-5xl">{{ data.stats.call_count }}</span>
                </div>

                <div class="text-sm uppercase text-grey tracking-wide">
                    Calls
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/3 text-center py-8">
            <div class="border-r-0 lg:border-r">
                <div class="text-grey-darker mb-2">
                    <span class="text-5xl">{{ data.stats.call_time ? (new Date(data.stats.call_time * 1000)).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0] : '00:00:00' }}</span>
                </div>

                <div class="text-sm uppercase text-grey tracking-wide">
                    Call Time
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/3 text-center py-8">
            <div>
                <div class="text-grey-darker mb-2">
                    <span class="text-5xl">{{ data.stats.average_duration ? (new Date(data.stats.average_duration * 1000)).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0] : '00:00:00' }}</span>
                </div>

                <div class="text-sm uppercase text-grey tracking-wide">
                    Average Duration
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {},
        data() {
            return {
                data: {
                    stats: [],
                },
                utilities: {
                    error: '',
                },
            }
        },
        methods: {
            getData() {
                let self = this

                axios.get('/api/stats')
                    .then(function (response) {
                        self.data.stats = response.data
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

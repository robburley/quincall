<template>
    <div class="w-full">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-medium">Numbers</h2>
        </div>

        <div class="flex flex-wrap">
            <number v-for="number in data.numbers" :number=number :key="number.id"></number>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {},
        data() {
            return {
                data: {
                    numbers: [],
                },
                utilities: {
                    error: '',
                },
            }
        },
        methods: {
            getData() {
                let self = this

                axios.get('/api/numbers')
                    .then(function (response) {
                        self.data.numbers = response.data
                    })
            },
        },
        mounted() {
            let self = this

            self.getData()

            setInterval(function () {
                self.getData()
            }, 60000)
        },
    }
</script>

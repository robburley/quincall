<template>
    <div class="w-full">
        <div :class="'w-full shadow rounded bg-white border-solid border-l-4 border-' + (voicemail.downloaded_at ?  'grey' : 'red') + ' mb-4 p-4 flex flex-col justify-between leading-normal'" v-for="voicemail in data.voicemails">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-grey-dark">Voicemail</p>

                <p class="text-xs text-grey-dark">{{ voicemail.created_at | moment('calendar') }}</p>
            </div>

            <div class="text-black font-bold text-xl mb-2">
                From 0{{ voicemail.from.substring(2) }}
            </div>

            <div class="flex items-center justify-between">
                <p class="text-sm text-grey-dark">{{ voicemail.duration }} seconds</p>

                <p class="text-sm text-grey-dark">
                    <a class="no-underline text-grey-dark hover:text-blue" :href="'/user/' + user_id + '/voicemails/' + voicemail.id" @click="voicemail.downloaded_at = true">
                        <i class="fas fa-cloud-download-alt fa-fw"></i>
                    </a>
                </p>
            </div>
        </div>

        <div class="w-full mb-4" v-if="data.voicemails.length === 0">
            <p class="font-thin text-grey-dark">There are no voicemails.</p>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {},
        data() {
            return {
                data: {
                    voicemails: [],
                },
                utilities: {
                    error: '',
                },
            }
        },
        methods: {
            getData() {
                let self = this

                axios.get('/api/user/' + self.user_id + '/voicemails')
                    .then(function (response) {
                        self.data.voicemails = response.data
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
        props: {
            user_id: {
                type: Number,
            },
        },
    }
</script>

<template>
    <div>
        <p class="text-grey text-xs">
            {{ data.humanReadable }}
        </p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: {
                    humanReadable: null,
                },
            }
        },
        methods: {
            handle() {
                let self = this
                let milliseconds = window.moment().diff(self.time)

                self.$emit('updated', milliseconds)

                if (milliseconds > 0) {
                    let time = window.moment(milliseconds)
                    let hours = time.format('HH')
                    let minutes = time.format('mm')
                    let seconds = time.format('ss')

                    if (milliseconds > 3600000) {
                        return self.data.humanReadable = hours + ':' + minutes + ':' + seconds
                    }

                    return self.data.humanReadable = minutes + ':' + seconds
                }
            },
        },
        mounted() {
            let self = this

            if (self.time) {
                self.handle()

                return setInterval(function () {
                    self.handle()
                }, 1000)
            }
        },
        props: {
            time: {
                type: String,
            },
        },
    }
</script>

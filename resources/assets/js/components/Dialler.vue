<template>
    <div class="w-full shadow border rounded bg-white">
        <div class="flex items-center justify-between font-medium text-lg p-3 py-4">
            {{ data.callStatus}}

            <p class="text-2xl cursor-pointer mr-2" @click="utilities.show = ! utilities.show" v-if="utilities.show">-</p>
            <p class="text-2xl cursor-pointer mr-2" @click="utilities.show = ! utilities.show" v-if=" ! utilities.show">+</p>
        </div>

        <div class="bg-white" v-if="utilities.show">
            <div class="px-3">
                <input type="number" class="w-full appearance-none my-2 px-2 py-4 rounded bg-grey-lighter dial-input" v-model="data.phoneNumber" v-if="utilities.state === 'idle'" @keyup.enter="dial()">

                <div class="w-full text-center text-red text-sm font-medium pt-2 pb-4" v-if="utilities.error">
                    {{ utilities.error }}
                </div>

                <div class="flex mb-2">
                    <div class="w-1/3 p-2 border rounded text-center mr-2 hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(1)">
                        1
                    </div>

                    <div class="w-1/3 p-2 border rounded text-center hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(2)">
                        2
                    </div>

                    <div class="w-1/3 p-2 border rounded text-center ml-2 hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(3)">
                        3
                    </div>
                </div>

                <div class="flex mb-2">
                    <div class="w-1/3 p-2 border rounded text-center mr-2 hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(4)">
                        4
                    </div>

                    <div class="w-1/3 p-2 border rounded text-center hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(5)">
                        5
                    </div>

                    <div class="w-1/3 p-2 border rounded text-center ml-2 hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(6)">
                        6
                    </div>
                </div>


                <div class="flex mb-2">
                    <div class="w-1/3 p-2 border rounded text-center mr-2 hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(7)">
                        7
                    </div>

                    <div class="w-1/3 p-2 border rounded text-center hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(8)">
                        8
                    </div>

                    <div class="w-1/3 p-2 border rounded text-center ml-2 hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(9)">
                        9
                    </div>
                </div>

                <div class="flex mb-2">
                    <div class="w-1/3 p-2 border rounded text-center mr-2 hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit('*')">
                        *
                    </div>

                    <div class="w-1/3 p-2 border rounded text-center hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit(0)">
                        0
                    </div>

                    <div class="w-1/3 p-2 border rounded text-center ml-2 hover:bg-grey-darker hover:border-grey-darker hover:text-white" @click="addDigit('#')">
                        #
                    </div>
                </div>
            </div>

            <div class="flex items-center" v-if="utilities.state === 'idle'">
                <a class="w-1/2 p-4 text-green hover:font-bold text-center cursor-pointer" @click.prevent="dial()">
                    Dial
                </a>

                <a class="w-1/2 p-4 text-grey hover:text-red text-center cursor-pointer" @click.prevent="clearPhoneNumber()">
                    Clear
                </a>
            </div>

            <div class="flex items-center" v-if="utilities.state === 'dialling'">
                <a class="w-full p-4 text-red hover:font-bold text-center cursor-pointer" @click.prevent="endCall()">
                    Cancel
                </a>
            </div>

            <div class="flex items-center" v-if="utilities.state === 'ringing'">
                <a class="w-1/2 px-4 py-4 bg-green-dark hover:bg-green text-brand-lightest text-center cursor-pointer" @click.prevent="acceptIncomingCall()">
                    Accept
                </a>

                <a class="w-1/2 px-4 py-4 bg-red-dark hover:bg-red text-brand-lightest text-center cursor-pointer" @click.prevent="declineIncomingCall()">
                    Decline
                </a>
            </div>

            <div class="flex items-center" v-if="utilities.state === 'live'">
                <a class="w-1/2 p-4 text-grey hover:text-blue text-center cursor-pointer" @click.prevent="mute()" v-if=" ! utilities.mute">
                    Mute
                </a>

                <a class="w-1/2 p-4 text-red hover:font-bold text-center cursor-pointer" @click.prevent="unmute()" v-if="utilities.mute">
                    Unmute
                </a>

                <a class="w-1/2 p-4 text-red hover:font-bold text-center cursor-pointer" @click.prevent="endCall()">
                    End
                </a>
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
                    callStatus: 'Connecting...',
                    phoneNumber: '',
                },
                utilities: {
                    error: '',
                    mute: false,
                    show: true,
                    state: 'idle',
                },
            }
        },
        methods: {
            refreshToken() {
                axios.post('/api/token', {forPage: window.location.pathname})
                    .then(function (data) {
                        Twilio.Device.setup(data.data.token, {
                            'enableRingingState': true
                        })

                        Twilio.Device.audio.outgoing(false)
                    })
            },

            listen() {
                let self = this

                Echo.join('presence')
                    .joining((user) => {
                        console.log(user.name + ' has come online')
                    })
                    .leaving((user) => {
                        console.log(user.name + ' has gone offline')
                    })
            },

            clearPhoneNumber() {
                let self = this

                self.utilities.error = ''

                self.data.phoneNumber = ''
            },

            updateCallStatus(status) {
                this.data.callStatus = status
            },

            declineIncomingCall() {
                let self = this

                self.updateCallStatus('Ready')

                self.utilities.state = 'idle'

                self.utilities.error = ''

                Twilio.Device.activeConnection().reject()
            },

            dial() {
                let self = this

                self.utilities.error = ''

                axios.post('/api/validate-phone-number', {phoneNumber: this.data.phoneNumber})
                    .then(function (data) {
                        self.updateCallStatus('Calling ' + data.data + '...')

                        self.utilities.state = 'dialling'

                        axios.post('/api/user/' + self.user.id + '/available', {'available': false})

                        Twilio.Device.connect({'phoneNumber': data.data})
                    }).catch(function (error) {
                    self.utilities.error = 'The phone number is invalid'
                })
            },

            acceptIncomingCall() {
                let self = this

                Twilio.Device.activeConnection().accept()

                self.utilities.state = 'live'

                self.utilities.error = ''
            },

            addDigit(number) {
                let self = this

                self.data.phoneNumber = self.data.phoneNumber + number

                if (Twilio.Device.activeConnection()) {
                    Twilio.Device.activeConnection().sendDigits(number.toString())
                }
            },

            mute() {
                let self = this

                self.utilities.mute = true

                Twilio.Device.activeConnection().mute(true)
            },

            unmute() {
                let self = this

                self.utilities.mute = false

                Twilio.Device.activeConnection().mute(false)
            },

            endCall() {
                let self = this

                self.utilities.state = 'idle'

                self.utilities.error = ''

                Twilio.Device.activeConnection().disconnect()

                self.updateCallStatus('Ready')
            },
        },
        mounted() {
            let self = this

            self.refreshToken()

            self.listen()

            setInterval(function () {
                self.refreshToken()
            }, 60000)

            Twilio.Device.ready(function (device) {
                axios.post('/api/user/' + self.user.id + '/available', {'available': true})

                self.updateCallStatus('Ready')
            })

            Twilio.Device.error(function (error) {
                self.updateCallStatus('ERROR: ' + error.message)
            })

            Twilio.Device.connect(function (connection) {
                axios.post('/api/user/' + self.user.id + '/available', {'available': false})

                self.utilities.state = 'live'

                self.updateCallStatus('In call with ' + connection.message.phoneNumber)
            })

            Twilio.Device.incoming(function (connection) {
                self.utilities.state = 'ringing'

                axios.post('/api/user/' + self.user.id + '/available', {'available': false})

                self.updateCallStatus('Incoming call from ' + connection.parameters.From)

                connection.accept(function () {
                    self.utilities.state = 'live'

                    self.updateCallStatus('In call with ' + connection.parameters.From)
                })

                connection.ignore(function () {
                    self.utilities.state = 'idle'

                    self.updateCallStatus('Ready')
                })
            })

            Twilio.Device.disconnect(function (connection) {
                self.utilities.state = 'idle'

                self.clearPhoneNumber()

                self.updateCallStatus('Ready')

                axios.post('/api/user/' + self.user.id + '/available', {'available': true})
            })

            Twilio.Device.offline(function (device) {
                //
            })

            setInterval(function () {
                axios.get('/api/keep-alive')
                    .catch(function (error) {
                        window.location.reload()
                    })
            }, 10000)
        },
        props: [
            'user',
        ],
    }
</script>

<template>
    <div class="w-full md:w-1/2 lg:w-1/3">
        <div :class="'mr-8 mb-8 shadow rounded bg-white border-solid border-l-4 border-' + (user.role.slug === 'administrator' ?  'red' : 'green') + ' px-6 py-4'">
            <div class="flex items-center">
                <a href="#">
                    <img src="https://i.imgur.com/qACoKgY.jpg" class="h-12 w-12 rounded-full">
                </a>

                <div class="flex flex-col ml-4">
                    <a class="font-bold text-grey-darkest no-underline" href="#">{{ user.name }}</a>

                    <span class="text-sm text-grey-dark mt-1">{{ user.email }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <p class="text-grey text-xs">Created {{ user.created_at | moment('Do MMMM YYYY') }}</p>

                <a class="no-underline text-grey hover:text-grey-dark cursor-pointer" @click="deactivate">
                    <i class="far fa-trash-alt fa-fw"></i>
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
                data: {},
                utilities: {
                    error: '',
                },
            }
        },
        methods: {
            deactivate() {
                this.$emit('deactivate', this.user)
            },
        },
        mounted() {
        },
        props: {
            user: {
                type: Object,
            },
        },
    }
</script>

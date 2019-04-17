<template>
    <div class="w-full md:w-1/2 lg:w-1/3">
        <div :class="'mr-8 mb-8 shadow rounded bg-white border-solid border-l-4 border-grey px-6 py-4'">
            <div class="flex items-center">
                <div class="flex flex-col">
                    <a class="font-bold text-grey-darkest no-underline" href="#">0{{ number.number.substring(2) }}</a>

                    <span class="text-sm text-grey-dark mt-1">Assigned to {{ number.user.name }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <p class="text-grey text-xs">Purchased {{ number.created_at | moment('Do MMMM YYYY') }}</p>

                <a class="no-underline text-grey hover:text-grey-dark cursor-pointer">
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
        methods: {},
        mounted() {
        },
        props: {
            number: {
                type: Object,
            },
        },
    }
</script>

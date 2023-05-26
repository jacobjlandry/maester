<template>
    <div v-if="showing">
        The modal will go here.
    </div>
    <button
        class="bg-blue-600 text-white px-4 py-2 text-sm uppercase tracking-wide font-bold rounded-lg"
        @click="this.open()"
        >
        Show Modal
    </button>
    <button
        class="bg-blue-600 text-white px-4 py-2 text-sm uppercase tracking-wide font-bold rounded-lg"
        @click="this.close()"
        >
        Close Modal
    </button>
</template>

<script>
    export default {
        data() {
            return {
                showing: false,
            }
        },
        methods: {
            open() {
                this.showing = true;
            },
            close() {
               this.showing = false;
            }
        }
    }
</script>

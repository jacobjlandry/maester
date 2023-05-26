<template>
    <Transition name="fade">
        <div v-if="showing">
            <div class="absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 w-1/2 h-2/3 bg-white border rounded-lg">
                <div class="create-task-header w-full h-12 bg-gray-500 px-4 py-2 flex justify-between text-white">
                    Create Task
                    <button
                        class="bg-blue-600 text-white px-4 py-2 text-sm uppercase tracking-wide font-bold rounded-lg"
                        @click="this.close()"
                        >
                        X
                    </button>
                </div>
                <div class="create-task-body p-4">
                    Create Task Form
                </div>
            </div>        
        </div>
    </Transition>
    <button
        class="bg-blue-600 text-white px-4 py-2 text-sm uppercase tracking-wide font-bold rounded-lg"
        @click="this.open()"
        >
        New Task
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

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: all 0.4s;
    }
    .fade-enter,
        .fade-leave-to {
        opacity: 0;
    }
</style>
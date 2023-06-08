<template>
    <Transition name="fade">
        <div v-if="showing">
            <div class="absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 w-1/2 h-2/3 bg-white border rounded-lg">
                <div class="create-task-header w-full h-12 bg-sky-500 px-4 py-2 flex justify-between text-white">
                    Create Task
                    <button
                        class="bg-sky-300 text-sky-100 px-4 py-2 text-sm uppercase tracking-wide font-bold rounded-lg"
                        @click="this.close()"
                        >
                        X
                    </button>
                </div>
                <div class="create-task-body p-4">
                    <div>
                        <input type="text" class="" placeholder="title" @change="this.setTitle" />
                    </div>
                    <div>
                        <input type="text" class="" placeholder="description" @change="setDescription" />
                    </div>
                    <div>
                        <button class="bg-sky-300 text-white px-4 py-2 text-sm uppercase tracking-wide font-bold rounded-lg" @click="save">
                            Save
                        </button>
                    </div>
                </div>
            </div>        
        </div>
    </Transition>
    <button class="bg-sky-500 hover:bg-sky-700 text-sky-100 p-4 w-14 h-14 text-sm uppercase tracking-wide font-bold rounded-full" @click="this.open()">
        <i class="fa-solid fa-plus fa-lg"></i>
    </button>
</template>

<script>
    export default {
        props: {
            list: Object|null,
            getTasks: Function,
        },
        data() {
            return {
                showing: false,
                title: null,
                description: null
            }
        },
        methods: {
            open() {
                this.showing = true;
            },
            close() {
               this.showing = false;
            },
            setTitle(event) {
                this.title = event.target.value;
            },
            setDescription(event) {
                this.description = event.target.value;
            },
            save() {
                axios
                .post('/api/tasks', { title: this.title, description: this.description, parent_id: this.list ? this.list._id : null } )
                .then(response => {
                    this.close();
                    this.getTasks(this.list);
                })
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
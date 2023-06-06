<template>
    <div class="bg-sky-950 text-white p-10 w-full">
        <div v-if="parent" class="text-sm cursor-pointer mb-4" @click="loadTask(grandParent)">
            <i class="fa-solid fa-chevron-left"></i> Back
        </div>
        <div class="text-4xl border-b-2 w-full p-2 mb-6">
            {{ title }}
        </div>
        <div v-if="description" class="text-base mb-6 px-4">
            {{ description }}
        </div>
        <div class="m-auto w-10">
            <i v-if="loading" class="fa-solid fa-list-check fa-beat-fade fa-2x"></i>
        </div>
        
        <div v-for="task in tasks">
            <task :task="task" :loadTask="loadTask"></task>
        </div>

        <div class="text-sky-800">
            <create-task :showing="false" :list="parent" :getTasks="getTasks"></create-task>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tasks: [],
                loading: true,
                title: "Todo",
                description: null,
                parent: null,
                grandParent: null,
            }
        },
        methods: {
            loadTask(task) {
                this.tasks = [];
                this.loading = true;
                if (task) {
                    this.parent = task;
                    if(task.parent_id) {
                        this.getGrandParentTask(task.parent_id);
                    } else {
                        this.grandParent = null;
                    }
                    this.title = task.title;
                    this.description = task.description;
                } else {
                    this.parent = null;
                    this.grandParent = null;
                    this.title = "Todo";
                    this.description = null;
                }
                
                this.getTasks();
            },
            getTasks() {
                axios
                .get('/api/tasks', { params: { parent: this.parent ? this.parent._id : null }})
                .then(response => {
                    this.loading = false;
                    this.tasks = response.data;
                })
            },
            getGrandParentTask(id) {
                axios
                .get('/api/tasks/' + id)
                .then(response => {
                    this.grandParent = response.data;
                })
            },
        },
        mounted() {
            this.getTasks();
        }
    }
</script>

<template>
    <div class="bg-sky-950 text-white p-10 w-full">
        <div v-if="parent" class="text-sm cursor-pointer mb-4" @click="loadTask(grandParent)">
            <i class="fa-solid fa-chevron-left"></i> Back
        </div>
        <div class="border-b-2 border-sky-100 w-full p-2 mb-6">
            <input type="text" class="w-full bg-sky-950 border-0 focus:ring-0 text-sky-100 text-4xl disabled:text-sky-100" v-model="this.title" :readonly="this.parent === null" @change="save" />
        </div>
        <div v-if="description" class="mb-6 px-4 w-full">
            <div class="w-full bg-sky-950 border-0 outline-none focus:outline-none focus:border-0 focus:ring-0 text-sky-100 text-base disabled:text-sky-100 resize-none" contenteditable :readonly="this.parent === null" @blur="setDescription">
                {{ description }}
            </div>
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
            setTitle(event) {
                this.title = event.target.innerText;
                this.save();
            },
            setDescription(event) {
                this.description = event.target.innerText;
                this.save();
            },
            save() {
                axios
                .patch(`/api/tasks/${this.parent._id}`, { title: this.title, description: this.description } )
                .then(response => {
                    this.getTasks(this.list);
                })
            },
        },
        mounted() {
            this.getTasks();
        }
    }
</script>

<template>
    <div class="bg-sky-950 text-white p-10 w-full">
        <div v-if="task" class="text-sm cursor-pointer mb-4" @click="loadTask(parent)">
            <i class="fa-solid fa-chevron-left"></i> Back
        </div>
        <div class="border-b-2 border-sky-100 w-full p-2">
            <input type="text" class="w-full bg-sky-950 border-0 focus:ring-0 text-sky-100 text-4xl disabled:text-sky-100" v-model="this.title" :readonly="this.task === null" @change="save" />
        </div>
        <div v-if="this.task" class="mb-6 px-4 w-full">
            <div v-if="this.due_datetime" class="pt-2 w-full bg-sky-950 border-0 outline-none text-sky-100 text-xs">Due: {{ this.due_datetime.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"}) }}</div>
            <div class="mt-4 w-full bg-sky-950 border-0 outline-none focus:outline-none focus:border-0 focus:ring-0 text-sky-100 text-base disabled:text-sky-100 resize-none" contenteditable :readonly="this.task === null" @blur="setDescription">
                {{ description ?? "Add a description" }}
            </div>
        </div>
        <div class="m-auto w-10">
            <i v-if="loading" class="fa-solid fa-list-check fa-beat-fade fa-2x"></i>
        </div>
        
        <div v-for="subTask in subTasks">
            <Transition name="bounce">
                <p v-if="!subTask.hide_on_complete || !subTask.completed" style="text-align: center;">
                    <task :task="subTask" @loadTask="loadTask" :class="this.styleTask(subTask)"></task>
                </p>
            </Transition>
        </div>

        <div class="flex flex-row justify-between mt-8">
            <button class="bg-sky-500 hover:bg-sky-700 text-sky-100 p-4 w-14 h-14 text-sm uppercase tracking-wide font-bold rounded-full" @click="this.create()">
                <i class="fa-solid fa-plus fa-lg"></i>
            </button>

            <options v-if="this.task" :task="this.task"></options>

            <div v-if="subTasks.length === 0 && !loading">
                <button class="bg-red-500 hover:bg-red-700 text-red-100 p-4 w-14 h-14 text-sm uppercase tracking-wide font-bold rounded-full" @click="this.delete()">
                    <i class="fa-solid fa-trash fa-lg"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                // state
                loading: true,
                // data
                subTasks: [],
                title: "Todo",
                description: null,
                due_datetime: null,
                // navigation
                task: null,
                parent: null,
            }
        },
        methods: {
            // load a new task page
            loadTask(task) {
                this.subTasks = [];
                this.loading = true;
                if (task) {
                    this.task = task;
                    if (task.parent_id) {
                        this.getParentTask(task.parent_id);
                    } else {
                        this.parent = null;
                    }
                    this.title = task.title;
                    this.description = task.description;
                    if (task.due_datetime) {
                        this.due_datetime = new Date(task.due_datetime);
                    }
                } else {
                    this.task = null;
                    this.parent = null;
                    this.title = "Todo";
                    this.description = null;
                }
                
                this.getTasks();
            },
            // pull a list of subtasks
            getTasks() {
                axios
                .get('/api/tasks', { params: { parent: this.task ? this.task._id : null }})
                .then(response => {
                    this.loading = false;
                    this.subTasks = response.data;
                })
            },
            // get task data for parent
            getParentTask(id) {
                axios
                .get('/api/tasks/' + id)
                .then(response => {
                    this.parent = response.data;
                })
            },
            // set title on change
            setTitle(event) {
                this.title = event.target.innerText;
                this.update();
            },
            // set description on change
            setDescription(event) {
                this.description = event.target.innerText;
                this.update();
            },
            // CRUD
            create() {
                axios
                .post('/api/tasks', { title: "New Task", user_id: 1, parent_id: this.task ? this.task._id : null } )
                .then(response => {
                    this.getTasks(this.list);
                })
            },
            update() {
                axios
                .patch(`/api/tasks/${this.task._id}`, { title: this.title, description: this.description, user_id: 1 } )
                .then(response => {
                    this.getTasks(this.list);
                })
            },
            delete() {
                axios
                .delete(`/api/tasks/${this.task._id}`)
                .then(response => {
                    this.loadTask(this.parent);
                })
            },
            styleTask(subTask) {
                if (subTask.completed) {
                    return 'text-sky-900';
                } else {
                    return 'text-sky-100';
                }
            },
        },
        mounted() {
            this.getTasks();
            // setInterval(this.getTasks, 5000);
        }
    }
</script>

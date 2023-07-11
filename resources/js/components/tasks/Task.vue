<template>
    <div v-if="taskData" class="px-4 my-2 flex flex-row">
        <div>
            <div v-if="!task.type || task.type == 'task'">
                <input type="checkbox" class="mr-4 border-sky-600 text-sky-500 bg-sky-100 focus:ring-0 rounded-full w-6 h-6" v-model="task.completed" v-bind:id="task._id" @click="complete" /> 
            </div>
            <div v-if="task.type && task.type == 'folder'">
                <i class="fa-solid fa-folder-open fa-lg pr-4"></i>
            </div>
            <div v-if="task.type && task.type == 'bug'">
                <i class="fa-solid fa-bug fa-lg pr-4"></i>
            </div>
            <div v-if="task.type && task.type == 'test'">
                <i class="fa-solid fa-vial fa-lg pr-4"></i>
            </div>
            <div v-if="task.type && task.type == 'test-pass'">
                <span class="stack fa-lg pr-4">
                    <i class="fa-solid fa-vial fa-lg"></i>
                    <i class="fa-solid fa-check text-green-500 fa-sm bottom-0 right-0"></i>
                </span>
            </div>
            <div v-if="task.type && task.type == 'test-fail'">
                <span class="stack fa-lg pr-4">
                    <i class="fa-solid fa-vial fa-lg"></i>
                    <i class="fa-solid fa-x text-red-500 fa-sm bottom-0 right-0"></i>
                </span>
            </div>
            <div v-if="task.type && task.type == 'deploy'">
                <i class="fa-solid fa-rocket fa-lg pr-4"></i>
            </div>
            <div v-if="task.type && task.type == 'weights'">
                <i class="fa-solid fa-dumbbell fa-lg pr-4"></i>
            </div>
            <div v-if="task.type && task.type == 'walk'">
                <i class="fa-solid fa-person-walking fa-lg pr-4"></i>
            </div>
            <div v-if="task.type && task.type == 'run'">
                <i class="fa-solid fa-person-running fa-lg pr-4"></i>
            </div>
        </div>
        <div class="font-bold cursor-pointer text-sky-100" @click="$emit('loadTask', this.task)">
            {{ taskData.title }}
        </div>
    </div>                      
</template>

<script>
    export default {
        props: {
            // task we are loading
            task: Object,
            task_id: String,
        },
        data() {
            return {
                // data
                taskData: null,
            }
        },
        methods: {
            // mark task as complete
            complete(event) {
                axios
                    .patch(`/api/tasks/${this.taskData._id}`, { title: this.taskData.title, completed: event.target.checked, completed_at: event.target.checked ? Date() : null} )
                    .then(response => (this.taskData = response.data));
            }
        },
        mounted() {
            // load task by id
            if (!this.task) {
                axios
                    .get(`/api/tasks/${this.task_id}`)
                    .then(response => (this.taskData = response.data));
            }

            // set task data if provided
            if (this.task) {
                this.taskData = this.task;
            }
        }
    }
</script>

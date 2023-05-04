<template>
    <div v-if="taskData" class="m-2 border rounded-lg border-blue-50 p-4">
        <div class="font-bold">
            {{ taskData.title }}
        </div>
        <div class="p-4 text-sm">
            {{ taskData.description }} ({{  taskData._id }})
        </div>
        <div v-for="subTask in tasks">
            <div class="px-10 text-xs">
                <a :href="'/tasks/' + subTask._id">{{  subTask.title }}</a>
            </div>
        </div>
    </div>                      
</template>

<script>
    export default {
        props: {
            task: Object,
            task_id: String,
        },
        data() {
            return {
                tasks: [],
                taskData: null,
            }
        },
        methods: {
            //
        },
        mounted() {
            if (!this.task) {
                console.log('fetching task');
                axios
                    .get('/api/tasks/' + this.task_id)
                    .then(response => (this.taskData = response.data));
            }
            if (this.task) {
                this.taskData = this.task;
                axios
                .get('/api/tasks', { params: { parent: this.taskData._id } })
                .then(response => (this.tasks = response.data));
            }
        }
    }
</script>

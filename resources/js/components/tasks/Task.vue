<template>
    <div class="m-2 border rounded-lg border-blue-50 p-4">
        <div class="font-bold">
            {{ task.title }}
        </div>
        <div class="p-4 text-sm">
            {{ task.description }} ({{  task._id }})
        </div>
        <div v-for="subTask in tasks">
            <task :task="subTask"></task>
        </div>
    </div>                      
</template>

<script>
    export default {
        props: {
            task: Object
        },
        data() {
            return {
                tasks: [],
            }
        },
        methods: {
            //
        },
        mounted() {
            axios
                .get('/api/tasks', { params: { parent: this.task._id } })
                .then(response => (this.tasks = response.data))
        }
    }
</script>

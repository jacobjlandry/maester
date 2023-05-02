<template>
    <div class="container bg-black text-white p-10">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div v-for="task in tasks">
                        <div v-if="!task.parent_id">
                            {{ task.title }} - {{ task.description }} <button class="rounded-full bg-blue-500 text-white p-2" @click="newTask(task._id)">+</button>
                            <div v-for="subTask in tasks">
                                <div v-if="subTask.parent_id && task._id === subTask.parent_id" class="pl-10">
                                    {{  subTask.title }} - {{ subTask.description }}
                                </div>
                            </div>
                        </div>                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tasks: [],
            }
        },
        methods: {
            newTask(parentId) {
                axios
                    .post('/api/tasks', {
                        title: "Added Subtask!",
                        description: "This works!",
                        parent: parentId
                    })
                    .then(function (response) {
                        console.log(response);
                    });
            }
        },
        mounted() {
            axios
                .get('/api/tasks')
                .then(response => (this.tasks = response.data))
        }
    }
</script>

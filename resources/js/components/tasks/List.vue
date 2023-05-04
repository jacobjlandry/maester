<template>
    <div class="container bg-black text-white p-10">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div v-for="task in tasks">
                        <task :task="task"></task>
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
            //
        },
        mounted() {
            axios
                .get('/api/tasks')
                .then(response => (this.tasks = response.data))
        }
    }
</script>

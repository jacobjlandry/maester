<template>
    <div class="container bg-black text-white p-10">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header underline underline-offset-4">Example Component</div>

                    <div class="card-body italic">
                        I'm an example component.
                    </div>

                    <button class="rounded-full bg-blue-500 text-blue-200 p-4 my-2" @click="increment">I've been clicked {{ count }} times!</button>

                    <div class="text-black">
                        <input type="text" v-model="newTitle" placeholder="New Task" />
                    </div>
                    <div class="text-black">
                        <input type="text" v-model="newDescription" placeholder="Description" />
                    </div>
                    <button class="rounded-full bg-blue-500 text-blue-200 p-4 my-2" @click="newTask">Create Task</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                count: 0,
                newTitle: '',
                newDescription: '',
            }
        },
        methods: {
            increment() {
                this.count++
            },
            newTask() {
                console.log(this.newTitle);
                console.log(this.newDescription);
                axios
                    .post('/api/tasks', {
                        title: this.newTitle,
                        description: this.newDescription
                    })
                    .then(function (response) {
                        console.log(response);
                    });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

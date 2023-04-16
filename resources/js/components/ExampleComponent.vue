<template>
    <div class="container bg-black text-white p-10">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header underline underline-offset-4">Example Component</div>

                    <div class="card-body italic">
                        I'm an example component.
                    </div>

                    <button class="rounded-full bg-blue-500 text-blue-200 p-4 my-2" @click="count++">I've been clicked {{ count }} times!</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                count: 0
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<template>
     <Transition name="fade">
         <div v-if="showing">
            <div class="absolute top-0 left-0 z-40 bg-black opacity-50 w-full h-full"></div>
             <div class="absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 w-1/2 h-2/3 bg-white border border-sky-900 rounded-lg z-50">
                 <div class="create-task-header w-full h-12 bg-sky-900 px-4 py-2 flex justify-between text-white">
                     Advanced Options
                     <button
                         class="bg-sky-300 text-sky-900 px-4 py-2 text-sm uppercase tracking-wide font-bold rounded-lg"
                         @click="this.close()"
                         >
                         <i class="fa-solid fa-xmark"></i>
                     </button>
                 </div>
                 <div class="create-task-body p-4 text-sky-900">
                    <div class="py-2">
                        <select class="border border-sky-900 rounded-lg py-2 pr-12 w-64" @change="setType" v-model="taskType">
                            <option value="task">Task</option>
                            <option value="folder">Folder</option>
                            <option value="bug">Bug</option>
                            <optgroup label="Steps">
                                <option value="test">Test</option>
                                <option value="deploy">Deploy</option>
                            </optgroup>
                            <optgroup label="Health">
                                <option value="weights">Weights</option>
                                <option value="walk">Walk</option>
                                <option value="run">Run</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="py-2">
                        <input type="checkbox" class="mr-4 border-sky-600 text-sky-500 bg-sky-100 focus:ring-0 rounded-full w-6 h-6" v-model="hiddenOnComplete" v-bind:id="task._id" @click="hideOnComplete" /> Hide on Complete
                    </div>
                    <div class="py=2">
                        <select class="border border-sky-900 rounded-lg py-2 pr-12 w-64" @change="moveTask" v-model="taskParent">
                            <option value="null">None</option>
                            <option v-for="task in this.tasks" :value="task._id">{{  task.title }}</option>
                        </select>
                    </div>
                 </div>
             </div>        
         </div>
     </Transition>
     <button class="bg-sky-500 hover:bg-sky-700 text-sky-100 p-4 w-14 h-14 text-sm uppercase tracking-wide font-bold rounded-full" @click="this.open()">
        <i class="fa-solid fa-scroll fa-lg"></i>
    </button>
 </template>

 <script>
     export default {
         props: {
            task: Object,
         },
         data() {
             return {
                showing: false,
                taskType: "task",
                taskParent: null,
                tasks: [],
                hiddenOnComplete: false,
                request: {
                    title: null,
                    user_id: 1,
                }
             }
         },
         methods: {
            getTasks() {
                axios
                .get('/api/tasks')
                .then(response => {
                    this.tasks = response.data;
                })
            },
            setType(event) {
                this.request.type = event.target.value;
                this.taskType = event.target.value;
                this.save();
            },
            moveTask(event) {
                if (event.target.value === "null") {
                    this.request.parent_id = null;
                    this.taskParent = null;
                } else {
                    this.request.parent_id = event.target.value;
                    this.taskParent = event.target.value;
                }
                
                if (this.task._id !== this.taskParent) {
                    this.save();
                }
            },
            hideOnComplete(event) {
                this.request.hideOnComplete = event.target.checked;
                this.save();
            },
             open() {
                 this.showing = true;
             },
             close() {
                this.showing = false;
             },
             save() {
                 axios
                 .patch(`/api/tasks/${this.task._id}`, this.request )
                 .then(response => {
                    //
                 })
             }
         },
         mounted() {
            if (this.task) {
                this.request.title = this.task.title;
                if (this.task.type) {
                    this.taskType = this.task.type;
                }
                if (this.task.parent) {
                    this.taskParent = this.task.parent;
                }
                if (this.task.hideOnComplete) {
                    this.hiddenOnComplete = this.task.hideOnComplete;
                }
            }

            this.getTasks();
         }
     }
 </script>

 <style scoped>
     .fade-enter-active,
     .fade-leave-active {
         transition: all 0.4s;
     }
     .fade-enter,
         .fade-leave-to {
         opacity: 0;
     }
 </style>
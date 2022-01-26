<template>
    <app-layout>
        <div class="pl-16">
            <h1 class="mb-8 mt-8 font-bold text-3xl">
                <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('activity.create')">Activity
                </inertia-link>
                <span class="text-indigo-400 font-medium">/</span> Add
            </h1>
            <div class="bg-white rounded-md shadow overflow-hidden max-w-2xl">
                <form @submit.prevent="store">
                    <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                        <label class="w-full">Activity Date:*</label>
                        <input type="date" v-model="form.activity_date"
                               class="border-2 border-indigo-400 pr-6 pl-3 pb-1 pt-2 mb-3 w-full"/>
                        <div v-if="errors.activity_date" class="text-red-600 font-bold">{{ errors.activity_date }}</div>
                        <label class="w-full ">Activity duration (in hours):*</label>
                        <input v-model="form.duration" type="number" min="0"
                               onkeyup="if(this.value<0){this.value= this.value * -1}" :error="form.errors.duration"
                               class="border-2 border-indigo-400 pr-6 pl-3 pb-1 pt-2 mb-3 w-full"/>
                        <div v-if="errors.duration" class="text-red-600 font-bold">{{ errors.duration }}</div>
                        <label class="w-full ">Description:*</label>
                        <textarea v-model="form.description"
                                  class="border-2 border-indigo-400 pr-6 pl-3 pb-1 pt-2 mb-3 w-full"/>
                        <div v-if="errors.description" class="text-red-600 font-bold">{{ errors.description }}</div>
                    </div>
                    <div class="px-3 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                        <loading-button :loading="form.processing" class="btn-indigo border-indigo-400 border-2 p-2"
                                        type="submit">Create Activity
                        </loading-button>
                    </div>
                </form>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import LoadingButton from '@/Jetstream/LoadingButton'
import Input from '@/Jetstream/Input'
import Label from '@/Jetstream/Label'

export default {
    metaInfo: {title: 'Create Activity'},
    components: {
        AppLayout,
        LoadingButton,
        Input,
        Label,
    },
    props: {
        errors: Object,
    },
    // remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                activity_date: null,
                duration: null,
                description: null,
            }),
        }
    },
    methods: {
        store() {
            this.form.post(this.route('activity.store'))
        },
    },
}
</script>

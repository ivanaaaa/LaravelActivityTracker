<template>
        <app-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Activity
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6"> Add activity </div>
                    </div>
                </div>
            </div>
        </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
    name: "Activity.vue",
    components: {
        AppLayout,
    },
}
</script>

<style scoped>

</style>

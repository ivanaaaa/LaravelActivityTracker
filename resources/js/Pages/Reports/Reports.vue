<template>
    <app-layout>
        <h1 class=" mt-8 font-bold text-3xl pl-16">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('reports')">Reports</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> List
        </h1>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form>
                        <div class="pl-8 pr-8 pt-8 -mr-6 flex flex-wrap">
                            <label class="w-full lg:w-1/4 mr-3">Date From:</label>
                            <label class="w-full lg:w-1/4">Date To:</label>
                        </div>
                        <div class="pl-8 pr-8 pb-8 -mr-6 -mb-8 flex flex-wrap">
                            <input type="date" v-model="form.date_from" :error="form.errors.date_from" class="border-2 border-indigo-400 pr-6 pl-3 pb-1 pt-2 mb-3 mr-3 w-full lg:w-1/4" >
                            <input type="date" v-model="form.date_to" :error="form.errors.date_to" class="border-2 border-indigo-400 pr-6 pl-3 pb-1 pt-2 mb-3 mr-3 w-full lg:w-1/4">
                            <loading-button :loading="form.processing" class="btn-indigo border-indigo-400 border-2 mb-3 p-2 mr-3 lg:w-1/8 bg-indigo-400 text-white" type="submit" @click.prevent="filter">Search</loading-button>
                            <input v-if="!mailHidden" type="email" v-model="form.email_to" :error="form.errors.email_to" class="border-2 border-indigo-400 pr-6 pl-3 pb-1 pt-2 mb-3 mr-3 ml-3 w-full lg:w-1/6" placeholder="Send to email*">
                            <loading-button :loading="form.processing" class="btn-indigo border-indigo-400 border-2 mb-3 p-2  lg:w-1/8 bg-indigo-400 text-white" type="submit" @click.prevent="emailReport">Email Report</loading-button>
                            <loading-button :loading="form.processing" class="btn-indigo border-indigo-400 border-2 mb-3 p-2 ml-3  lg:w-1/8 bg-indigo-400 text-white" type="submit" @click.prevent="printReport">Print Report</loading-button>
                        </div>
                    </form>
                    <div class="bg-white rounded-md shadow overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <tr class="text-left font-bold">
                                <th class="px-6 pt-6 pb-4">Id</th>
                                <th class="px-6 pt-6 pb-4">Activity Date</th>
                                <th class="px-6 pt-6 pb-4">Duration</th>
                                <th class="px-6 pt-6 pb-4">Description</th>
                            </tr>
                            <tr v-for="report in reports" :key="report.id" class=" hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t px-6 pt-2 pb-2">
                                    <div>
                                        {{ report.id }}
                                    </div>
                                </td>
                                <td class="border-t px-6">
                                    <div>
                                        {{ report.activity_date }}
                                    </div>
                                </td>
                                <td class="border-t px-6">
                                    <div>
                                        {{ report.duration }}
                                    </div>
                                </td>
                                <td class="border-t px-6">
                                    <div>
                                        {{ report.description }}
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="reports.length === 0">
                                <td class="border-t px-6 py-4 center" colspan="4">No reports found.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import LoadingButton from '@/Jetstream/LoadingButton'

export default {
    metaInfo: { title: 'Reports' },
    components: {
        AppLayout,
        LoadingButton,
    },
    props: {
        reports: Object
    },
    data() {
        return {
            form: this.$inertia.form({
                date_from: null,
                date_to: null,
                email_to: null,
            }),
            mailHidden: true,
        }
    },
    methods: {
        filter() {
            this.form.post(this.route('reports.filter'))
        },
        emailReport() {
            if(this.mailHidden)
            {
                this.mailHidden = false;
            }
            else
            {
                this.form.post(this.route('reports.email'))
            }

        },
        printReport() {
            this.$alert('print');
        },
    },
}
</script>

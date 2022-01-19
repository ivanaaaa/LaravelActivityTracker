<template>
        <h1 class=" mt-8 font-bold text-3xl pl-16">
            <inertia-link class="text-indigo-400 hover:text-indigo-600">Reports</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> List
        </h1>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
</template>

<script>

export default {
    metaInfo: { title: 'MailReport' },
    props: {
        reports: Object
    },
}
</script>

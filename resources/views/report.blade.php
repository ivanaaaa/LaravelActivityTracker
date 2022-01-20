<html>
<body>
    <h1 class=" mt-8 font-bold text-3xl pl-16">
        <inertia-link style="color:indigo">Reports</inertia-link>
        <span>/</span> List
    </h1>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white rounded-md shadow overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <tr class="text-left font-bold">
                            <th style="padding: 6px">Id</th>
                            <th style="padding: 6px">Activity Date</th>
                            <th style="padding: 6px">Duration</th>
                            <th style="padding: 6px">Description</th>
                        </tr>
                        @if (!$reports->count())
                        <tr>
                            <td style="border: #1a202c; padding: 6px; align-content: center;" colspan="4">No reports found.</td>
                        </tr>
                        @endif
                        @if($reports->count())
                        @foreach($reports as $report)
                            {{$report->id}}
                        <tr class=" hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-6 pt-2 pb-2">
                                <div>
                                    {{ $report->id }}
                                </div>
                            </td>
                            <td class="border-t px-6">
                                <div>
                                    {{ $report->activity_date }}
                                </div>
                            </td>
                            <td class="border-t px-6">
                                <div>
                                    {{ $report->duration }}
                                </div>
                            </td>
                            <td class="border-t px-6">
                                <div>
                                    {{ $report->description }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


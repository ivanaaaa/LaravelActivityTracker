<html>
<body>
    <h1 class=" mt-8 font-bold text-3xl pl-16">
        <inertia-link style="color:indigo">Reports</inertia-link>
        <span>/</span> List
    </h1>
    <div class="py-12">
                    <table class="w-full whitespace-nowrap">
                        <tr class="font-bold">
                            <th>Id</th>
                            <th>Activity Date</th>
                            <th>Duration</th>
                            <th>Description</th>
                        </tr>
                        @if (!$reports->count())
                        <tr>
                            <td colspan="4">No reports found.</td>
                        </tr>
                        @endif
                        @if($reports->count())
                        @foreach($reports as $report)
                        <tr>
                            <td class="px-6 index-font">
                                <div>
                                    {{ $report->id }}
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ $report->activity_date }}
                                </div>
                            </td>
                            <td class="px-6">
                                <div>
                                    {{ $report->duration }}
                                </div>
                            </td>
                            <td class="px-6">
                                <div>
                                    {{ $report->description }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                    </table>
    </div>
</body>
</html>

<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
        padding: 6px;
        width: available;
    }
    .index-font {
        font-weight: bold;
    }
</style>

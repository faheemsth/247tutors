<style>
    /* Add your custom styles here */
    table.table-bordered {
        border: 2px solid #ddd; /* Custom border color */
        border-collapse: collapse; /* Collapse borders */
        width: 100%; /* Make the table fill its container */
    }

    table.table-bordered th, table.table-bordered td {
        border: 2px solid #ddd; /* Apply border to header and data cells */
        padding: 8px; /* Add padding for better readability */
        text-align: left; /* Align text to the left within cells */
    }

    /* Optionally, you can add hover effect on table rows */
    table.table-bordered tbody tr:hover {
        background-color: #f5f5f5; /* Light gray background on hover */
    }
</style>

<!-- Your existing table HTML -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Member</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($recents))
            @foreach ($recents as $recent)
                <tr>
                    <td  style="display: flex;align-items: center;gap: 20px;">

                            <div class="flex-shrink-0 me-2">
                                <img src="{{ Auth::user()->image }}" alt=""
                                    width="50" height="50"
                                    class="avatar-xs rounded-circle">
                            </div>
                            <div class="flex-grow-1">
                                {{ $recent->first_name . '  ' . $recent->last_name }}
                            </div>

                    </td>
                    <td>{{ $recent->status }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

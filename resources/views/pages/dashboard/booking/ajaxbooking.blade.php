@forelse($bookings as $key => $booking)
<tr>
    <td>{{ optional($booking->student)->first_name . ' ' . optional($booking->student)->last_name }}</td>
    <td>{{ optional($booking->tutor)->first_name . ' ' . optional($booking->tutor)->last_name }}</td>
    <th>{{ optional($booking->subjects)->name }}</th>
    <td>{{ $booking->duration }} minute</td>
    <td>{{ $booking->amount }} /Hr</td>

    <td>
        @if ($booking->request_refound != 1)
            <span
                class="badge
            @if ($booking->status == 'Completed') bg-success
            @elseif($booking->status == 'Scheduled')
            bg-info
            @elseif($booking->status == 'Cancelled By Tutor' || $booking->status == 'Cancelled By User')
            bg-danger
            @elseif($booking->status == 'Cancelled')
            bg-danger
            @elseif($booking->status == 'Pending')
            bg-warning @endif
            ">
                {{ $booking->status }}
            </span>
        @else
            <span class="badge bg-secondary">
                {{ 'Request Refound' }}
            </span>
        @endif
    </td>

</tr>
{{ $bookings->links() }}
@empty
<tr>
    <td colspan="6">Record not found</td>
</tr>
@endforelse

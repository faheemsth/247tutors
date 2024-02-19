@forelse ($bookings as $booking)
                                @php
                                    $tutorsubjectoffers = App\Models\TutorSubjectOffer::where('tutor_id', $booking->tutor_id)
                                        ->with(['level', 'tutor', 'subject'])
                                        ->get();
                                @endphp
                                @if (!empty(optional($booking->student)->role_id == '4'))
                                    <tr>
                                        <th>{{ $booking->uuid }}</th>
                                        <th>{{ optional($booking->student)->username }}</th>
                                        <th class="text-capitalize">
                                            <a href="{{url('tutor/profile').'/'.optional($booking->tutor)->id}}" class="text-decoration-none text-dark">
                                                {{ optional($booking->tutor)->username }}
                                            </a>
                                        </th>
                                        <th class="text-capitalize">{{ optional($booking->subjects)->name }}</th>
                                        <td>
                                            @if ($booking->booking_fee !== 'Free')
                                               @if ((int) $booking->booking_fee == $booking->booking_fee)
                                                    £{{ $booking->booking_fee }}.00/hr
                                                @else
                                                    £{{ $booking->booking_fee }}/hr
                                                @endif
                                            @else
                                                {{ $booking->booking_fee }}
                                            @endif
                                        </td>
                                        <td>{{ $booking->duration }} minutes</td>
                                        <td>
                                            @if ($booking->request_refound != 1 && $booking->request_refound != '2')
                                                <span
                                                    class="badge
                                @if ($booking->status == 'Completed') bg-success
                                @elseif($booking->status == 'Scheduled') bg-info
                                @elseif($booking->status == 'Cancelled By Tutor' || $booking->status == 'Cancelled By User') bg-danger
                                @elseif($booking->status == 'Cancelled') bg-danger
                                @elseif($booking->status == 'Pending') bg-warning @endif
                            ">
                                                    {{ $booking->status }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    @if($booking->request_refound == '2')
                                                     {{ 'Paid Refund To User' }}
                                                    @else
                                                     {{ 'Request Refund' }}
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                        <td>{!! $booking->booking_date . '<br>' . $booking->booking_time !!}</td>
                                        <th class="dropdown">
                                            
                                            
                                            
                                            
                                            
                                            
                                            @if ($booking->request_refound == '2' || $booking->request_refound == '1' || $booking->status == 'Cancelled' || $booking->status == 'Cancelled By User' || $booking->status == 'Cancelled By Tutor')
                                            <button class="btn student-table-details dropdown-toggle" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                                Actions
                                            </button>
                                            @else
                                            <button class="btn student-table-details dropdown-toggle" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            @endif
                                            
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" >
                                                @if (Auth::user()->role_id == 5)
                                                    <li>
                                                        <a href="{{ url('chats') . '/' . $booking->tutor->id }}"
                                                            class="dropdown-item">Let’s
                                                            chat with Tutor</a>
                                                        <a href="{{ url('chats') . '/' . $booking->student->id }}"
                                                            class="dropdown-item">Let’s chat with Student</a>
                                                    </li>
                                                @endif

                                                @if (Auth::user()->role_id == 5)
                                                    <li>
                                                        <a class="dropdown-item cursor-pointer"
                                                            onclick="UpdateSubject('{{ $booking->id }}','{{ $booking->date }}','{{ $booking->time }}','{{ $booking->subjects->name }}','{{ $booking->tutor->username }}','£{{ $booking->amount }}/hr')">
                                                            Edit Booking
                                                        </a>
                                                    </li>
                                                @endif

                                                @if ($booking->status != 'Completed')
                                                    @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                                                        @if ($booking->status != 'Pending')
                                                            @if (
                                                                $booking->status != 'Cancelled' &&
                                                                    $booking->status != 'Cancelled By User' &&
                                                                    $booking->status != 'Cancelled By Tutor')
                                                                <li>
                                                                    <!--<a target="_blank"-->
                                                                    <!--    href="{{ url('online-meeting/') . '/' . $booking->uuid }}"-->
                                                                    <!--    class="dropdown-item cursor-pointer">Join-->
                                                                    <!--    Meeting</a>-->
                                                                    @if(Auth::user()->role_id == 4)
                                                                        @if($booking->is_meet_student <= 1)
                                                                        <a target="_blank"
                                                                            href="{{ url('zoom-online-meeting/') . '/' . $booking->uuid }}"
                                                                            class="dropdown-item cursor-pointer">Join Meeting
                                                                             Zoom</a>
                                                                        @endif
                                                                    @endif
                                                                    
                                                                    @if(Auth::user()->role_id == 3)
                                                                        @if($booking->is_meet_tutor <= 1)
                                                                        <a target="_blank"
                                                                            href="{{ url('zoom-online-meeting/') . '/' . $booking->uuid }}"
                                                                            class="dropdown-item cursor-pointer">Join Meeting
                                                                             Zoom</a>
                                                                        @endif
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    @if (
                                                        $booking->status != 'Cancelled By Tutor' &&
                                                            $booking->status != 'Cancelled By User' &&
                                                            $booking->status != 'Cancelled')
                                                        @if (Auth::user()->role_id == 3)
                                                            @if ($booking->status != 'Scheduled')
                                                                <li>
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Scheduled&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Accept
                                                                        Booking</a>
                                                                </li>
                                                            @endif
                                                        @endif

                                                        @if (Auth::user()->role_id == 3)
                                                            <li>
                                                                @if ($booking->status != 'Scheduled')
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Cancelled By Tutor&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Reject
                                                                        Booking</a>
                                                                @else
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Cancelled&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Cancel
                                                                        Booking</a>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="Rescheduled('{{ $booking->uuid }}',' {{ $booking->tutor_id }}',' {{ $booking->subjects->name }}',' {{ $booking->subjects->id }}')"
                                                                        class="dropdown-item cursor-pointer">Reschedule
                                                                        Booking</a>
                                                                @endif
                                                            </li>
                                                        @elseif (Auth::user()->role_id == 4 || Auth::user()->role_id == 5)
                                                            <li>
                                                                @if ($booking->status != 'Scheduled')
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Cancelled&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Reject
                                                                        Booking</a>
                                                                @else
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Cancelled&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Cancel
                                                                        Booking</a>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="Rescheduled('{{ $booking->uuid }}',' {{ $booking->tutor_id }}',' {{ $booking->subjects->name }}',' {{ $booking->subjects->id }}')"
                                                                        class="dropdown-item cursor-pointer">Reschedule
                                                                        Booking</a>
                                                                @endif
                                                            </li>
                                                            @if ($booking->status != 'Pending')
                                                                <li>
                                                                    <a href="javascript:void(0)"
                                                                        class="dropdown-item cursor-pointer"
                                                                        onclick="yourButtonId('{{ $booking->uuid }}','Completed','{{ $booking->tutor_id }}')">Mark
                                                                        As
                                                                        Completed </a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($booking->request_refound != '1' && $booking->request_refound != '2')
                                                        <li>
                                                            <a onClick="viewRating(`{{ $booking->uuid }}`)"
                                                                class="dropdown-item cursor-pointer" style="cursor: pointer">View Feedback</a>
                                                        </li>
                                                        @if (Auth::user()->role_id != 3)
                                                        <li>
                                                            <a onclick="Refund('{{$booking->uuid}}','{{$booking->tutor_id}}','{{optional($booking->tutor)->username}}','{{optional($booking->subjects)->name}}','{{$booking->booking_fee}}')"
                                                            class="dropdown-item " style="cursor: pointer">
                                                            Request Refund
                                                            </a>
                                                            
                                                        </li>
                                                        @endif
                                                    @endif
                                                @endif
                                                     
                                            </ul>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                        </th>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="9">No bookings available</td>
                                </tr>
                            @endforelse
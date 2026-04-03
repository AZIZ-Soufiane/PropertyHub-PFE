@extends('layouts.app')

@section('title', 'My Appointments - PropertyHub')

@section('content')
<div class="px-4 pt-6 pb-12">
    <!-- Header -->
    <h1 class="text-2xl font-black text-slate-900 mb-1">My Appointments</h1>
    <p class="text-sm text-slate-600 mb-6">View and manage your property viewings</p>

    <!-- Tabs -->
    <div class="flex gap-2 mb-6 border-b border-slate-200">
        <button class="px-4 py-3 font-semibold text-primary-600 border-b-2 border-primary-600 transition-smooth">
            Upcoming (3)
        </button>
        <button class="px-4 py-3 font-semibold text-slate-600 hover:text-slate-900 transition-smooth">
            Completed
        </button>
        <button class="px-4 py-3 font-semibold text-slate-600 hover:text-slate-900 transition-smooth">
            Cancelled
        </button>
    </div>

    <!-- Appointments List -->
    <div class="space-y-4">
        <!-- Appointment Card 1 -->
        <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-primary-600">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-bold text-slate-900">Modern Luxury Villa</h3>
                    <p class="text-xs text-slate-600 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        New York, USA
                    </p>
                </div>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">Confirmed</span>
            </div>

            <div class="py-3 border-y border-slate-100 space-y-2">
                <p class="text-sm flex items-center gap-2 text-slate-700">
                    <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    <strong>April 15, 2026</strong> at <strong>2:00 PM</strong>
                </p>
                <p class="text-sm flex items-center gap-2 text-slate-700">
                    <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    Assigned to: <strong>John Smith</strong>
                </p>
            </div>

            <div class="flex gap-2 mt-3">
                <a href="{{ route('properties.show', ['id' => 1]) }}" class="flex-1 text-center text-sm font-semibold px-3 py-2 bg-primary-50 text-primary-600 rounded-lg hover:bg-primary-100 transition-smooth">
                    View Property
                </a>
                <button class="flex-1 text-center text-sm font-semibold px-3 py-2 bg-slate-100 text-slate-900 rounded-lg hover:bg-slate-200 transition-smooth">
                    Reschedule
                </button>
            </div>
        </div>

        <!-- Appointment Card 2 -->
        <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-amber-500">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-bold text-slate-900">Contemporary Apartment</h3>
                    <p class="text-xs text-slate-600 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        Los Angeles, USA
                    </p>
                </div>
                <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">Pending</span>
            </div>

            <div class="py-3 border-y border-slate-100 space-y-2">
                <p class="text-sm flex items-center gap-2 text-slate-700">
                    <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    <strong>April 18, 2026</strong> at <strong>10:00 AM</strong>
                </p>
                <p class="text-sm flex items-center gap-2 text-slate-700">
                    <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    Assigned to: <strong>Sarah Johnson</strong>
                </p>
            </div>

            <div class="flex gap-2 mt-3">
                <a href="{{ route('properties.show', ['id' => 2]) }}" class="flex-1 text-center text-sm font-semibold px-3 py-2 bg-primary-50 text-primary-600 rounded-lg hover:bg-primary-100 transition-smooth">
                    View Property
                </a>
                <button class="flex-1 text-center text-sm font-semibold px-3 py-2 bg-slate-100 text-slate-900 rounded-lg hover:bg-slate-200 transition-smooth">
                    Reschedule
                </button>
            </div>
        </div>

        <!-- Appointment Card 3 -->
        <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-emerald-500">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-bold text-slate-900">Penthouse Downtown</h3>
                    <p class="text-xs text-slate-600 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        Miami, USA
                    </p>
                </div>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">Confirmed</span>
            </div>

            <div class="py-3 border-y border-slate-100 space-y-2">
                <p class="text-sm flex items-center gap-2 text-slate-700">
                    <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    <strong>April 20, 2026</strong> at <strong>4:00 PM</strong>
                </p>
                <p class="text-sm flex items-center gap-2 text-slate-700">
                    <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    Assigned to: <strong>Michael Brown</strong>
                </p>
            </div>

            <div class="flex gap-2 mt-3">
                <a href="{{ route('properties.show', ['id' => 3]) }}" class="flex-1 text-center text-sm font-semibold px-3 py-2 bg-primary-50 text-primary-600 rounded-lg hover:bg-primary-100 transition-smooth">
                    View Property
                </a>
                <button class="flex-1 text-center text-sm font-semibold px-3 py-2 bg-slate-100 text-slate-900 rounded-lg hover:bg-slate-200 transition-smooth">
                    Reschedule
                </button>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="mt-8 p-4 bg-primary-50 border border-primary-200 rounded-xl text-center">
        <p class="text-sm text-slate-700 mb-3">Ready to view more properties?</p>
        <a href="{{ route('properties.index') }}" class="inline-block bg-primary-600 text-white font-semibold py-2.5 px-6 rounded-lg hover:bg-primary-700 transition-smooth">
            Browse Properties ↗
        </a>
    </div>
</div>
@endsection
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($appointments as $appointment)
                <div class="card p-6 border-l-4 border-primary-500 hover:shadow-lg transition-shadow">
                    <!-- Date Badge -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-slate-600">Scheduled</p>
                            <p class="text-lg font-semibold text-slate-900">
                                {{ \Carbon\Carbon::parse($appointment['date_time'])->format('M d, Y') }}
                            </p>
                            <p class="text-primary-500 font-semibold">
                                {{ \Carbon\Carbon::parse($appointment['date_time'])->format('g:i A') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if($appointment['status'] === 'scheduled')
                                    bg-sky-100 text-sky-800
                                @elseif($appointment['status'] === 'completed')
                                    bg-emerald-100 text-emerald-800
                                @elseif($appointment['status'] === 'cancelled')
                                    bg-rose-100 text-rose-800
                                @endif
                            ">
                                {{ ucfirst($appointment['status']) }}
                            </span>
                        </div>
                    </div>

                    <!-- Agent/Buyer Info -->
                    <div class="mb-4 p-3 bg-slate-50 rounded-lg">
                        @if(isset($appointment['agent']))
                            <p class="text-sm text-slate-600">Agent</p>
                            <p class="font-semibold text-slate-900">{{ $appointment['agent']['name'] }}</p>
                            <p class="text-sm text-slate-600">{{ $appointment['agent']['email'] }}</p>
                        @else
                            <p class="text-sm text-slate-600">Buyer</p>
                            <p class="font-semibold text-slate-900">{{ $appointment['buyer']['name'] ?? 'N/A' }}</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    @if($appointment['status'] === 'scheduled')
                        <div class="space-y-2">
                            <button onclick="editAppointment({{ $appointment['id'] }})" class="w-full btn-secondary text-sm">
                                ✎ Reschedule
                            </button>
                            <button onclick="cancelAppointment({{ $appointment['id'] }})" class="w-full btn-secondary text-sm text-rose-600 border-rose-200">
                                ✕ Cancel
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
function editAppointment(appointmentId) {
    // Modal or redirect to reschedule
    alert('Reschedule appointment: ' + appointmentId);
}

function cancelAppointment(appointmentId) {
    if (confirm('Are you sure you want to cancel this appointment?')) {
        // Submit cancel request
        alert('Appointment cancelled');
    }
}
</script>
@endpush
@endsection

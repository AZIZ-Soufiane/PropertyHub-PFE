@extends('layouts.app')

@section('title', 'Book Appointment - PropertyHub')

@section('content')
<div class="px-4 pt-6 pb-12">
    <!-- Back Button -->
    <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 text-primary-600 font-semibold mb-6 hover:text-primary-700 transition-smooth">
        ← Back
    </a>

    <!-- Header -->
    <h1 class="text-2xl font-black text-slate-900 mb-1">Book Appointment</h1>
    <p class="text-sm text-slate-600 mb-6">Schedule a time to view this property</p>

    <!-- Property Summary Card -->
    <div class="bg-white rounded-xl p-4 mb-6 shadow-sm border border-slate-100">
        <div class="flex gap-4">
            <div class="w-20 h-20 bg-gradient-to-br from-primary-400 to-primary-500 rounded-lg flex-shrink-0"></div>
            <div class="flex-1">
                <h3 class="font-bold text-slate-900">Modern Luxury Villa</h3>
                <p class="text-xs text-slate-600 mt-1">New York, USA</p>
                <p class="text-lg font-black text-primary-600 mt-2">$850,000</p>
            </div>
        </div>
    </div>

    <!-- Booking Form -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 mb-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Your Details</h2>
        
        <form method="POST" action="{{ route('appointments.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="property_id" value="1">

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Full Name</label>
                <input type="text" name="name" required placeholder="John Doe"
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
                @error('name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Email Address</label>
                <input type="email" name="email" required placeholder="john@example.com"
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
                @error('email')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Phone Number</label>
                <input type="tel" name="phone" required placeholder="+1 (555) 123-4567"
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
                @error('phone')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Date -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Preferred Date</label>
                <input type="date" name="date" required
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth">
                @error('date')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Time Slots -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-3">Available Times</label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="relative flex items-center cursor-pointer">
                        <input type="radio" name="time" value="09:00" required class="sr-only peer">
                        <div class="peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 w-full p-2 text-center border border-slate-200 rounded-lg font-semibold text-sm hover:border-primary-400 transition-smooth">
                            9:00 AM
                        </div>
                    </label>
                    <label class="relative flex items-center cursor-pointer">
                        <input type="radio" name="time" value="12:00" class="sr-only peer">
                        <div class="peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 w-full p-2 text-center border border-slate-200 rounded-lg font-semibold text-sm hover:border-primary-400 transition-smooth">
                            12:00 PM
                        </div>
                    </label>
                    <label class="relative flex items-center cursor-pointer">
                        <input type="radio" name="time" value="15:00" class="sr-only peer">
                        <div class="peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 w-full p-2 text-center border border-slate-200 rounded-lg font-semibold text-sm hover:border-primary-400 transition-smooth">
                            3:00 PM
                        </div>
                    </label>
                    <label class="relative flex items-center cursor-pointer">
                        <input type="radio" name="time" value="10:00" class="sr-only peer">
                        <div class="peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 w-full p-2 text-center border border-slate-200 rounded-lg font-semibold text-sm hover:border-primary-400 transition-smooth">
                            10:00 AM
                        </div>
                    </label>
                    <label class="relative flex items-center cursor-pointer">
                        <input type="radio" name="time" value="14:00" class="sr-only peer">
                        <div class="peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 w-full p-2 text-center border border-slate-200 rounded-lg font-semibold text-sm hover:border-primary-400 transition-smooth">
                            2:00 PM
                        </div>
                    </label>
                    <label class="relative flex items-center cursor-pointer">
                        <input type="radio" name="time" value="17:00" class="sr-only peer">
                        <div class="peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 w-full p-2 text-center border border-slate-200 rounded-lg font-semibold text-sm hover:border-primary-400 transition-smooth">
                            5:00 PM
                        </div>
                    </label>
                </div>
                @error('time')<p class="text-rose-500 text-xs mt-2">{{ $message }}</p>@enderror
            </div>

            <!-- Message -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Additional Message (Optional)</label>
                <textarea name="message" rows="3" placeholder="Tell the agent about yourself..."
                          class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-smooth resize-none"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-primary-600 text-white font-semibold py-3 rounded-lg hover:bg-primary-700 transition-smooth mt-6">
                Confirm Appointment
            </button>
        </form>
    </div>

    <!-- Agent Contact Card -->
    <div class="bg-gradient-to-r from-primary-50 to-slate-50 rounded-xl p-4 border border-primary-200">
        <h3 class="font-bold text-slate-900 mb-2">Questions?</h3>
        <p class="text-sm text-slate-600 mb-3">Contact the agent directly</p>
        <div class="space-y-2">
            <a href="mailto:john@propertyagent.com" class="block text-sm font-semibold text-primary-600 hover:text-primary-700">📧 john@propertyagent.com</a>
            <a href="tel:+15551234567" class="block text-sm font-semibold text-primary-600 hover:text-primary-700">📞 +1 (555) 123-4567</a>
        </div>
    </div>
</div>
@endsection
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 mb-2">Your Email</label>
                        <input type="email" id="email" name="email" required 
                               class="input-field w-full"
                               placeholder="john@example.com">
                        @error('email')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Your Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-900 mb-2">Your Phone</label>
                        <input type="tel" id="phone" name="phone" required 
                               class="input-field w-full"
                               placeholder="(555) 123-4567">
                        @error('phone')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Selection -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-900 mb-2">Select Date</label>
                        <input type="date" id="date" name="date" required 
                               class="input-field w-full"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('date')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Time Selection -->
                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-900 mb-2">Select Time</label>
                        <select id="time" name="time" required class="input-field w-full">
                            <option value="">-- Select Time --</option>
                            <option value="09:00 AM">9:00 AM</option>
                            <option value="10:00 AM">10:00 AM</option>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="12:00 PM">12:00 PM</option>
                            <option value="01:00 PM">1:00 PM</option>
                            <option value="02:00 PM">2:00 PM</option>
                            <option value="03:00 PM">3:00 PM</option>
                            <option value="04:00 PM">4:00 PM</option>
                            <option value="05:00 PM">5:00 PM</option>
                        </select>
                        @error('time')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-900 mb-2">Additional Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="4" 
                                  class="input-field w-full"
                                  placeholder="Tell the agent about your interests or requirements..."></textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full btn-primary py-3 font-semibold">
                        ✓ Confirm Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

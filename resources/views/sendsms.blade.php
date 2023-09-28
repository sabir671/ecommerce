<form method="POST" action="{{ route('sendsms') }}">
    @csrf

    <!-- Mobile Number -->
    <div class="mt-4">
        <x-input-label for="mobile_number" :value="__('Mobile Number')" />
        <x-text-input id="mobile_number" class="block mt-1 w-full" type="text" name="mobile_number" required />
    </div>

    <!-- Message -->
    <div class="mt-4">
        <x-input-label for="message" :value="__('Message')" />
        <textarea id="message" name="message" rows="4" class="block mt-1 w-full" required></textarea>
    </div>

    <!-- Submit Button -->
    <div class="mt-4">
        <x-primary-button>
            {{ __('Send SMS') }}
        </x-primary-button>
    </div>
</form>

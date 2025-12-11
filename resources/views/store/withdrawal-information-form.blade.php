<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Request Withdrawal') }}
        </h2>

    </header>

    <form method="post" action="{{ route('withdrawal.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="amount" :value="__('Amount')" />
            <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" required autofocus autocomplete="amount" />
            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
        </div>

        <div>
            <x-input-label for="bank_account_name" :value="__('Bank Account Name')" />
            <x-text-input id="bank_account_name" name="bank_account_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="bank_account_name" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_account_name')" />
        </div>

        <div>
            <x-input-label for="bank_account_number" :value="__('Bank Account Number')" />
            <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full" required autofocus autocomplete="bank_account_number" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
        </div>

        <div>
            <x-input-label for="bank_name" :value="__('Bank Name')" />
            <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="bank_name" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Submit') }}</x-primary-button>

        </div>
    </form>
</section>



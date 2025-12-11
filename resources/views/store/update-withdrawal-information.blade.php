<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Withdrawal') }}
        </h2>

    </header>

    <form method="post" action="{{ route('withdrawal.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="bank_account_name" :value="__('Bank Account Name')" />
            <x-text-input id="bank_account_name" name="bank_account_name" type="text" class="mt-1 block w-full" :value="old('bank_account_name', $withdrawal->bank_account_name)" autofocus autocomplete="bank_account_name" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_account_name')" />
        </div>

        <div>
            <x-input-label for="bank_account_number" :value="__('Bank Account Number')" />
            <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full" :value="old('bank_account_number', $withdrawal->bank_account_number)" autofocus autocomplete="bank_account_number" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
        </div>

        <div>
            <x-input-label for="bank_name" :value="__('Bank Name')" />
            <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" :value="old('bank_name', $withdrawal->bank_name)" autofocus autocomplete="bank_name" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

        </div>
    </form>
</section>




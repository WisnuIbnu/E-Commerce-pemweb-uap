<!-- resources/views/seller/withdrawals/create.blade.php -->
<x-seller-layout>
<x-slot name="title">Request Withdrawal - SORAÉ</x-slot>

<div style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('seller.withdrawals.index') }}" style="color: var(--color-secondary); text-decoration: none;">
            ← Back to Withdrawals
        </a>
    </div>

    <div style="background: var(--color-white); padding: 40px; border-radius: 15px; box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);">
        <h1 style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 30px;">
            Request Withdrawal
        </h1>

        <div style="background: var(--color-light); padding: 25px; border-radius: 10px; margin-bottom: 30px;">
            <div style="color: var(--color-tertiary); margin-bottom: 5px;">Available Balance</div>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--color-primary);">
                Rp {{ number_format($store->balance, 0, ',', '.') }}
            </div>
        </div>

        <form method="POST" action="{{ route('seller.withdrawals.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label required">Withdrawal Amount</label>
                <input type="number" name="amount" class="form-input" 
                       value="{{ old('amount') }}" 
                       placeholder="50000" 
                       min="50000" 
                       max="{{ $store->balance }}" 
                       step="1000" required>
                <p style="font-size: 0.85rem; color: var(--color-tertiary); margin-top: 5px;">
                    Minimum: Rp 50,000
                </p>
            </div>

            <div class="form-group">
                <label class="form-label required">Bank Name</label>
                <select name="bank_name" class="form-select" required>
                    <option value="">Select Bank</option>
                    <option value="BCA">BCA</option>
                    <option value="Mandiri">Mandiri</option>
                    <option value="BNI">BNI</option>
                    <option value="BRI">BRI</option>
                    <option value="CIMB Niaga">CIMB Niaga</option>
                    <option value="Danamon">Danamon</option>
                    <option value="Permata">Permata</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label required">Account Number</label>
                <input type="text" name="account_number" class="form-input" 
                       value="{{ old('account_number') }}" 
                       placeholder="1234567890" required>
            </div>

            <div class="form-group">
                <label class="form-label required">Account Name</label>
                <input type="text" name="account_name" class="form-input" 
                       value="{{ old('account_name') }}" 
                       placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label class="form-label">Notes (Optional)</label>
                <textarea name="notes" class="form-textarea" 
                          placeholder="Additional notes...">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                💸 Submit Withdrawal Request
            </button>
        </form>
    </div>
</div>

</x-seller-layout>

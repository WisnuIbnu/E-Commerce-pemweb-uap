<!-- resources/views/admin/categories/create.blade.php -->
<x-admin-layout>
<x-slot name="title">Add Category - SORAÉ</x-slot>

<div style="max-width: 700px;">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.categories.index') }}" style="color: var(--color-secondary); text-decoration: none;">
            ← Back to Categories
        </a>
    </div>

    <div style="background: var(--color-white); padding: 40px; border-radius: 15px; box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);">
        <h1 style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 30px;">
            Add New Category
        </h1>

        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label required">Category Name</label>
                <input type="text" name="name" class="form-input" 
                       value="{{ old('name') }}" 
                       placeholder="e.g., Men's Clothing" required>
            </div>

            <div class="form-group">
                <label class="form-label">Icon (Emoji)</label>
                <input type="text" name="icon" class="form-input" 
                       value="{{ old('icon') }}" 
                       placeholder="e.g., 👔" 
                       maxlength="10">
                <p style="font-size: 0.85rem; color: var(--color-tertiary); margin-top: 5px;">
                    Optional: Add an emoji icon for the category
                </p>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea" 
                          placeholder="Brief description of the category...">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                ✅ Create Category
            </button>
        </form>
    </div>
</div>

</x-admin-layout>


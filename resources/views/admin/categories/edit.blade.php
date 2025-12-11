<!-- resources/views/admin/categories/edit.blade.php -->
<x-admin-layout>
<x-slot name="title">Edit Category - SORAÉ</x-slot>

<div style="max-width: 700px;">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.categories.index') }}" style="color: var(--color-secondary); text-decoration: none;">
            ← Back to Categories
        </a>
    </div>

    <div style="background: var(--color-white); padding: 40px; border-radius: 15px; box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);">
        <h1 style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 30px;">
            Edit Category
        </h1>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label required">Category Name</label>
                <input type="text" name="name" class="form-input" 
                       value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Icon (Emoji)</label>
                <input type="text" name="icon" class="form-input" 
                       value="{{ old('icon', $category->icon) }}" 
                       maxlength="10">
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea">{{ old('description', $category->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                💾 Update Category
            </button>
        </form>
    </div>
</div>

</x-admin-layout>

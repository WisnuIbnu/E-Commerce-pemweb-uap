<!-- resources/views/admin/categories/index.blade.php -->
<x-admin-layout>
<x-slot name="title">Product Categories - SORAÉ</x-slot>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}

.categories-table {
    background: var(--color-white);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
}

.category-icon {
    font-size: 2rem;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-light);
    border-radius: 10px;
}
</style>

<div class="page-header">
    <div>
        <h1 style="font-size: 2.5rem; color: var(--color-primary);">Product Categories</h1>
        <p style="color: var(--color-secondary);">Manage product categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        ➕ Add Category
    </a>
</div>

<div class="categories-table">
    <table class="table">
        <thead>
            <tr>
                <th>Icon</th>
                <th>Name</th>
                <th>Description</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>
                        <div class="category-icon">
                            {{ $category->icon ?? '📦' }}
                        </div>
                    </td>
                    <td>
                        <strong style="color: var(--color-primary); font-size: 1.1rem;">
                            {{ $category->name }}
                        </strong>
                    </td>
                    <td style="color: var(--color-secondary);">
                        {{ Str::limit($category->description, 80) }}
                    </td>
                    <td>
                        <span style="padding: 5px 15px; background: var(--color-light); border-radius: 20px; font-weight: 600;">
                            {{ $category->products_count }} products
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="btn btn-primary" style="padding: 8px 15px; font-size: 0.9rem;">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 8px 15px; font-size: 0.9rem;">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 60px 20px;">
                        <div style="font-size: 3rem; margin-bottom: 15px;">📦</div>
                        <p style="color: var(--color-tertiary);">No categories found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($categories->hasPages())
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $categories->links() }}
    </div>
@endif

</x-admin-layout>

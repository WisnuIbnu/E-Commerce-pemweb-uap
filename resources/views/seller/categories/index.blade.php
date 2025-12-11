@extends('layouts.app')

@section('title', 'Categories - DrizStuff')

@push('styles')
<style>
.seller-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: var(--spacing-xl);
    padding: var(--spacing-2xl) 0;
}

.categories-content {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.categories-table-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.table-wrapper {
    overflow-x: auto;
}

.categories-table {
    width: 100%;
    border-collapse: collapse;
}

.categories-table thead {
    background: var(--light-gray);
}

.categories-table th {
    padding: var(--spacing-md);
    text-align: left;
    font-weight: 600;
    font-size: 14px;
    color: var(--dark);
    border-bottom: 2px solid var(--border);
}

.categories-table td {
    padding: var(--spacing-md);
    border-bottom: 1px solid var(--border);
}

.categories-table tbody tr:hover {
    background: var(--light-gray);
}

.category-cell {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
}

.category-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: var(--radius-md);
    background: var(--light-gray);
}

.category-info h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.category-tagline {
    font-size: 12px;
    color: var(--gray);
}

.action-buttons {
    display: flex;
    gap: var(--spacing-xs);
}

.btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
    background: var(--white);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    font-size: 14px;
}

.btn-icon:hover {
    background: var(--light-gray);
    transform: scale(1.1);
}

.empty-state {
    text-align: center;
    padding: var(--spacing-2xl);
    color: var(--gray);
}

.empty-icon {
    font-size: 64px;
    margin-bottom: var(--spacing-md);
}

@media (max-width: 768px) {
    .seller-layout {
        grid-template-columns: 1fr;
    }
    
    .page-header {
        flex-direction: column;
        align-items: stretch;
        gap: var(--spacing-md);
    }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="seller-layout">
        <!-- Sidebar -->
        @include('seller.partials.sidebar', ['activeMenu' => 'categories'])

        <!-- Main Content -->
        <main class="categories-content">
            <div class="page-header">
                <h1>🏷️ Product Categories</h1>
                <a href="{{ route('seller.categories.create') }}" class="btn btn-primary">
                    ➕ Add New Category
                </a>
            </div>

            <div class="categories-table-card">
                @if($categories->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">🏷️</div>
                        <h3>No categories yet</h3>
                        <p>Create categories to organize your products</p>
                        <a href="{{ route('seller.categories.create') }}" class="btn btn-primary" style="margin-top: var(--spacing-md);">
                            ➕ Create Your First Category
                        </a>
                    </div>
                @else
                    <div class="table-wrapper">
                        <table class="categories-table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Parent Category</th>
                                    <th>Description</th>
                                    <th>Products</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="category-cell">
                                                @if($category->image)
                                                    <img 
                                                        src="{{ asset('storage/' . $category->image) }}" 
                                                        alt="{{ $category->name }}"
                                                        class="category-image">
                                                @else
                                                    <div class="category-image" style="display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                                        🏷️
                                                    </div>
                                                @endif
                                                <div class="category-info">
                                                    <h4>{{ $category->name }}</h4>
                                                    @if($category->tagline)
                                                        <div class="category-tagline">{{ $category->tagline }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($category->parent)
                                                <span class="badge badge-info">{{ $category->parent->name }}</span>
                                            @else
                                                <span class="badge badge-primary">Main Category</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 14px; color: var(--gray);">
                                                {{ $category->description }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">{{ $category->products->count() }} products</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('seller.categories.edit', $category) }}" class="btn-icon" title="Edit">
                                                    ✏️
                                                </a>
                                                <form method="POST" action="{{ route('seller.categories.destroy', $category) }}" style="display: inline;" onsubmit="return confirm('Are you sure? This will affect {{ $category->products->count() }} products.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon" title="Delete" {{ $category->products->count() > 0 ? 'disabled' : '' }}>
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div style="padding: var(--spacing-lg);">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
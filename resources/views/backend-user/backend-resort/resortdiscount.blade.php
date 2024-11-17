@extends('backend-user.newlayout')

@section('newuser-section')
    <!-- Include required CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: #f3f4f6;
            min-height: 100vh;
        }

        .main-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
        }

        .card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            background: white;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .card-content {
            padding: 2rem;
        }

        .add-rule-section {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: #111827;
            margin-bottom: 1rem;
        }

        .btn-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s;
            border: none;
        }

        .btn-modern.btn-primary {
            background-color: #111827;
            color: white;
        }

        .btn-modern.btn-primary:hover {
            background-color: #1f2937;
        }

        .btn-modern.btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-modern.btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-modern.btn-success {
            background-color: #059669;
            color: white;
        }

        .btn-modern.btn-success:hover {
            background-color: #047857;
        }

        .rules-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .rule-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.25rem;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .rule-item:hover {
            border-color: #d1d5db;
        }

        .rule-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
            background: #f9fafb;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #6b7280;
            box-shadow: 0 0 0 2px rgba(107, 114, 128, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
    </style>

    <div class="main-container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Discount Management for Resort:<br>{{ $discounts->first()->resort->name ?? 'Unknown Resort' }}</h1>
            </div>
            <div class="card-content">
                <!-- Add New Rule Section -->
                <div class="add-rule-section">
                    <h2 class="section-title">Add New Resort Discount Rule</h2>
                    <button class="btn-modern btn-primary" data-bs-toggle="modal" data-bs-target="#addDiscountModal">
                        <i class="fas fa-plus"></i>
                        Add Dsicount Rule
                    </button>
                </div>

                <!-- Current Rules Section -->
                <h2 class="section-title">Current Discount Rules</h2>
                <div class="rules-list">
                    @foreach ($discounts as $discount)
                        <div class="rule-item">
                            <div class="rule-content">
                                <span class="fw-medium">{{ $discount->nights }}+ nights</span>
                                <span class="text-muted">→</span>
                                <span class="text-success fw-medium">{{ $discount->discount }}% discount</span>
                            </div>
                            <div class="btn-group">
                                <button class="btn-modern btn-success" data-bs-toggle="modal" data-bs-target="#editDiscountModal{{ $discount->id }}">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <a href="{{ route('resort.discount.delete', $discount->id) }}"
                                   class="btn-modern btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this discount?');">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </a>
                            </div>
                        </div>

                        <!-- Edit Discount Modal -->
                        <div class="modal fade" id="editDiscountModal{{ $discount->id }}" tabindex="-1"
                             aria-labelledby="editDiscountLabel{{ $discount->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('resort.discount.update') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDiscountLabel{{ $discount->id }}">Edit Discount</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="{{ $discount->id }}">
                                            <div class="mb-3">
                                                <label for="nights{{ $discount->id }}" class="form-label">Minimum Nights</label>
                                                <input type="number" class="form-control" name="nights"
                                                    id="nights{{ $discount->id }}" value="{{ $discount->nights }}"
                                                    min="1" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="discount{{ $discount->id }}" class="form-label">Discount (%)</label>
                                                <input type="number" class="form-control" name="discount"
                                                    id="discount{{ $discount->id }}" value="{{ $discount->discount }}"
                                                    min="0" max="100" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn-modern btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn-modern btn-success">Update Discount</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Add Discount Modal -->
                <div class="modal fade" id="addDiscountModal" tabindex="-1"
                     aria-labelledby="addDiscountLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('resort.discount.save', $id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDiscountLabel">Add New Discount Rule</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nights" class="form-label">Minimum Nights</label>
                                        <input type="number" class="form-control" name="nights" id="nights"
                                            placeholder="Enter minimum nights" min="1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="discount" class="form-label">Discount (%)</label>
                                        <input type="number" class="form-control" name="discount" id="discount"
                                            placeholder="Enter discount percentage" min="0" max="100" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-modern btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn-modern btn-primary">Add Discount</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

{{-- <div class="container">
        <h1>Discount Management</h1>

        <div class="add-rule-section">
            <h2>Add New Discount Rule</h2>
            <div class="input-group">
                <input type="number" id="nights" placeholder="Minimum Nights" min="1">
                <input type="number" id="discount" placeholder="Discount Percentage" min="0" max="100">
                <button class="btn btn-primary" onclick="addRule()">
                    <i class="fas fa-plus"></i>
                    Add Rule
                </button>
            </div>
        </div>

        <h2>Current Discount Rules</h2>
        <div class="rules-list" id="rulesList">
            <!-- Rules will be added here dynamically -->
        </div>

        <button class="btn btn-primary btn-save" onclick="saveChanges()">
            <i class="fas fa-save"></i>
            Save Changes
        </button>

        <div class="success-message" id="successMessage">
            Changes saved successfully!
        </div>
    </div> --}}

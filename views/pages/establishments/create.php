<style>
    .create-card {
        border-radius: 20px;
        border: 1px solid var(--border-color-1);
        background: var(--card-bg-1);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .form-section-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-color-1);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .form-section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: var(--border-color-1);
    }
    .custom-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-secondary-1);
        margin-bottom: 0.5rem;
        display: block;
    }
    .modern-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-color-1);
        background: var(--header-bg-1);
        color: var(--text-color-1);
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .modern-input:focus {
        outline: none;
        border-color: var(--primary-color-1);
        box-shadow: 0 0 0 4px rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.1);
    }
    .btn-create {
        background: var(--primary-color-1);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.2);
    }
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.3);
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="create-card">
            <!-- Header Section -->
            <div style="padding: 2.5rem; background: linear-gradient(to bottom right, rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.05), transparent); border-bottom: 1px solid var(--border-color-1);">
                <h2 style="margin: 0; font-weight: 800; font-size: 1.5rem; color: var(--text-color-1);">Establishment Registration</h2>
                <p style="margin: 0.5rem 0 0; color: var(--text-secondary-1); font-size: 0.9rem;">Register a new business entity in the health and safety database.</p>
            </div>

            <!-- Form Body -->
            <div style="padding: 2.5rem;">
                <form action="/establishments/store" method="POST">
                    
                    <!-- General Information -->
                    <div class="form-section-title">
                        <i class="fas fa-building"></i> Business Profile
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-md-7 mb-4">
                            <label class="custom-label">Trade Name / Business Name</label>
                            <input type="text" name="name" class="modern-input" required placeholder="e.g. Central Mall Food Plaza">
                        </div>
                        
                        <div class="col-md-5 mb-4">
                            <label class="custom-label">Industry Sector</label>
                            <select name="type" class="modern-input" required>
                                <option value="">Select Category</option>
                                <option value="Restaurant/Cafe">Restaurant/Cafe</option>
                                <option value="Accommodation">Accommodation</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Industrial">Industrial</option>
                                <option value="Warehouse">Warehouse</option>
                                <option value="Healthcare">Healthcare</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="custom-label">Official Business Location</label>
                            <div style="position: relative;">
                                <i class="fas fa-map-marker-alt" style="position: absolute; left: 1rem; top: 1rem; color: var(--text-secondary-1); font-size: 0.85rem;"></i>
                                <textarea name="location" class="modern-input" style="padding-left: 2.5rem;" rows="2" placeholder="Street, Barangay, City, Province..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Person -->
                    <div class="form-section-title">
                        <i class="fas fa-user-tie"></i> Ownership & Point of Contact
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="custom-label">Owner / Authorized Manager</label>
                            <input type="text" name="owner" class="modern-input" placeholder="Full Legal Name">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="custom-label">Contact Number (Mobile/Landline)</label>
                            <input type="text" name="phone" class="modern-input" placeholder="09XX XXX XXXX">
                        </div>

                        <div class="col-md-12">
                            <label class="custom-label">Official Email (For Electronic Certificates)</label>
                            <input type="email" name="email" class="modern-input" placeholder="business@example.com">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="margin-top: 3.5rem; display: flex; justify-content: flex-end; align-items: center; gap: 1.5rem;">
                        <a href="/establishments" style="text-decoration: none; font-weight: 700; color: var(--text-secondary-1); font-size: 0.9rem;">Discard Entry</a>
                        <button type="submit" class="btn-create">
                            <i class="fas fa-check-circle me-2"></i> Register Establishment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

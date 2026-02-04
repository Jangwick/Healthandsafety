<div class="card shadow-sm" style="max-width: 800px; margin: 0 auto; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem;">
        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">Registration Form</h3>
        <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Enter the establishment details below.</p>
    </div>
    <div class="card-body" style="padding: 2rem;">
        <form action="/establishments/store" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Business Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Central Mall">
                </div>
                <div class="form-group">
                    <label class="form-label">Business Type</label>
                    <select name="type" class="form-control" required style="appearance: auto;">
                        <option value="">Select Category</option>
                        <option value="Restaurant/Cafe">Restaurant/Cafe</option>
                        <option value="Accommodation">Accommodation</option>
                        <option value="Commercial">Commercial</option>
                        <option value="Industrial">Industrial</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Education">Education</option>
                    </select>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Location Address</label>
                    <input type="text" name="location" class="form-control" required placeholder="Street, Barangay, City">
                </div>
                <div class="form-group">
                    <label class="form-label">Owner Name</label>
                    <input type="text" name="owner" class="form-control" placeholder="Full Name">
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="09XX XXX XXXX">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="contact@business.com">
                </div>
            </div>

            <div style="margin-top: 2.5rem; display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="/establishments" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; background: var(--primary-color-1); font-weight: 600;">
                    Complete Registration
                </button>
            </div>
        </form>
    </div>
</div>

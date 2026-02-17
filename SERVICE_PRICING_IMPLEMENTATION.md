# Service Pricing Implementation - Basic Setup

## Overview
This document outlines the implementation of service pricing functionality without payment gateway integration. This is a basic setup that allows manual payment tracking.

## Database Changes

### 1. Services Table - New Fields
- `price` (decimal 10,2) - Service price amount
- `is_free` (boolean) - Flag to mark service as free
- `currency` (string 3) - Currency code (default: UGX)

### 2. Service Registrations Table - New Fields
- `amount_paid` (decimal 10,2) - Amount paid by registrant
- `payment_status` (enum) - Status: pending, paid, failed, refunded
- `payment_method` (string) - Payment method used (mobile_money, card, cash, bank_transfer)
- `transaction_reference` (string) - Reference number for payment
- `paid_at` (timestamp) - When payment was completed
- `payment_notes` (text) - Admin notes about payment

## Model Updates

### Service Model
**New Methods:**
- `isFree()` - Check if service is free
- `getFormattedPriceAttribute()` - Get formatted price with currency (e.g., "UGX 50,000")

### ServiceRegistration Model
**New Methods:**
- `isPaid()` - Check if payment is completed
- `isPending()` - Check if payment is pending
- `getPaymentStatusColorAttribute()` - Get badge color for payment status

## Controller Updates

### Admin ServiceController
- Updated `store()` and `update()` methods to handle pricing fields
- Validates price, is_free, and currency fields
- Auto-sets is_free based on price (if price is 0)

### ServiceRegistrationController
- Updated `store()` method to:
  - Check if service is free or paid
  - Set payment_status to 'paid' for free services
  - Set payment_status to 'pending' for paid services
  - Show appropriate success message with payment instructions

## Frontend Changes

### Public Services Page
**Service Cards Now Display:**
- "FREE" badge for free services (green badge)
- Price with currency for paid services (large, bold text)
- Schedule information with calendar emoji

### Admin Services Dashboard
**Services Table:**
- Added "Price" column showing either "FREE" badge or formatted price
- Updated edit button to include pricing data attributes
- Modal form now includes:
  - Price input field
  - "This service is free" checkbox
  - Currency is set to UGX by default

**Service Registrations Table:**
- Added "Amount" column showing service price
- Added "Payment Status" column with color-coded badges:
  - Green: Paid
  - Yellow: Pending
  - Red: Failed
  - Gray: Refunded
- Removed "Address" column to make room for payment info

## How It Works

### For Free Services:
1. User registers for service
2. Registration is automatically marked as "paid"
3. User receives confirmation message

### For Paid Services:
1. User registers for service
2. Registration is marked as "pending"
3. User receives message with payment amount and instructions
4. Admin manually updates payment status after receiving payment

## Next Steps (Future Enhancements)

### Phase 2: Payment Gateway Integration
- Integrate Flutterwave or Paystack
- Automatic payment processing
- Online payment during registration
- Automatic payment confirmation
- Email receipts

### Phase 3: Admin Payment Management
- Mark registrations as paid from admin dashboard
- Add payment method and transaction reference
- Add payment notes
- View payment history
- Export payment reports

### Phase 4: Advanced Features
- Partial payments
- Refund processing
- Payment reminders via email/SMS
- Financial reporting and analytics
- Integration with accounting software

## Migration Instructions

Run these migrations in order:
```bash
php artisan migrate
```

This will:
1. Add pricing fields to services table
2. Add payment tracking fields to service_registrations table
3. Seed services with default pricing (all free initially)

## Testing Checklist

- [ ] Create a new service with a price
- [ ] Create a new free service
- [ ] Register for a free service (should auto-confirm)
- [ ] Register for a paid service (should show pending)
- [ ] View registrations in admin dashboard
- [ ] Edit service pricing
- [ ] Verify payment status badges display correctly
- [ ] Verify price displays on public services page

## Configuration

Default currency is set to UGX (Ugandan Shillings). To change:
- Update the default in the migration
- Or set per service in admin dashboard (future enhancement)

## Notes

- All existing services will be marked as free by default
- Admins can update pricing for each service individually
- Payment status must be updated manually by admin for now
- No actual payment processing occurs in this phase

# Giving/Tithe Module - Database Design Documentation

## Database Schema Explanation

### Giver Information Fields
| Field | Type | Purpose | Why Necessary |
|-------|------|---------|---------------|
| `member_id` | Foreign Key (nullable) | Links to church members | Allows member giving history tracking, nullable for guest giving |
| `guest_name` | String (nullable) | Guest giver's name | Required for receipts and acknowledgment when no member account |
| `guest_email` | String (nullable) | Guest email address | Enables receipt delivery and follow-up communication |
| `guest_phone` | String (nullable) | Guest phone number | Alternative contact method, required for mobile money |

**Business Logic**: Either `member_id` OR guest fields should be populated, never both.

### Giving Details Fields
| Field | Type | Purpose | Why Necessary |
|-------|------|---------|---------------|
| `giving_type` | Enum | Categorizes giving | Biblical distinction between tithes (10%), offerings (freewill), donations (specific causes) |
| `amount` | Decimal(10,2) | Giving amount | Core financial data, decimal for precise currency handling |
| `currency` | String(3) | ISO currency code | Multi-currency support for international churches |
| `purpose` | Text (nullable) | Specific cause/fund | Tracks designated giving (building fund, missions, etc.) |
| `notes` | Text (nullable) | Giver's message | Personal notes, prayer requests, or special instructions |

### Payment Information Fields
| Field | Type | Purpose | Why Necessary |
|-------|------|---------|---------------|
| `payment_method` | Enum | How payment was made | Different processing workflows for cash vs digital payments |
| `transaction_reference` | String (nullable) | External transaction ID | Links to mobile money/bank transaction for verification |
| `payment_provider` | String (nullable) | Service provider name | Identifies MTN, Airtel, specific bank for reconciliation |
| `payment_account` | String (nullable) | Account/phone used | Helps with payment verification and dispute resolution |

### Transaction Status & Tracking Fields
| Field | Type | Purpose | Why Necessary |
|-------|------|---------|---------------|
| `status` | Enum | Transaction state | Workflow management (pending → completed/failed) |
| `payment_date` | Timestamp (nullable) | When payment occurred | Different from created_at, actual payment timing |
| `confirmed_at` | Timestamp (nullable) | Admin confirmation time | Audit trail for manual verification |
| `confirmed_by` | Foreign Key (nullable) | Which admin confirmed | Accountability for financial confirmations |

### Financial Accountability Fields
| Field | Type | Purpose | Why Necessary |
|-------|------|---------|---------------|
| `receipt_number` | String (unique, nullable) | Generated receipt ID | Legal requirement, unique identifier for tax purposes |
| `receipt_sent` | Boolean | Receipt delivery status | Ensures all givers receive acknowledgment |
| `processing_fee` | Decimal(8,2) (nullable) | Transaction fees | Transparency in fee deduction from mobile money/cards |
| `net_amount` | Decimal(10,2) (nullable) | Amount after fees | Actual amount received by church |

### Audit Trail Fields
| Field | Type | Purpose | Why Necessary |
|-------|------|---------|---------------|
| `ip_address` | IP Address (nullable) | Request origin | Security tracking, fraud prevention |
| `user_agent` | Text (nullable) | Browser/device info | Technical audit trail |
| `metadata` | JSON (nullable) | Additional data | Flexible storage for payment gateway responses |
| `soft_deletes` | Timestamp | Deletion tracking | Financial records should never be permanently deleted |

## Giving Types Explained

### 1. **Tithe** 
- Biblical 10% of income
- Regular, systematic giving
- Personal spiritual discipline

### 2. **Offering**
- Freewill gifts beyond tithe
- Spontaneous acts of worship
- Variable amounts

### 3. **Donation**
- Specific cause giving
- Project-based contributions
- Often one-time gifts

### 4. **Special Offering**
- Emergency appeals
- Seasonal collections (Christmas, Easter)
- Guest speaker offerings

## Payment Methods Supported

### 1. **Cash**
- Traditional church giving
- Requires manual confirmation
- No processing fees

### 2. **Mobile Money**
- MTN Mobile Money, Airtel Money
- Instant verification possible
- Small processing fees

### 3. **Bank Transfer**
- Direct bank deposits
- Requires reference matching
- Minimal fees

### 4. **Card**
- Credit/Debit cards
- Online payment processing
- Higher processing fees

### 5. **Check**
- Traditional method
- Requires bank clearance
- No processing fees

## Status Workflow

```
pending → completed (successful payment)
pending → failed (payment failed)
pending → cancelled (user/admin cancelled)
```

## Security & Compliance Features

### 1. **Audit Trail**
- Every transaction tracked with IP and user agent
- Admin confirmations logged with user ID and timestamp
- Soft deletes preserve financial history

### 2. **Receipt Management**
- Unique receipt numbers for tax compliance
- Tracking of receipt delivery
- Email/SMS receipt options

### 3. **Financial Transparency**
- Processing fees clearly tracked
- Net amounts calculated automatically
- Purpose/designation clearly recorded

### 4. **Data Protection**
- Guest information handled securely
- Payment details encrypted in transit
- Compliance with financial regulations

## Indexes for Performance

### Single Column Indexes
- `member_id` - Member giving history queries
- `giving_type` - Reporting by giving type
- `payment_method` - Payment method analysis
- `status` - Status-based filtering
- `payment_date` - Date range queries
- `receipt_number` - Receipt lookups

### Composite Indexes
- `(giving_type, status)` - Reporting queries
- `(member_id, giving_type)` - Member giving patterns
- `(payment_date, status)` - Financial reporting

This design ensures:
- **Scalability**: Handles growth in giving volume
- **Accountability**: Complete audit trail
- **Flexibility**: Supports various payment methods
- **Compliance**: Meets financial record requirements
- **User Experience**: Fast queries with proper indexing
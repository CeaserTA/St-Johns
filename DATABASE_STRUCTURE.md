# St. Johns Church Management System - Database Structure

## Overview
This document outlines the database structure for the St. Johns Church Management System, a Laravel-based application for managing church members, events, services, groups, and announcements.

## Database Design Principles
- **Referential Integrity**: All foreign key relationships are properly constrained
- **Performance Optimized**: Strategic indexes on frequently queried columns
- **Data Safety**: Soft deletes on critical entities to prevent accidental data loss
- **Scalability**: Normalized structure to support growth
- **Laravel Conventions**: Follows Laravel naming and structural conventions

## Entities and Relationships

### 1. Users Table
**Purpose**: Authentication and system access management

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | varchar(255) | NOT NULL | User's full name |
| email | varchar(255) | NOT NULL, UNIQUE | Email address for login |
| email_verified_at | timestamp | NULLABLE | Email verification timestamp |
| password | varchar(255) | NOT NULL | Hashed password |
| role | enum('user', 'admin') | DEFAULT 'user' | User role for authorization |
| remember_token | varchar(100) | NULLABLE | Remember me token |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Last update time |

**Indexes**: 
- PRIMARY KEY (id)
- UNIQUE KEY (email)

---

### 2. Members Table
**Purpose**: Church membership management

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| user_id | bigint | NULLABLE, FOREIGN KEY | Link to user account |
| full_name | varchar(255) | NOT NULL | Member's complete name |
| date_of_birth | date | NOT NULL | Birth date |
| gender | enum('male', 'female') | NOT NULL | Gender |
| marital_status | enum('single', 'married', 'divorced', 'widowed') | NOT NULL | Marital status |
| phone | varchar(20) | NOT NULL | Contact phone number |
| email | varchar(255) | NOT NULL, UNIQUE | Email address |
| address | text | NOT NULL | Physical address |
| date_joined | date | NOT NULL | Church membership start date |
| cell | enum('north', 'east', 'south', 'west') | NOT NULL | Cell group assignment |
| profile_image | varchar(255) | NULLABLE | Profile photo path |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Last update time |
| deleted_at | timestamp | NULLABLE | Soft delete timestamp |

**Relationships**:
- `user_id` → `users.id` (ON DELETE SET NULL)

**Business Logic**:
- `user_id` is nullable - not all members need system accounts
- Members can exist without user accounts (for record-keeping)
- User accounts can exist without member records (for staff/admin)

**Indexes**:
- PRIMARY KEY (id)
- UNIQUE KEY (email)
- INDEX (user_id)
- INDEX (cell)
- INDEX (date_joined)
- INDEX (marital_status)

---

### 3. Events Table
**Purpose**: Church events and activities management

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| title | varchar(255) | NOT NULL | Event name |
| description | text | NULLABLE | Event details |
| date | date | NULLABLE | Event date |
| time | time | NULLABLE | Event time |
| location | varchar(255) | NULLABLE | Event venue |
| created_by | bigint | NULLABLE, FOREIGN KEY | User who created the event |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Last update time |
| deleted_at | timestamp | NULLABLE | Soft delete timestamp |

**Relationships**:
- `created_by` → `users.id` (ON DELETE SET NULL)

**Indexes**:
- PRIMARY KEY (id)
- INDEX (date)
- INDEX (date, time) - Composite index
- INDEX (title)
- INDEX (created_by)

---

### 4. Event Registrations Table
**Purpose**: Track event attendance registrations

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| event_id | bigint | NULLABLE, FOREIGN KEY | Reference to event |
| member_id | bigint | NULLABLE, FOREIGN KEY | Reference to church member |
| guest_first_name | varchar(255) | NULLABLE | Guest's first name (non-members) |
| guest_last_name | varchar(255) | NULLABLE | Guest's last name (non-members) |
| guest_email | varchar(255) | NULLABLE | Guest's email (non-members) |
| guest_phone | varchar(255) | NULLABLE | Guest's phone (non-members) |
| created_at | timestamp | NULLABLE | Registration time |
| updated_at | timestamp | NULLABLE | Last update time |

**Relationships**:
- `event_id` → `events.id` (ON DELETE CASCADE)
- `member_id` → `members.id` (ON DELETE CASCADE)

**Business Logic**:
- Either `member_id` OR guest fields should be populated
- For church members: use `member_id`, guest fields remain NULL
- For non-members: use guest fields, `member_id` remains NULL

**Indexes**:
- PRIMARY KEY (id)
- INDEX (event_id)
- INDEX (member_id)
- INDEX (guest_email)

---

### 5. Services Table
**Purpose**: Church services and programs catalog

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | varchar(255) | NOT NULL | Service name |
| description | text | NULLABLE | Service details |
| schedule | varchar(255) | NULLABLE | Service schedule |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Last update time |
| deleted_at | timestamp | NULLABLE | Soft delete timestamp |

**Default Services**:
- Counseling (Pastoral counseling and spiritual guidance)
- Baptism (Water baptism ceremony)
- Youth Retreat (Annual youth retreat and activities)

**Indexes**:
- PRIMARY KEY (id)
- INDEX (name)

---

### 6. Service Registrations Table
**Purpose**: Track service participation requests

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| service_id | bigint | NOT NULL, FOREIGN KEY | Reference to service |
| member_id | bigint | NULLABLE, FOREIGN KEY | Reference to church member |
| guest_full_name | varchar(255) | NULLABLE | Guest's full name (non-members) |
| guest_email | varchar(255) | NULLABLE | Guest's email (non-members) |
| guest_phone | varchar(255) | NULLABLE | Guest's phone (non-members) |
| guest_address | text | NULLABLE | Guest's address (non-members) |
| created_at | timestamp | NULLABLE | Registration time |
| updated_at | timestamp | NULLABLE | Last update time |

**Relationships**:
- `service_id` → `services.id` (ON DELETE CASCADE)
- `member_id` → `members.id` (ON DELETE CASCADE)

**Business Logic**:
- Either `member_id` OR guest fields should be populated
- For church members: use `member_id`, guest fields remain NULL
- For non-members: use guest fields, `member_id` remains NULL

**Indexes**:
- PRIMARY KEY (id)
- INDEX (service_id)
- INDEX (member_id)
- INDEX (guest_email)

---

### 7. Groups Table
**Purpose**: Church groups and cell management

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | varchar(255) | NOT NULL, UNIQUE | Group name |
| description | text | NULLABLE | Group purpose/details |
| meeting_day | varchar(255) | NULLABLE | Regular meeting day |
| location | varchar(255) | NULLABLE | Meeting location |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Last update time |
| deleted_at | timestamp | NULLABLE | Soft delete timestamp |

**Indexes**:
- PRIMARY KEY (id)
- UNIQUE KEY (name)
- INDEX (meeting_day)

---

### 8. Group Member Table (Pivot)
**Purpose**: Many-to-many relationship between groups and members

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| group_id | bigint | NOT NULL, FOREIGN KEY | Reference to group |
| member_id | bigint | NOT NULL, FOREIGN KEY | Reference to member |
| created_at | timestamp | NULLABLE | Membership start time |
| updated_at | timestamp | NULLABLE | Last update time |

**Relationships**:
- `group_id` → `groups.id` (ON DELETE CASCADE)
- `member_id` → `members.id` (ON DELETE CASCADE)

**Constraints**:
- UNIQUE (group_id, member_id) - Prevents duplicate memberships

---

### 9. Announcements Table
**Purpose**: Church announcements and communications

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| title | varchar(255) | NOT NULL | Announcement title |
| message | text | NOT NULL | Announcement content |
| created_by | bigint | NULLABLE, FOREIGN KEY | User who created announcement |
| created_at | timestamp | NULLABLE | Publication time |
| updated_at | timestamp | NULLABLE | Last update time |
| deleted_at | timestamp | NULLABLE | Soft delete timestamp |

**Relationships**:
- `created_by` → `users.id` (ON DELETE SET NULL)

**Indexes**:
- PRIMARY KEY (id)
- INDEX (created_by)
- INDEX (created_at)
- INDEX (title)

---

## Entity Relationship Diagram (ERD)

```
┌─────────────┐       ┌─────────────────┐       ┌─────────────────┐
│    Users    │       │     Events      │       │ Event_Registrations │
├─────────────┤       ├─────────────────┤       ├─────────────────┤
│ id (PK)     │◄──────┤ created_by (FK) │       │ id (PK)         │
│ name        │       │ id (PK)         │◄──────┤ event_id (FK)   │
│ email       │       │ title           │       │ member_id (FK)  │
│ role        │       │ description     │       │ guest_first_name│
│ ...         │       │ date            │       │ guest_last_name │
└─────────────┘       │ time            │       │ guest_email     │
       │               │ location        │       │ guest_phone     │
       │               │ deleted_at      │       └─────────────────┘
       │               └─────────────────┘                │
       │                                                  │
       │                                                  │
┌─────────────┐       ┌─────────────────┐              │
│  Members    │       │    Services     │              │
├─────────────┤       ├─────────────────┤              │
│ id (PK)     │◄──────┤                 │              │
│ user_id(FK) │◄──────┘ id (PK)         │◄─────────────┘
│ full_name   │       │ name            │
│ email       │       │ description     │       ┌─────────────────────┐
│ phone       │       │ schedule        │       │ Service_Registrations│
│ address     │       │ deleted_at      │       ├─────────────────────┤
│ cell        │       └─────────────────┘       │ id (PK)             │
│ deleted_at  │                │                │ service_id (FK)     │◄──┘
└─────────────┘                │                │ member_id (FK)      │◄──┐
       │                       │                │ guest_full_name     │   │
       │                       └────────────────┤ guest_email         │   │
       │                                        │ guest_phone         │   │
       │                                        │ guest_address       │   │
       │                                        └─────────────────────┘   │
       │                                                                  │
       │         ┌─────────────────┐       ┌─────────────────┐           │
       │         │     Groups      │       │  Group_Member   │           │
       │         ├─────────────────┤       ├─────────────────┤           │
       │         │ id (PK)         │◄──────┤ group_id (FK)   │           │
       │         │ name            │       │ member_id (FK)  │◄──────────┘
       │         │ description     │       │ id (PK)         │
       │         │ meeting_day     │       └─────────────────┘
       │         │ location        │
       │         │ deleted_at      │
       │         └─────────────────┘
       │
       │         ┌─────────────────┐
       │         │ Announcements   │
       │         ├─────────────────┤
       └─────────┤ created_by (FK) │
                 │ id (PK)         │
                 │ title           │
                 │ message         │
                 │ deleted_at      │
                 └─────────────────┘
```

## Key Relationships Summary

1. **Users → Members**: One-to-one optional (users can have member profiles)
2. **Users → Events**: One-to-many (users can create multiple events)
3. **Users → Announcements**: One-to-many (users can create multiple announcements)
4. **Events → Event Registrations**: One-to-many (events can have multiple registrations)
5. **Members → Event Registrations**: One-to-many (members can register for multiple events)
6. **Services → Service Registrations**: One-to-many (services can have multiple registrations)
7. **Members → Service Registrations**: One-to-many (members can register for multiple services)
8. **Groups ↔ Members**: Many-to-many (members can join multiple groups, groups have multiple members)

## Data Integrity Features

### Foreign Key Constraints
- All relationships are enforced with foreign key constraints
- Cascade deletes where appropriate (registrations deleted when parent is deleted)
- Set NULL for optional relationships (created_by fields)

### Soft Deletes
- Members, Events, Services, Groups, and Announcements use soft deletes
- Prevents accidental data loss
- Maintains referential integrity for historical records

### Indexes
- Strategic indexes on frequently queried columns
- Composite indexes for common query patterns
- Unique constraints where business logic requires

### Validation Rules
- Enum constraints for controlled vocabularies (gender, marital_status, cell, role)
- NOT NULL constraints for required fields
- Unique constraints for business keys (email addresses, group names)

## Performance Considerations

### Optimized Queries
- Indexes on foreign keys for efficient joins
- Composite indexes for date/time queries
- Text search indexes on titles and names

### Scalability
- Normalized structure reduces data redundancy
- Proper indexing supports large datasets
- Soft deletes maintain performance while preserving data

## Migration History
The database structure was built incrementally with the following key improvements:
1. Initial table creation
2. Foreign key constraint addition
3. Naming convention standardization (camelCase → snake_case)
4. Data normalization (member vs guest registrations)
5. Service enum replacement with relational structure
6. Performance index addition
7. Soft delete implementation
8. Redundant column removal

This structure provides a solid foundation for a production church management system with room for future enhancements and scaling.
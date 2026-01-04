# Bible Engine Refactoring Plan

## Overview
This document outlines the refactoring plan to modularize the codebase and separate production and development environments.

## 1. Environment Configuration

### Status: ✅ COMPLETE
- **File**: `utils/env_config.php`
- **Functionality**: 
  - Automatically detects environment (prod/dev) based on hostname
  - Production: `https://bibleengine.ai`
  - Development: `https://bibledev.com`
  - Can be overridden with `BIBLEENGINE_ENV` environment variable

### Usage
All files should include `utils/env_config.php` at the top to get environment-specific configuration:
```php
require_once(__DIR__ . '/utils/env_config.php');
```

## 2. API Structure

### Current State
- `api_old.php` - Legacy API (old implementation)
- `api.php` - New clean API endpoint (modular structure)
- `ai.php` - AI-based backend (currently a clone of `api.php`)

### Action Items
1. ✅ `api.php` is already a clean, modular backend API
2. ✅ `ai.php` is already a clone of `api.php`
3. ⚠️ Verify `api_old.php` contains the old implementation

## 3. Utility Modules

### Created Utilities

#### ✅ `utils/book_utils.php`
- Contains all Bible book name arrays
- Book lookup functions
- Book ID conversion functions

#### ✅ `utils/db_utils.php` (already exists)
- Database connection management
- Query execution with error handling
- SQL escaping utilities

#### ✅ `utils/text_utils.php` (already exists)
- Text encoding fixes
- Strong's code processing
- Formatting tag processing
- Bible text processing pipeline

#### ✅ `utils/wiki_utils.php` (newly created)
- Wiki search functionality
- Wiki content retrieval
- Wiki API integration

#### ✅ `utils/env_config.php` (already exists, updated)
- Environment detection
- Configuration management
- URL base management

## 4. Frontend/Backend Separation

### Frontend: `index.php`
- **Purpose**: User-facing web interface
- **Responsibilities**:
  - Form rendering
  - User input handling
  - Display formatting
  - UI interactions

### Backend: `api.php`
- **Purpose**: API endpoint for programmatic access
- **Responsibilities**:
  - Request processing
  - Data retrieval
  - Response formatting (JSON, text, HTML)
  - Error handling

### AI Backend: `ai.php`
- **Purpose**: AI-enhanced Bible search and retrieval
- **Status**: Currently a clone of `api.php`
- **Future**: Will be enhanced with AI capabilities

## 5. Next Steps

### Immediate Actions
1. ✅ Create utility modules (book_utils.php, wiki_utils.php)
2. ✅ Update env_config.php for dev/prod separation
3. ⏳ Refactor `index.php` to use utility modules
4. ⏳ Extract form rendering to separate module
5. ⏳ Extract query parsing to separate module
6. ⏳ Extract SQL building to separate module

### Code Organization
```
bibleengine/
├── index.php              # Frontend (to be refactored)
├── api.php                # Backend API (clean, modular)
├── api_old.php            # Legacy API
├── ai.php                 # AI backend (clone of api.php)
├── utils/
│   ├── env_config.php     # Environment configuration
│   ├── db_utils.php       # Database utilities
│   ├── text_utils.php     # Text processing utilities
│   ├── book_utils.php     # Book name utilities
│   └── wiki_utils.php     # Wiki utilities
├── config.php             # Application configuration
├── lang.php               # Internationalization
└── common.php             # Common functions
```

## 6. Branch Strategy

### Production Branch: `main`
- Domain: `https://bibleengine.ai`
- Stable, tested code
- Production configuration

### Development Branch: `dev`
- Domain: `https://bibledev.com`
- Experimental features
- Development configuration
- Can have different features enabled

### Configuration Differences
- **Production**: 
  - `short_url_base`: `https://bibleengine.ai`
  - `sitename`: `BibleEngine.ai`
  - `engine_name_en`: `Goshen Bible Engine`
  
- **Development**:
  - `short_url_base`: `https://bibledev.com`
  - `sitename`: `BibleDev.com`
  - `engine_name_en`: `Goshen Bible Engine (Dev)`

## 7. Refactoring Progress

- [x] Environment configuration system
- [x] Utility module structure
- [x] Book name utilities
- [x] Wiki utilities
- [ ] Form rendering utilities
- [ ] Query parsing utilities
- [ ] SQL building utilities
- [ ] Refactor index.php to use utilities
- [ ] Reduce index.php file size
- [ ] Test all functionality
- [ ] Update documentation

## Notes

- All utilities should be in `utils/` directory
- All utilities should use `require_once` for dependencies
- Environment detection is automatic but can be overridden
- Backward compatibility should be maintained where possible


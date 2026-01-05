# Frontend-Backend API Communication

## Overview

The Bible Engine uses a RESTful API architecture where the frontend (JavaScript) communicates with backend APIs via HTTP requests and JSON responses.

## Communication Flow

### 1. **Frontend (JavaScript in `index.php`)**

**Search Button (Regular Search):**
- User clicks "Search" button
- Form submits via GET request to `index.php`
- Server-side PHP processes the request
- Returns HTML page with results

**AI Button (AI Search):**
- User clicks "AI" button
- JavaScript intercepts the click (prevents form submission)
- JavaScript collects all form parameters
- Makes HTTP GET request to `/api/ai` endpoint
- Receives JSON response
- Displays results in a dedicated container below the form

### 2. **Backend API (`/api/ai`)**

**Request Format:**
```
GET /api/ai?q={query}&cuvs=cuvs&kjv=kjv&b=0&m=0&e=0
```

**Parameters:**
- `q`: Search query (e.g., "isaiah 41:10")
- `cuvs`, `cuvt`, `kjv`, `nasb`, `esv`: Translation flags
- `b`: Book filter (0 = whole Bible)
- `m`: Multi-verse flag (0 or 1)
- `e`: Context/extension (0-5 verses)

**Response Format: JSON**

Success Response:
```json
{
  "success": true,
  "data": [
    {
      "reference": "AI Search",
      "text": "AI search functionality is under development. Your query: isaiah 41:10"
    }
  ],
  "count": 1,
  "query": "isaiah 41:10"
}
```

Error Response:
```json
{
  "success": false,
  "error": "Error message here",
  "file": "config.php",
  "line": 7,
  "type": "Load Error"
}
```

### 3. **Frontend Processing**

**JavaScript (`handleAISearch()` function):**
1. Collects form data (query, translations, options)
2. Builds URL with query parameters
3. Makes `fetch()` request to `/api/ai`
4. Parses JSON response
5. Calls `displayAIResults()` to render results

**Result Display (`displayAIResults()` function):**
- Creates a results container below the form
- Displays results in a formatted list
- Shows error messages if API fails
- Scrolls to results automatically

## Response Format

**Yes, the response format is JSON.**

The API always returns JSON with this structure:
- `success`: boolean (true/false)
- `data`: array of result objects (on success)
- `error`: string error message (on failure)
- `count`: number of results (on success)
- `query`: the original query (on success)

## API Endpoints

- **Regular API**: `/api/` or `/api/index.php`
  - Same JSON format
  - Uses regular database search

- **AI API**: `/api/ai` or `/api/ai.php`
  - Same JSON format
  - Uses AI-enhanced search (currently placeholder)

## Example Request/Response

**Request:**
```
GET /api/ai?q=isaiah+41%3A10&cuvs=cuvs&kjv=kjv&b=0&m=0&e=0
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "reference": "AI Search",
      "text": "AI search functionality is under development. Your query: isaiah 41:10"
    }
  ],
  "count": 1,
  "query": "isaiah 41:10"
}
```

## Error Handling

The frontend handles errors by:
1. Checking `response.ok` status
2. Parsing error JSON if available
3. Displaying error message in alert and results container
4. Logging to browser console

The backend handles errors by:
1. Catching exceptions and fatal errors
2. Logging to PHP error log
3. Returning JSON error response with details
4. Setting HTTP 500 status code


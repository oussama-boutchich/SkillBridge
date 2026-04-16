/**
 * SkillBridge — API Client
 *
 * Centralised fetch wrapper. All API calls go through here.
 * Handles: Content-Type, credentials, error unwrapping.
 */

// Base URL: adjust if your XAMPP runs the backend at a different sub-path
const API_BASE = '/SkillBridge/CODE/backend/api';

/**
 * Core request function.
 *
 * @param {string} endpoint  Path starting with / e.g. '/auth/login'
 * @param {object} options   Fetch options (method, body, etc.)
 * @returns {Promise<any>}   Resolves with response.data, rejects with error message
 */
async function apiRequest(endpoint, options = {}) {
    const url = API_BASE + endpoint;

    const config = {
        credentials: 'include',   // send session cookie
        headers: {
            'Content-Type': 'application/json',
            ...(options.headers || {}),
        },
        ...options,
    };

    // Don't send Content-Type for FormData (multipart uploads)
    if (options.body instanceof FormData) {
        delete config.headers['Content-Type'];
    }

    const response = await fetch(url, config);
    let data;

    try {
        data = await response.json();
    } catch {
        throw new Error('Invalid JSON response from server.');
    }

    if (!data.success) {
        // Re-throw the structured error so callers can catch it
        const err = new Error(
            typeof data.error === 'string'
                ? data.error
                : JSON.stringify(data.error)
        );
        err.status  = response.status;
        err.errors  = typeof data.error === 'object' ? data.error : null;
        throw err;
    }

    return data.data;
}

/** Convenience API object. */
const api = {
    get:    (endpoint, params = {}) => {
        const qs = new URLSearchParams(params).toString();
        return apiRequest(endpoint + (qs ? '?' + qs : ''));
    },
    post:   (endpoint, body)  => apiRequest(endpoint, { method: 'POST',   body: JSON.stringify(body) }),
    put:    (endpoint, body)  => apiRequest(endpoint, { method: 'PUT',    body: JSON.stringify(body) }),
    patch:  (endpoint, body)  => apiRequest(endpoint, { method: 'PATCH',  body: JSON.stringify(body) }),
    delete: (endpoint)        => apiRequest(endpoint, { method: 'DELETE' }),
};

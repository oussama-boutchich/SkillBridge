/**
 * SkillBridge — Auth State Manager
 *
 * Manages login state in sessionStorage.
 * Every protected page calls auth.requireRole() on load.
 */

const auth = {
    /** Fetch current user from /api/auth/me. Stores in sessionStorage. */
    async check() {
        try {
            const user = await api.get('/auth/me');
            sessionStorage.setItem('sb_user', JSON.stringify(user));
            return user;
        } catch {
            sessionStorage.removeItem('sb_user');
            return null;
        }
    },

    /** Return cached user from sessionStorage (no network). */
    getUser() {
        const raw = sessionStorage.getItem('sb_user');
        return raw ? JSON.parse(raw) : null;
    },

    /**
     * Ensure the current user is authenticated and has the correct role.
     * Redirects to login or to their own dashboard if not.
     *
     * @param {'student'|'company'|'admin'} role Required role.
     */
    async requireRole(role) {
        // Try cached user first, then fall back to network check
        let user = this.getUser();
        if (!user) {
            user = await this.check();
        }
        if (!user) {
            window.location.href = '/SkillBridge/CODE/frontend/pages/auth/login.html';
            return null;
        }
        if (user.role !== role) {
            window.location.href = this.dashboardUrl(user.role);
            return null;
        }
        return user;
    },

    /** Logout: call API, clear storage, redirect to login. */
    async logout() {
        try { await api.post('/auth/logout'); } catch { /* ignore */ }
        sessionStorage.removeItem('sb_user');
        window.location.href = '/SkillBridge/CODE/frontend/pages/auth/login.html';
    },

    /** Return the dashboard URL for a given role. */
    dashboardUrl(role) {
        const map = {
            student: '/SkillBridge/CODE/frontend/pages/student/dashboard.html',
            company: '/SkillBridge/CODE/frontend/pages/company/dashboard.html',
            admin:   '/SkillBridge/CODE/frontend/pages/admin/dashboard.html',
        };
        return map[role] ?? '/SkillBridge/CODE/frontend/pages/auth/login.html';
    },
};

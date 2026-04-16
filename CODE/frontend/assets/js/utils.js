/**
 * SkillBridge — Utility Functions
 */

const utils = {
    /** Format an ISO date string to e.g. "Apr 11, 2026" */
    formatDate(dateString) {
        if (!dateString) return '—';
        return new Intl.DateTimeFormat('en-GB', {
            year: 'numeric', month: 'short', day: 'numeric',
        }).format(new Date(dateString));
    },

    /** Relative time: "2 hours ago", "3 days ago" */
    timeAgo(dateString) {
        if (!dateString) return '';
        const diff = Date.now() - new Date(dateString).getTime();
        const mins  = Math.floor(diff / 60000);
        const hours = Math.floor(mins / 60);
        const days  = Math.floor(hours / 24);
        if (mins  < 1)  return 'Just now';
        if (mins  < 60) return `${mins}m ago`;
        if (hours < 24) return `${hours}h ago`;
        if (days  < 7)  return `${days}d ago`;
        return utils.formatDate(dateString);
    },

    /** Safely escape HTML to prevent XSS when using innerHTML. */
    escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = String(str ?? '');
        return div.innerHTML;
    },

    /** Truncate text to maxLen chars with ellipsis. */
    truncate(str, maxLen = 120) {
        if (!str) return '';
        return str.length > maxLen ? str.slice(0, maxLen).trim() + '…' : str;
    },

    /** Get initials from a full name (max 2 letters). */
    initials(name = '') {
        return name.split(' ')
            .filter(Boolean)
            .slice(0, 2)
            .map(w => w[0].toUpperCase())
            .join('');
    },

    /** Show/hide a form error element. Pass null/'' to clear it. */
    setError(elementId, message) {
        const el = document.getElementById(elementId);
        if (!el) return;
        el.textContent = message || '';
        el.style.display = message ? 'block' : 'none';
    },

    /** Toggle button loading state. */
    setLoading(btnElement, isLoading) {
        if (!btnElement) return;
        if (isLoading) {
            btnElement.classList.add('loading');
            btnElement.disabled = true;
        } else {
            btnElement.classList.remove('loading');
            btnElement.disabled = false;
        }
    },

    /** Read URL query params. */
    getParam(name) {
        return new URLSearchParams(window.location.search).get(name);
    },
};

/* ── Toast notification system ──────────────────────────────────────────── */
const toast = {
    container: null,

    icons: {
        success: '<i class="fa-solid fa-circle-check"></i>',
        error:   '<i class="fa-solid fa-circle-xmark"></i>',
        warning: '<i class="fa-solid fa-triangle-exclamation"></i>',
        info:    '<i class="fa-solid fa-circle-info"></i>',
    },

    init() {
        if (!this.container) {
            this.container = document.getElementById('toast-container') || document.createElement('div');
            if (!this.container.id) {
                this.container.id = 'toast-container';
                this.container.className = 'toast-container';
                document.body.appendChild(this.container);
            }
        }
    },

    show(type, title, message = '', duration = 4000) {
        this.init();

        const el = document.createElement('div');
        el.className = `toast toast--${type}`;
        el.innerHTML = `
            <span class="toast__icon">${this.icons[type] ?? this.icons.info}</span>
            <div class="toast__body">
                <div class="toast__title">${utils.escapeHtml(title)}</div>
                ${message ? `<div class="toast__message">${utils.escapeHtml(message)}</div>` : ''}
            </div>
            <button class="toast__close" aria-label="Dismiss">&times;</button>
        `;

        const close = () => {
            el.classList.add('hiding');
            setTimeout(() => el.remove(), 300);
        };

        el.querySelector('.toast__close').addEventListener('click', close);
        this.container.appendChild(el);
        setTimeout(close, duration);
    },

    success: (title, msg, dur) => toast.show('success', title, msg, dur),
    error:   (title, msg, dur) => toast.show('error',   title, msg, dur),
    warning: (title, msg, dur) => toast.show('warning', title, msg, dur),
    info:    (title, msg, dur) => toast.show('info',    title, msg, dur),
};

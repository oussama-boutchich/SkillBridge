<?php
/**
 * SkillBridge — Application Constants
 */

declare(strict_types=1);

class AppConstants
{
    // User roles
    public const ROLE_STUDENT = 'student';
    public const ROLE_COMPANY = 'company';
    public const ROLE_ADMIN   = 'admin';

    // Application statuses
    public const STATUS_PENDING  = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';

    // Post types
    public const TYPE_INTERNSHIP = 'internship';
    public const TYPE_JOB        = 'job';
    public const TYPE_CHALLENGE  = 'challenge';

    // Post statuses
    public const POST_ACTIVE = 'active';
    public const POST_CLOSED = 'closed';
    public const POST_DRAFT  = 'draft';

    // Notification types
    public const NOTIF_APP_ACCEPTED = 'application_accepted';
    public const NOTIF_APP_REJECTED = 'application_rejected';
    public const NOTIF_NEW_APP      = 'new_application';
    public const NOTIF_SYSTEM       = 'system';

    // Feed activity types
    public const FEED_CERT_ADDED     = 'certificate_added';
    public const FEED_POST_CREATED   = 'post_created';
    public const FEED_APP_SUBMITTED  = 'application_submitted';

    // Admin log actions
    public const LOG_BAN_USER    = 'ban_user';
    public const LOG_UNBAN_USER  = 'unban_user';
    public const LOG_DELETE_POST = 'delete_post';
    public const LOG_SYSTEM      = 'system_event';
}

<?php

final class Permissions
{
    public const VIEW_DASHBOARD = 'view_dashboard';
    public const MANAGE_USERS = 'manage_users';
    public const MANAGE_ROLES = 'manage_roles';
    public const MANAGE_PERMISSIONS = 'manage_permissions';
    public const MANAGE_PLACES = 'manage_places';
    public const MANAGE_HOTELS = 'manage_hotels';
    public const MANAGE_BOOKINGS = 'manage_bookings';
    public const APPROVE_POSTS = 'approve_posts';
    public const DELETE_POSTS = 'delete_posts';
    public const MANAGE_CONTACTS = 'manage_contacts';

    public const ADMIN_AREA = [
        self::VIEW_DASHBOARD,
        self::MANAGE_USERS,
        self::MANAGE_ROLES,
        self::MANAGE_PERMISSIONS,
        self::MANAGE_PLACES,
        self::MANAGE_HOTELS,
        self::MANAGE_BOOKINGS,
        self::APPROVE_POSTS,
        self::DELETE_POSTS,
        self::MANAGE_CONTACTS,
    ];
}

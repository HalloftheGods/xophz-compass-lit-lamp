# Xophz Magic Lamp

> **Category:** Castle Walls · **Version:** 0.0.1

Shed light on the dungeons of your castle.

## Description

**Magic Lamp** (Lit Lamp) is a site monitoring and activity logging plugin for COMPASS. It illuminates the dark corners of your WordPress installation by tracking user activity, system events, and configuration changes — providing a comprehensive audit trail.

### Core Capabilities

- **Activity Logging** – Track user logins, post edits, plugin activations, and settings changes.
- **System Monitoring** – Monitor server health, cron job execution, and error rates.
- **Audit Trail** – Full timeline of who did what, when, and where.
- **Alert System** – Configurable notifications for critical events.

## Requirements

- **Xophz COMPASS** parent plugin (active)
- WordPress 5.8+, PHP 7.4+

## Installation

1. Ensure **Xophz COMPASS** is installed and active.
2. Upload `xophz-compass-lit-lamp` to `/wp-content/plugins/`.
3. Activate through the Plugins menu.
4. Access via the My Compass dashboard → **Lit Lamp**.

## Frontend Routes

| Route | View | Description |
|---|---|---|
| `/lit-lamp` | Dashboard | Activity log timeline, system health, and alerts |

## Changelog

### 0.0.1

- Initial scaffolding with plugin bootstrap and COMPASS integration

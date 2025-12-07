# Google Drive Integration Features

## Overview
This Laravel application includes enhanced Google Drive integration for saving and sharing invoices directly from the application.

## Features Implemented

### 1. Save to Google Drive
- Save invoices as PDF files directly to the user's Google Drive
- Maintains proper OAuth2 authentication and token refresh

### 2. Sharing Options
The application now supports multiple sharing options:

#### Private Storage (Default)
- Files are saved to the user's Google Drive but kept private
- Only the file owner can access the files

#### Public Link Sharing
- Creates a shareable link that anyone with the link can access
- Useful for sharing invoices with clients who don't have Google accounts

#### Email Sharing
- Shares the invoice directly with a specific email address
- The recipient receives access to the file in their Google Drive

## Technical Implementation

### Controllers
- `FactureController::saveToDrive()` - Enhanced to support sharing options
- `GoogleDriveController` - Handles OAuth2 authentication flow

### Frontend
- Updated invoice list view with multiple sharing options
- Modal for email-based sharing
- Visual indicators for different sharing types

### Security
- Proper OAuth2 token management with refresh token handling
- Access control to ensure users can only access their own invoices
- Input validation for email addresses

## Configuration
The application requires the following environment variables:
- `GOOGLE_DRIVE_CLIENT_ID`
- `GOOGLE_DRIVE_CLIENT_SECRET`
- `GOOGLE_DRIVE_REFRESH_TOKEN` (obtained during OAuth flow)

## API Usage
The enhanced `saveToDrive` method accepts the following parameters:
- `share_type`: 'private', 'anyone_with_link', or 'specific_email'
- `email`: Required when `share_type` is 'specific_email'
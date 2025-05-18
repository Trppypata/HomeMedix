# HomeMedix PHP Chatbot

This is a PHP-based chatbot replacement for the HomeMedix healthcare website. The chatbot provides users with information about services, health conditions, and general inquiries.

## Installation

1. Make sure the following files are in place:
   - `backend/chatbot.php` - The PHP backend for the chatbot
   - `user/chatbot.php` - The UI component for the chatbot
   - `backend/chatbot_tables.sql` - The SQL schema for the chatbot database tables

2. If you haven't already, import the SQL tables required for the chatbot:
   ```
   mysql -u username -p homemedix_db < backend/chatbot_tables.sql
   ```
   Alternatively, you can use phpMyAdmin to import the SQL file.

3. To include the chatbot on a page, add the following code before the closing `</body>` tag:
   ```php
   <!-- Include PHP Chatbot -->
   <?php include('chatbot.php'); ?>
   ```

## Features

- **Session-based chat history**: The chatbot remembers conversations within a user's session
- **Suggested questions**: Provides users with suggestion buttons for common follow-up questions
- **Database-driven responses**: Pulls information about services and illnesses from the database
- **Keyword matching**: Identifies user intents based on keywords in their messages
- **Typing indicators**: Shows a "typing" animation while fetching responses

## Customization

To add more responses to the chatbot:

1. Edit the `getBotResponse()` function in `backend/chatbot.php`
2. Add new entries to the `$responses` array for additional keywords
3. Or add more records to the `services` and `illnesses` tables in the database

## Troubleshooting

- If the chatbot doesn't appear, check that Font Awesome is included in your page
- If responses fail to load, verify database connection settings in your config.php
- For missing suggested questions, ensure the PHP backend is returning the suggestions array

## Credits

Developed for HomeMedix healthcare service.

## License

Internal use only - HomeMedix 2024. 
#!/bin/bash
# Start Redis in the background
redis-server --daemonize yes

# Start Vite in the background
npm run dev &

# Start Laravel
php artisan serve
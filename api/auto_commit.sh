#!/bin/bash

WATCH_DIR="/mnt/863ed1b0-d5c2-47f4-b344-80cd59e7a09c/ukom&lsp/laundry/LaundryApp/"
cd "$WATCH_DIR"

while inotifywait -r -e modify,create,delete "$WATCH_DIR"; do
    git add .
    git commit -m "Auto commit $(date)"
    git push origin main
done

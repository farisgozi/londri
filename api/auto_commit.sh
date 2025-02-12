#!/bin/bash

WATCH_DIR="/mnt/863ed1b0-d5c2-47f4-b344-80cd59e7a09c/ukom&lsp/laundry/LaundryApp/"
cd "$WATCH_DIR"

while inotifywait -r -e modify,create,delete "$WATCH_DIR"; do
    # Cek perubahan yang terjadi
    CHANGED_FILES=$(git status --short)
    
    # Jika tidak ada perubahan, lewati commit
    if [ -z "$CHANGED_FILES" ]; then
        continue
    fi
    
    # Buat commit message otomatis berdasarkan file yang diubah
    COMMIT_MSG="Update $(date '+%d-%m-%Y %H:%M:%S'):"
    
    # Loop setiap file yang berubah dan tambahkan ke commit message
    while IFS= read -r line; do
        FILE_PATH=$(echo "$line" | awk '{print $2}')
        
        # Deteksi jenis perubahan
        if [[ "$line" == \ M* ]]; then
            COMMIT_MSG+=" [Modified] $FILE_PATH"
        elif [[ "$line" == \ A* ]]; then
            COMMIT_MSG+=" [Added] $FILE_PATH"
        elif [[ "$line" == \ D* ]]; then
            COMMIT_MSG+=" [Deleted] $FILE_PATH"
        fi
    done <<< "$CHANGED_FILES"
    
    # Eksekusi commit dan push
    git add .
    git commit -m "$COMMIT_MSG"
    git push origin main
done


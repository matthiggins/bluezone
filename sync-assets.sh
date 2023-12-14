#!/bin/bash

# GitHub user and repository
USER="pubg"
REPO="api-assets"
GITHUB_DIR="dictionaries"  # Directory on GitHub
LOCAL_DIR="src/assets/dictionaries"  # Local directory where files will be saved

# API URL to fetch content list
API_URL="https://api.github.com/repos/$USER/$REPO/contents"

# Function to download files recursively
download_files() {
    local github_path="$1"
    local local_path="$2"

    # Fetch content list from GitHub API
    local contents=$(curl -s "$API_URL/$github_path")

    # Parse directories and files
    echo "$contents" | grep '"type":' | while read -r type_line; do
        local type=$(echo "$type_line" | cut -d '"' -f 4)
        local name_line=$(echo "$contents" | grep -m 1 '"name":')
        local name=$(echo "$name_line" | cut -d '"' -f 4)
        contents=$(echo "$contents" | sed -e "1,/\"name\":/d")

        if [ "$type" == "dir" ]; then
            # Recursive call for directories
            mkdir -p "$local_path/$name"
            download_files "$github_path/$name" "$local_path/$name"
        else
            # Download file for file types
            local download_url=$(echo "$contents" | grep -m 1 '"download_url":' | cut -d '"' -f 4)
            contents=$(echo "$contents" | sed -e "1,/\"download_url\":/d")

            echo "Downloading $local_path/$name..."
            curl -s -L "$download_url" -o "$local_path/$name"
        fi
    done
}

echo "Sync process started..."

# Start the recursive download process
mkdir -p "$LOCAL_DIR"
download_files "$GITHUB_DIR" "$LOCAL_DIR"

# Count the number of files synced
FILE_COUNT=$(find $LOCAL_DIR -type f | wc -l)

echo "Total files synced: $FILE_COUNT"

echo "Sync process ended."

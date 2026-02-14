# Simple sync script for Health and Safety project
$commitMessage = Read-Host "Enter commit message"
if (-not $commitMessage) { $commitMessage = "Auto-sync: $(Get-Date)" }

Write-Host "--- Pushing local changes to GitHub ---" -ForegroundColor Cyan
git add .
git commit -m $commitMessage
git push origin main

Write-Host "--- Updating Remote Server (72.60.209.226) ---" -ForegroundColor Cyan
ssh root@72.60.209.226 "cd /var/www/Healthandsafety && git stash && git pull && git stash pop"

Write-Host "--- Sync Complete! ---" -ForegroundColor Green

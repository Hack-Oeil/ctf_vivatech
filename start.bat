@echo off
echo                             ______           __              __            
echo                            / ____/_  _______/ /_  ____ _____/ /__  _____   
echo                           / /   / / / / ___/ __ \/ __  / __  / _ \/ ___/   
echo                          / /___/ /_/ / /  / / / / /_/ / /_/ /  __(__  )    
echo                          \____/\__, /_/  /_/ /_/\__,_/\__,_/\___/____/     
echo                               /____/                  2024 - Cyrhades        
echo.
pause
docker-compose -p vivatech-challenge -f docker-compose.yml up
pause
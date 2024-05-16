@echo off
echo.
echo                             ______           __              __            
echo                            / ____/_  _______/ /_  ____ _____/ /__  _____   
echo                           / /   / / / / ___/ __ \/ __  / __  / _ \/ ___/   
echo                          / /___/ /_/ / /  / / / / /_/ / /_/ /  __(__  )    
echo                          \____/\__, /_/  /_/ /_/\__,_/\__,_/\___/____/     
echo                               /____/                  2024 - Cyrhades        
echo.
echo.
echo.
echo.
setlocal enabledelayedexpansion

rem Demander à l'utilisateur de saisir la plage d'adresses IP
set /p "network=Entrez la plage d'adresses IP (par defaut 192.168.1.): "

rem Utiliser la valeur par défaut si aucune valeur n'est saisie
if "%network%"=="" (
    set "network=192.168.1."
)

rem Spécifiez l'adresse MAC à rechercher
set "target_mac=00-17-88-21-8c-fe"

rem Définir une variable pour stocker l'adresse IP associée à l'adresse MAC cible
set "ip_associated="

echo Recherche du pont Philips Hue de %network%1 a %network%255

rem Recherche de l'adresse IP associée à l'adresse MAC cible dans la table ARP
for /f "tokens=1,2" %%a in ('arp -a ^| findstr "%target_mac%"') do (
    if "%%b" == "%target_mac%" (
        set "ip_associated=%%a"
        rem Sortir de la boucle après avoir trouvé la première occurrence
        goto :end_ping
    )
)

rem Ping chaque adresse IP dans la plage réseau
for /L %%i in (1,1,254) do (
    set "ip=!network!%%i"
    echo Test en cours pour !ip!
    ping -w 10 -n 1 !ip! >nul

    rem Recherche de l'adresse IP associée à l'adresse MAC cible dans la table ARP
    for /f "tokens=1,2" %%a in ('arp -a ^| findstr "%target_mac%"') do (
        if "%%b" == "%target_mac%" (
            set "ip_associated=%%a"
            rem Sortir de la boucle après avoir trouvé la première occurrence
            goto :end_ping
        )
    )
)

:end_ping

rem Vérifie si une adresse IP associée a été trouvée
if defined ip_associated (
    echo L'adresse IP associee au pont Philips HUE "Adresse MAC %target_mac%" est : !ip_associated!
) else (
    echo Impossible de trouver une adresse IP pour l'adresse MAC %target_mac%
)
pause
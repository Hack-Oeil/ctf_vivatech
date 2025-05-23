FROM nginx:1-alpine-slim

# Copier les fichiers HTML dans le répertoire par défaut de Nginx
COPY ./web /usr/share/nginx/html

# Exposer le port 80
EXPOSE 80

# Démarrer Nginx
CMD ["nginx", "-g", "daemon off;"]
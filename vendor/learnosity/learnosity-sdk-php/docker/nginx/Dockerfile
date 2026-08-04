FROM nginx:stable-alpine

# Copy custom nginx configuration
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

# Optional: Add any additional Nginx-specific configurations or setup
EXPOSE 8000

CMD ["nginx", "-g", "daemon off;"]

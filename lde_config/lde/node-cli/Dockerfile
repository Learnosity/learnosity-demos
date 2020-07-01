FROM node:10

RUN apt-get update \
    && curl https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb -o google-chrome-stable_current_amd64.deb \
    && apt-get install -y ./google-chrome-stable_current_amd64.deb \
    && rm -rf /var/lib/apt/lists/*

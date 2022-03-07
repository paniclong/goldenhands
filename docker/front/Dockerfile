FROM node:16.14-alpine

WORKDIR /app

COPY ./frontend .

RUN npm ci

ENV HOST 0.0.0.0
EXPOSE 3000

ENTRYPOINT ["npm", "run", "dev"]

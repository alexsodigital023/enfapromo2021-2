FROM node:10

WORKDIR /usr/src/app

COPY package*.json ./
COPY ./src ./src

RUN npm install

EXPOSE 3000

CMD ["node", "src/index.js"]
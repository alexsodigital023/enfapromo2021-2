FROM node:10

WORKDIR /usr/src/app

COPY ./src/publicSocket/package*.json ./
COPY ./src/publicSocket/src ./src

RUN npm install

EXPOSE 3000

CMD ["node", "src/index.js"]
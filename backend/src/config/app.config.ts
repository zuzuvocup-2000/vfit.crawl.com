export const appConfig = () => ({
  database: {
    mongo: {
      uri: process.env.MONGO_URI,
    },
  },
  swagger: {
    title: 'Admin API',
    description: 'The Admin API description',
    version: '1.0',
    tag: 'Admin API',
  },
});

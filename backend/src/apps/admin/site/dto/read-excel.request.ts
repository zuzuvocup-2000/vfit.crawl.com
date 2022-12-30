export const SwaggerFileRequest = {
  schema: {
    type: 'object',
    properties: {
      file: {
        type: 'string',
        format: 'binary',
      },
    },
  },
};

export const FormDataRequest = 'multipart/form-data';

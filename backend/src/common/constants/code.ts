export const CODES = {
  /**
   * 2xxx Success code
   */
  SUCCESS: 200,

  /**
   4xxx Permission code
   */
  BAD_REQUEST: 400,
  UNAUTHENTICATED: 401,
  PERMISSION_DENIED: 4003,
  NOT_FOUND: 404,
  METHOD_NOT_ALLOW: 405,

  /**
   * 5xxx Server code
   */
  HTTP_INTERNAL_SERVER_ERROR: 500,

  /**
   * 1xxx Error code
   */
  ERROR_CODE: 100,
  EMAIL_WAS_USED: 101,
  VERIFY_SIGNATURE_FAILED: 102,
};

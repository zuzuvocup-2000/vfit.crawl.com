export const CODES = {
  /**
   * 2xxx Success code
   */
  SUCCESS: 2000,

  /**
   4xxx Permission code
   */
  BAD_REQUEST: 4000,
  UNAUTHENTICATED: 4001,
  PERMISSION_DENIED: 4003,
  NOT_FOUND: 4004,
  METHOD_NOT_ALLOW: 4005,

  /**
   * 5xxx Server code
   */
  HTTP_INTERNAL_SERVER_ERROR: 5000,

  /**
   * 1xxx Error code
   */
  ERROR_CODE: 1000,
  EMAIL_WAS_USED: 1001,
  VERIFY_SIGNATURE_FAILED: 1002,
};
